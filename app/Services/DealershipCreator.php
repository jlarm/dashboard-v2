<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Course;
use App\Models\Dealer\Course as TenantCourse;
use App\Models\Dealership;
use App\Models\User;
use App\Notifications\NewDealershipNotification;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stancl\Tenancy\Database\Models\Domain;

class DealershipCreator
{
    private const DEALERSHIP_NOTIFICATION_EMAIL = 'jlohr@autorisknow.com';

    public function create(User $centralUser, string $name): Dealership
    {
        $tenantDomain = $this->buildUniqueTenantDomain($name);

        $dealership = Dealership::query()->create([
            'user_id' => $centralUser->id,
            'name' => $name,
            'domain' => $tenantDomain,
            'locations' => false,
        ]);

        $usersToAttach = $this->centralUsersToAttach($centralUser);
        $tenantUserPayloads = $usersToAttach
            ->map(fn (User $user): array => [
                'name' => (string) $user->name,
                'email' => (string) $user->email,
                'phone' => $user->phone,
                'role' => $user->hasRole('super-admin') ? 'super-admin' : 'Consultant',
            ])
            ->values()
            ->all();

        $dealership->users()->syncWithoutDetaching($usersToAttach->pluck('id')->all());
        $dealership->createDomain($tenantDomain);

        $dealership->run(function () use ($tenantUserPayloads): void {
            $this->createTenantUsers($tenantUserPayloads);
            $this->syncCentralCourses();
        });

        $this->sendNotification($name);

        return $dealership;
    }

    private function buildUniqueTenantDomain(string $name): string
    {
        $baseSubdomain = Str::slug($name);
        if ($baseSubdomain === '') {
            $baseSubdomain = 'dealership';
        }

        $centralDomain = (string) config('tenancy.central_domains.0');
        $suffix = 1;

        while (true) {
            $subdomain = $suffix === 1 ? $baseSubdomain : "{$baseSubdomain}-{$suffix}";
            $domain = "{$subdomain}.{$centralDomain}";

            if (! Domain::query()->where('domain', $domain)->exists()) {
                return $domain;
            }

            $suffix++;
        }
    }

    /**
     * @return Collection<int, User>
     */
    private function centralUsersToAttach(User $centralUser): Collection
    {
        $superAdmins = User::query()
            ->role('super-admin')
            ->get();

        if ($centralUser->hasRole('super-admin')) {
            return $superAdmins->unique('id')->values();
        }

        return $superAdmins
            ->push($centralUser)
            ->unique('id')
            ->values();
    }

    private function sendNotification(string $dealerName): void
    {
        $user = User::query()->where('email', self::DEALERSHIP_NOTIFICATION_EMAIL)->first();

        if (! $user instanceof User) {
            return;
        }

        $user->notify(new NewDealershipNotification($dealerName));
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
                    'password' => Hash::make($this->defaultPasswordFor($tenantUserPayload['name'])),
                ]
            );

            $role = $tenantUserPayload['role'];

            if (! $tenantUser->hasRole($role)) {
                $tenantUser->assignRole($role);
            }
        }
    }

    private function defaultPasswordFor(string $name): string
    {
        return 'Autorisknow'.$this->getInitialsFromName($name).'!';
    }

    private function getInitialsFromName(string $name): string
    {
        $words = preg_split('/\s+/', mb_trim($name)) ?: [];
        $initials = '';

        foreach ($words as $word) {
            if ($word === '') {
                continue;
            }

            $initials .= mb_substr($word, 0, 1);
        }

        return mb_strtoupper($initials);
    }

    private function syncCentralCourses(): void
    {
        $centralCourses = tenancy()->central(fn () => Course::query()
            ->select(['id', 'slug', 'slides', 'questions'])
            ->get());

        foreach ($centralCourses as $centralCourse) {
            $tenantCourse = TenantCourse::query()->where('slug', $centralCourse->slug)->first();

            if (! $tenantCourse instanceof TenantCourse) {
                Log::info('No matching tenant course found for slug: '.$centralCourse->slug);

                continue;
            }

            try {
                $slides = json_decode(json_encode($centralCourse->slides), true);
                $questions = json_decode(json_encode($centralCourse->questions), true);

                DB::statement('UPDATE courses SET slides = ?, questions = ? WHERE id = ?', [
                    json_encode($slides),
                    json_encode($questions),
                    $tenantCourse->id,
                ]);
            } catch (Exception $e) {
                Log::error('Failed to update tenant course: '.$e->getMessage());
            }
        }
    }
}
