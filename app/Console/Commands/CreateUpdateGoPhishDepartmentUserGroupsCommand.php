<?php

namespace App\Console\Commands;

use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CreateUpdateGoPhishDepartmentUserGroupsCommand extends Command
{
    protected $signature = 'run:go-phish-user-group-departments {--tenants=* : The tenant(s) to run the command for. Default all.}';

    protected $description = 'Command description';

    protected $token;

    protected $ip;

    protected $groups;

    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {

            $globalSetting = GlobalSetting::first();

            if ($globalSetting === null || $globalSetting->phishing_active === 0 || $globalSetting->phishing_active === null) {
                $this->info('Phishing is disabled for tenant: '.$tenant->name);

                return;
            }

            $this->info('Starting run for tenant: '.$tenant->name);

            $settings = GlobalSetting::first();
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
            ->reject(fn ($value, $name) => str_contains($name, 'All'));
    }

    private function getUsers($store)
    {
        if (tenant('locations')) {
            $users = $store->users()->whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer'])->get();
        } else {
            $users = User::whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer'])->get();
        }

        $usersByDepartment = $users->groupBy('department.name')->map(fn ($departmentUsers) => $departmentUsers->map(function ($user) {
            $splitName = explode(' ', $user->name);
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

    private function createGroup($department, $userData)
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

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    private function deleteGroups()
    {
        foreach ($this->groups as $group) {
            if ($group != null) {
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
