<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\GoPhishService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class CreateUpdateGoPhishUserGroupsCommand extends Command
{
    protected $signature = 'run:go-phish-user-groups {--tenants=* : The tenant(s) to run the command for. Default all.}';
    protected $description = 'Create/Update User Groups for GoPhish';
    protected $token;
    protected $ip;

    public function __construct(protected GoPhishService $goPhishService)
    {
        parent::__construct();
    }

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

            $this->token = $globalSetting->phishing_token;
            $this->ip = $globalSetting->phishing_ip;

            $stores = Store::all();

            // Get current groups in GoPhish
            $groups = $this->goPhishService->getGroups($this->token, $this->ip);

            foreach ($stores as $store) {

                if ($this->token === null || $this->ip === null) {
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

    public function getUsers(Store $store): array
    {
        if (Store::query()->count() > 1) {
            $users = $store->users()
                ->select('name', 'email')
                ->whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer'])
                ->get();
        } else {
            $users = User::query()->select('name', 'email')
                ->whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer'])
                ->get();
        }

        return $users->map(function ($user): array {
            $splitName = preg_split('/\s+/', mb_trim((string) $user->name), 2) ?: [];
            $firstName = $splitName[0] ?? '';
            $lastName = $splitName[1] ?? '';

            return [
                'email' => $user->email,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'position' => null,
            ];
        })->toArray();
    }
}
