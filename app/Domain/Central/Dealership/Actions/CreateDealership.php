<?php

declare(strict_types=1);

namespace App\Domain\Central\Dealership\Actions;

use App\Domain\Central\Dealership\Data\DealershipData;
use App\Models\Course;
use App\Models\Dealership;
use App\Models\Tenant\Course as TenantCourse;
use App\Models\User;
use App\Notifications\NewDealershipNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use RuntimeException;
use Stancl\Tenancy\Database\Models\Domain;
use Throwable;

class CreateDealership
{
    private const int MAX_DOMAIN_SUFFIX_ATTEMPTS = 100;

    public function handle(User $user, DealershipData $data): Dealership
    {
        $tenantDomain = $this->buildUniqueTenantDomain($data->name);

        $usersToAttach = $this->centralUsersToAttach($user, $data->consultantIds);
        $tenantUserPayloads = $usersToAttach
            ->map(fn (User $u): array => [
                'name' => (string) $u->name,
                'email' => (string) $u->email,
                'phone' => $u->phone,
                'role' => $u->hasRole('super-admin') ? 'super-admin' : 'Consultant',
            ])
            ->values()
            ->all();

        $dealership = Dealership::query()->create([
            'user_id' => $user->id,
            'name' => $data->name,
        ]);

        try {
            $dealership->users()->syncWithoutDetaching($usersToAttach->pluck('id')->all());
            $dealership->createDomain($tenantDomain);

            $dealership->run(function () use ($tenantUserPayloads): void {
                $this->createTenantUsers($tenantUserPayloads);
                $this->syncCentralCourses();
            });
        } catch (Throwable $e) {
            $this->rollbackDealership($dealership);

            throw $e;
        }

        $this->sendNotification($data->name);

        return $dealership;
    }

    private function rollbackDealership(Dealership $dealership): void
    {
        try {
            $dealership->delete();
        } catch (Throwable) {
            // Swallow cleanup failures so the originating exception propagates unchanged.
        }
    }

    private function buildUniqueTenantDomain(string $name): string
    {
        $baseSubdomain = Str::slug($name);
        if ($baseSubdomain === '') {
            $baseSubdomain = 'dealership';
        }

        $centralDomain = (string) config('tenancy.central_domains.0');

        for ($suffix = 1; $suffix <= self::MAX_DOMAIN_SUFFIX_ATTEMPTS; $suffix++) {
            $subdomain = $suffix === 1 ? $baseSubdomain : "{$baseSubdomain}-{$suffix}";
            $domain = "{$subdomain}.{$centralDomain}";

            if (! Domain::query()->where('domain', $domain)->exists()) {
                return $domain;
            }
        }

        throw new RuntimeException("Could not allocate unique tenant domain for '{$name}' after ".self::MAX_DOMAIN_SUFFIX_ATTEMPTS.' attempts.');
    }

    /**
     * @param  array<int, int>  $additionalConsultantIds
     * @return Collection<int, User>
     */
    private function centralUsersToAttach(User $centralUser, array $additionalConsultantIds): Collection
    {
        $users = User::query()->role('super-admin')->get()->push($centralUser);

        if ($additionalConsultantIds !== []) {
            $users = $users->merge(
                User::query()
                    ->whereIn('id', $additionalConsultantIds)
                    ->role('Consultant')
                    ->get()
            );
        }

        return $users->unique('id')->values();
    }

    private function sendNotification(string $dealerName): void
    {
        $email = (string) config('services.dealership.notification_email');

        if ($email === '') {
            return;
        }

        Notification::route('mail', $email)
            ->notify(new NewDealershipNotification($dealerName));
    }

    /**
     * @param  array<int, array{name: string, email: string, phone: string|null, role: string}>  $tenantUserPayloads
     */
    private function createTenantUsers(array $tenantUserPayloads): void
    {
        foreach ($tenantUserPayloads as $tenantUserPayload) {
            $tenantUser = User::query()->firstOrCreate(
                ['email' => $tenantUserPayload['email']],
                [
                    'name' => $tenantUserPayload['name'],
                    'phone' => $tenantUserPayload['phone'],
                    'password' => Hash::make(Str::password(32)),
                ]
            );

            $role = $tenantUserPayload['role'];

            if (! $tenantUser->hasRole($role)) {
                $tenantUser->assignRole($role);
            }
        }
    }

    private function syncCentralCourses(): void
    {
        $centralCourses = tenancy()->central(fn () => Course::query()
            ->select(['id', 'slug', 'slides', 'questions'])
            ->get());

        foreach ($centralCourses as $centralCourse) {
            TenantCourse::query()
                ->where('slug', $centralCourse->slug)
                ->update([
                    'slides' => $centralCourse->slides,
                    'questions' => $centralCourse->questions,
                ]);
        }
    }
}
