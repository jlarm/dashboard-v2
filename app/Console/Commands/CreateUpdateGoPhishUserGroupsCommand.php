<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CreateUpdateGoPhishUserGroupsCommand extends Command
{
    protected $signature = 'run:go-phish-user-groups {--tenants=* : The tenant(s) to run the command for. Default all.}';

    protected $description = 'Create/Update User Groups for GoPhish';

    public function handle()
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
            $this->info('Running for tenant: ' . $tenant->name);

            $groups = $this->getGroups();
            $userData = $this->getUsers();

            $this->info('Sending request to Gophish');
            $this->createOrUpdateGroup($groups, $userData);
        });
    }

    private function getGroups()
    {
        $groups = Http::withoutVerifying()->get('https://'. config('gophish.ip') .':3333/api/groups/?api_key='. config('gophish.key') .'');
        return collect($groups->json())->pluck('id', 'name');
    }

    private function getUsers()
    {
        $users = User::query()
            ->select('name', 'email')
            ->whereNot('name', 'Joe Lohr')
            ->whereNot('name', 'Terry Dortch')
            ->whereNot('name', 'Mike Backer')
            ->get();

        return $users->map(function ($user) {
            $splitName = explode(' ', $user->name);
            $firstName = $splitName[0];
            $lastName = $splitName[1];
            return [
                'email' => $user->email,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'position' => null,
            ];
        })->toArray();
    }

    private function createOrUpdateGroup($groups, $userData)
    {
        if (!array_key_exists('All Employees', $groups->toArray())) {
            $this->createGroup($userData);
        } else {
            $this->updateGroup($groups->get('All Employees'), $userData);
        }
    }

    private function createGroup($userData)
    {
        try {
            $requestBody = [
                'name' => 'All Employees',
                'targets' => $userData,
            ];

            $response = Http::withHeaders([
                'Authorization' => config('gophish.key'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->withoutVerifying()
                ->post('https://'. config('gophish.ip') .':3333/api/groups/', $requestBody);

            if ($response->status() === 200) {
                $this->info('Group Created');
            }

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    private function updateGroup($groupId, $userData)
    {
        try {
            $requestBody = [
                'id' => $groupId,
                'name' => 'All Employees',
                'targets' => $userData,
            ];

            $response = Http::withHeaders([
                'Authorization' => config('gophish.key'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->withoutVerifying()
                ->put('https://'. config('gophish.ip') .':3333/api/groups/'. $groupId .'', $requestBody);

            if ($response->status() === 200) {
                $this->info('Group Updated');
            }

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}
