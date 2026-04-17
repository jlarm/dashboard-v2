<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Override;

class CreateUpdateGoPhishDepartmentUserGroupsCommand extends Command
{
    #[Override]
    protected $signature = 'run:go-phish-user-group-departments {--tenants=* : The tenant(s) to run the command for. Default all.}';

    #[Override]
    protected $description = 'Command description';

    protected $token;
    protected $ip;
    protected $groups;

    public function handle(): void
    {
        /** @var Collection<int, string> $tenants */
        $tenants = collect($this->option('tenants'))
            ->filter(static fn (mixed $tenant): bool => is_string($tenant) && $tenant !== '')
            ->values();

        tenancy()->runForMultiple($tenants->isEmpty() ? null : $tenants, function ($tenant): void {

            $globalSetting = GlobalSetting::query()->first();

            if ($globalSetting === null || ! $globalSetting->phishing_active) {
                $this->info('Phishing is disabled for tenant: '.$tenant->name);

                return;
            }

            $this->info('Starting run for tenant: '.$tenant->name);

            $settings = GlobalSetting::query()->first();
            $this->token = $settings->phishing_token;
            $this->ip = $settings->phishing_ip;
            $stores = Store::all();
            $this->groups = $this->getGroups();

            if ($this->groups) {
                $this->deleteGroups();
            }

            foreach ($stores as $store) {
                $userStores = $this->getUsers($store);

                foreach ($userStores as $store => $userData) {
                    foreach ($userData as $department => $users) {
                        $this->createGroup($store.' - '.$department, $users);
                    }
                }
            }

        });
    }

    private function getGroups()
    {
        $groups = Http::withoutVerifying()->get('https://'.$this->ip.':3333/api/groups/?api_key='.$this->token.'');

        return collect($groups->json())
            ->pluck('id', 'name')
            ->reject(fn ($value, $name): bool => str_contains((string) $name, 'All'));
    }

    private function getUsers($store): array
    {
        if (Store::query()->count() > 1) {
            $users = $store->users()->whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer'])->get();
        } else {
            $users = User::query()->whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer'])->get();
        }

        $usersByDepartment = $users->groupBy('department.name')->map(fn ($departmentUsers) => $departmentUsers->map(function ($user): array {
            $splitName = explode(' ', (string) $user->name);
            $firstName = $splitName[0];
            $lastName = $splitName[1] ?? null;

            return [
                'email' => $user->email,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'position' => null,
            ];
        }))->toArray();

        // Return the array with the store name as the first index
        return [$store->name => $usersByDepartment];
    }

    private function createGroup(string $department, $userData): void
    {
        try {
            $requestBody = [
                'name' => $department,
                'targets' => $userData,
            ];

            $response = Http::withHeaders([
                'Authorization' => $this->token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->withoutVerifying()
                ->post('https://'.$this->ip.':3333/api/groups/', $requestBody);

            if ($response->status() === 200) {
                $this->info('Group Created');
            }

        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    private function deleteGroups(): void
    {
        foreach ($this->groups as $group) {
            if ($group !== null) {
                $this->info('Deleting group: '.$group);
                $response = Http::withHeaders([
                    'Authorization' => $this->token,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                    ->withoutVerifying()
                    ->delete('https://'.$this->ip.':3333/api/groups/'.$group.'');
            }
        }
    }
}
