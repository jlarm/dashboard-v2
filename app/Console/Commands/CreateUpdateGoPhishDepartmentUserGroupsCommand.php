<?php

namespace App\Console\Commands;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CreateUpdateGoPhishDepartmentUserGroupsCommand extends Command
{
    protected $signature = 'run:go-phish-user-group-departments {--tenants=* : The tenant(s) to run the command for. Default all.}';

    protected $description = 'Command description';

    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
            if (Store::first()->phishing_is_enabled) {
                $this->info('Running for tenant: '.$tenant->name);

                $groups = $this->getGroups();
                $userData = $this->getUsers();

                $this->info('Sending request to Gophish');

                $this->createOrUpdateGroup($groups, $userData);
            }
        });
    }

    private function getGroups()
    {
        $groups = Http::withoutVerifying()->get('https://'.config('gophish.ip').':3333/api/groups/?api_key='.config('gophish.key').'');

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

    private function createOrUpdateGroup($groups, $userData)
    {
        $this->deleteGroups($groups, $userData);

        foreach ($userData as $department => $users) {
            if (! array_key_exists($department, $groups->toArray())) {
                $this->createGroup($department, $users);
            } else {
                $this->updateGroup($groups->get($department), $department, $users);
            }
        }
    }

    private function createGroup($department, $userData)
    {
        try {
            $requestBody = [
                'name' => $department,
                'targets' => $userData,
            ];

            $response = Http::withHeaders([
                'Authorization' => config('gophish.key'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->withoutVerifying()
                ->post('https://'.config('gophish.ip').':3333/api/groups/', $requestBody);

            if ($response->status() === 200) {
                $this->info('Group Created');
            }

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    private function updateGroup($groupId, $department, $userData)
    {
        try {
            $requestBody = [
                'id' => $groupId,
                'name' => $department,
                'targets' => $userData,
            ];

            $response = Http::withHeaders([
                'Authorization' => config('gophish.key'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->withoutVerifying()
                ->put('https://'.config('gophish.ip').':3333/api/groups/'.$groupId.'', $requestBody);

            if ($response->status() === 200) {
                $this->info('Group Updated');
            }

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    private function deleteGroups($groups, $userData)
    {
        $departments = array_filter(array_keys($userData));
        $groupNames = array_filter(array_keys($groups->toArray()));
        $diff = array_diff($groupNames, $departments);

        foreach ($diff as $group) {
            if ($group != 'All Employees') {
                $this->info('Deleting group: '.$group);
                $response = Http::withHeaders([
                    'Authorization' => config('gophish.key'),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                    ->withoutVerifying()
                    ->delete('https://'.config('gophish.ip').':3333/api/groups/'.$groups->get($group).'');
            }
        }
    }
}
