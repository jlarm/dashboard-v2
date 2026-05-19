<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Actions;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;
use Spatie\Permission\PermissionRegistrar;

class RegisterInvitedEmployee
{
    private const string DOT_COURSE_SLUG = 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding';

    public function __construct(private readonly PermissionRegistrar $permissionRegistrar) {}

    public function handle(Invite $invite, string $password): User
    {
        $assignedStoreIds = $this->resolveAssignedStoreIds($invite);
        $primaryStoreId = $this->resolvePrimaryStoreId($invite, $assignedStoreIds);

        /** @var array<int, array{course_id: int, taken_on: string}> $dotCompletions */
        $dotCompletions = [];

        /** @var User $user */
        $user = DB::transaction(function () use ($invite, $password, $assignedStoreIds, $primaryStoreId, &$dotCompletions): User {
            $user = User::query()->create([
                'name' => $invite->name,
                'email' => $invite->email,
                'department_id' => $invite->department_id,
                'password' => Hash::make($password),
                'current_store_id' => $assignedStoreIds->count() === 1 ? $assignedStoreIds->first() : null,
                'primary_store_id' => $primaryStoreId,
            ]);

            $dotCompletions = $this->recordInviteCourses($user, $invite);

            if ($assignedStoreIds->isNotEmpty()) {
                $user->stores()->sync($assignedStoreIds->all());
            }

            $user->assignRole(Arr::wrap($invite->roles));
            $user->markEmailAsVerified();

            $invite->delete();

            return $user;
        });

        foreach ($dotCompletions as $completion) {
            $this->generateDotCertificate($user, $completion['taken_on']);
        }

        $this->permissionRegistrar->forgetCachedPermissions();

        return $user->refresh();
    }

    /**
     * @return Collection<int, int>
     */
    private function resolveAssignedStoreIds(Invite $invite): Collection
    {
        $storeIds = collect(Arr::wrap($invite->stores))
            ->map(static fn (mixed $storeId): int => (int) $storeId)
            ->filter()
            ->unique()
            ->values();

        if ($storeIds->isNotEmpty()) {
            return $storeIds;
        }

        $singleStoreId = Store::query()->count() === 1 ? Store::query()->value('id') : null;

        return $singleStoreId === null ? collect() : collect([(int) $singleStoreId]);
    }

    /**
     * @param  Collection<int, int>  $assignedStoreIds
     */
    private function resolvePrimaryStoreId(Invite $invite, Collection $assignedStoreIds): ?int
    {
        $invitePrimary = $invite->primary_store_id === null ? null : (int) $invite->primary_store_id;

        if ($invitePrimary === null || $assignedStoreIds->count() <= 1) {
            return null;
        }

        return $assignedStoreIds->contains($invitePrimary) ? $invitePrimary : null;
    }

    /**
     * @return list<array{course_id: int, taken_on: string}>
     */
    private function recordInviteCourses(User $user, Invite $invite): array
    {
        /** @var array<int|string, string>|null $courses */
        $courses = $invite->courses;

        if (! is_array($courses) || $courses === []) {
            return [];
        }

        $dotCompletions = [];

        foreach ($courses as $courseId => $takenOn) {
            $courseId = (int) $courseId;
            $timestamp = $takenOn.' '.now()->format('H:i:s');

            CourseResults::query()->create([
                'user_id' => $user->id,
                'course_id' => $courseId,
                'percentage' => 100,
                'passed' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);

            $course = Course::query()->find($courseId, ['id', 'slug']);
            if ($course?->slug === self::DOT_COURSE_SLUG) {
                $dotCompletions[] = [
                    'course_id' => $courseId,
                    'taken_on' => (string) $takenOn,
                ];
            }
        }

        return $dotCompletions;
    }

    private function generateDotCertificate(User $user, string $takenOn): void
    {
        $storeName = (string) ($user->currentStore->name ?? tenant('name'));

        $html = view('dealer.course.CertDownloadView', [
            'user' => $user,
            'store' => $storeName,
            'passed_on' => Date::parse($takenOn)->format('F d, Y'),
        ])->render();

        $fileName = Str::slug($user->name).'-'.now()->format('m-d-Y').'-dot-certificate.pdf';
        $filePath = tenant('id').'/'.$user->id.'/'.$fileName;

        Storage::disk('armp-certs')->put($filePath, Browsershot::html($html)->landscape()->pdf());

        Certificate::query()->create([
            'user_id' => $user->id,
            'course_name' => 'DOT Hazardous Materials Transportation',
            'file_name' => $fileName,
        ]);
    }
}
