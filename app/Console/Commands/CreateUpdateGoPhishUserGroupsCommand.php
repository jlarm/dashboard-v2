<?php

namespace App\Console\Commands;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CreateUpdateGoPhishUserGroupsCommand extends Command
{
    protected $signature = 'run:go-phish-user-groups {--tenants=* : The tenant(s) to run the command for. Default all.}';

    protected $description = 'Create/Update User Groups for GoPhish';

    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
            $this->info('Starting run for tenant: '.$tenant->name);

            $store = Store::where('name', $tenant->name)->first() ?? null;
            $token = $store->phishing_token ?? null;
            $ip = $store->phishing_ip ?? null;

            $this->info('Store: '.$store->name);
            $this->info('Token: '.$token);
            $this->info('IP: '.$ip);

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

            $this->info('Finished running for tenant: '.$tenant->name);
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

    private function createOrUpdateGroup($groups, $userData, $ip, $token)
    {
        if (! array_key_exists('All Employees', $groups->toArray())) {
            $this->createGroup($userData, $ip, $token);
        } else {
            $this->updateGroup($groups->get('All Employees'), $userData, $ip , $token);
        }
    }

    private function createGroup($userData, $ip, $token)
    {
        try {
            $requestBody = [
                'name' => 'All Employees',
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

    private function updateGroup($groupId, $userData, $ip, $token)
    {
        try {
            $requestBody = [
                'id' => $groupId,
                'name' => 'All Employees',
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
}
