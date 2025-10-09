<?php

namespace App\Console\Commands;

use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\GoPhishService;
use Illuminate\Console\Command;

class CreateUpdateGoPhishUserGroupsCommand extends Command
{
    protected $signature = 'run:go-phish-user-groups {--tenants=* : The tenant(s) to run the command for. Default all.}';
    protected $description = 'Create/Update User Groups for GoPhish';
    protected $token;
    protected $ip;
    protected $goPhishService;

    public function __construct(GoPhishService $goPhishService)
    {
        parent::__construct();

        $this->goPhishService = $goPhishService;
    }

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

            // Get current groups in GoPhish
            $groups = $this->goPhishService->getGroups($this->token, $this->ip);

            foreach ($stores as $store) {

                if ($store === null) {
                    $this->info('No store found for tenant: '.$tenant->name);

                    return;
                }

                if ($this->token === null || ! $this->ip === null) {
                    $this->info('No token or IP found for tenant: '.$tenant->name);

                    return;
                }

                if ($this->token && $this->ip) {
                    $this->info('Running for tenant: '.$tenant->name);

                    // Get all users for the tenant
                    $userData = $this->getUsers($store);

                    $this->info('Sending request to Gophish');
                    $this->goPhishService->createOrUpdateGroup($groups, $userData, $tenant, $store, $this->token, $this->ip);
                }

            }

            $this->info('Finished running for tenant: '.$tenant->name);

        });
    }

    public function getUsers($store)
    {
        if (tenant('locations')) {
            $users = $store->users()
                ->select('name', 'email')
                ->whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer'])
                ->get();
        } else {
            $users = User::select('name', 'email')
                ->whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer'])
                ->get();
        }

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
}
