<?php

namespace App\Console\Commands;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CreateUpdateGoPhishDepartmentUserGroupsCommand extends Command
{
    protected $signature = 'run:go-phish-user-group-departments {--tenants=* : The tenant(s) to run the command for. Default all.}';

    protected $description = 'Command description';

    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
            $this->info('Starting run for tenant: '.$tenant->name);
            $store = Store::first() ?? null;
            $token = $store->phishing_token ?? null;
            $ip = $store->phishing_ip ?? null;

            if ($store === null) {
                $this->info('No store found for tenant: '.$tenant->name);
                return;
            }

            if ($token === null || ! $ip === null) {
                $this->info('No token or IP found for tenant: '.$tenant->name);
                return;
            }

            if ($token && $ip) {
                $this->info('Running for tenant: '.$tenant->name);

                $groups = $this->getGroups($ip, $token);
                $userData = $this->getUsers();

                $this->info('Sending request to Gophish');

                $this->createOrUpdateGroup($groups, $userData, $ip, $token);
            }
        });
    }

    private function getGroups($ip, $token)
    {
        $groups = Http::withoutVerifying()->get('https://'.$ip.':3333/api/groups/?api_key='.$token.'');

        return collect($groups->json())->pluck('id', 'name');
    }

    private function getUsers()
    {
        $users = User::query()
            ->get()
            ->groupBy('department.name');

        return $users->map(function ($departmentUsers, $departmentName) {
            return $departmentUsers->map(function ($user) {
                $splitName = explode(' ', $user->name);
                $firstName = $splitName[0];
                $lastName = isset($splitName[1]) ? $splitName[1] : null;

                return [
                    'email' => $user->email,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'position' => null,
                ];
            });
        })->toArray();

    }

    private function createOrUpdateGroup($groups, $userData, $ip, $token)
    {
        $this->deleteGroups($groups, $userData, $ip, $token);

        foreach ($userData as $department => $users) {
            if (! array_key_exists($department, $groups->toArray())) {
                $this->createGroup($department, $users, $ip, $token);
            } else {
                $this->updateGroup($groups->get($department), $department, $users, $ip, $token);
            }
        }
    }

    private function createGroup($department, $userData, $ip, $token)
    {
        try {
            $requestBody = [
                'name' => $department,
                'targets' => $userData,
            ];

            $response = Http::withHeaders([
                'Authorization' => $token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->withoutVerifying()
                ->post('https://'.$ip.':3333/api/groups/', $requestBody);

            if ($response->status() === 200) {
                $this->info('Group Created');
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    private function updateGroup($groupId, $department, $userData, $ip, $token)
    {
        try {
            $requestBody = [
                'id' => $groupId,
                'name' => $department,
                'targets' => $userData,
            ];

            $response = Http::withHeaders([
                'Authorization' => $token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->withoutVerifying()
                ->put('https://'.$ip.':3333/api/groups/'.$groupId.'', $requestBody);

            if ($response->status() === 200) {
                $this->info('Group Updated');
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    private function deleteGroups($groups, $userData, $ip, $token)
    {
        $departments = array_filter(array_keys($userData));
        $groupNames = array_filter(array_keys($groups->toArray()));
        $diff = array_diff($groupNames, $departments);

        foreach ($diff as $group) {
            if ($group != 'All Employees') {
                $this->info('Deleting group: '.$group);
                $response = Http::withHeaders([
                    'Authorization' => $token,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                    ->withoutVerifying()
                    ->delete('https://'.$ip.':3333/api/groups/'.$groups->get($group).'');
            }
        }
    }
}
