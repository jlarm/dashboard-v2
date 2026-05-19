<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealer\Store;
use App\Models\Dealership;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Override;
use Throwable;

class SyncSingleStoreUsersCommand extends Command
{
    #[Override]
    protected $signature = 'stores:sync-single-store-users {--tenants=* : The tenant(s) to run the command for. Default all.}';

    #[Override]
    protected $description = 'Ensure every user belongs to the only store for tenants with exactly one store';

    public function handle(): int
    {
        /** @var Collection<int, string> $tenants */
        $tenants = collect($this->option('tenants'))
            ->filter(static fn (mixed $tenant): bool => is_string($tenant) && $tenant !== '')
            ->values();

        $hadFailure = false;

        tenancy()->runForMultiple($tenants->isEmpty() ? null : $tenants, function (Dealership $tenant) use (&$hadFailure): void {
            $storeCount = Store::query()->count();

            if ($storeCount !== 1) {
                $this->comment("Skipping tenant {$tenant->id}: expected 1 store, found {$storeCount}.");

                return;
            }

            $store = Store::query()->firstOrFail();

            DB::beginTransaction();

            try {
                $usersUpdated = 0;

                User::query()->each(function (User $user) use ($store, &$usersUpdated): void {
                    $alreadyAssigned = $user->stores()
                        ->where('stores.id', $store->id)
                        ->exists();

                    if ($alreadyAssigned) {
                        return;
                    }

                    $user->stores()->syncWithoutDetaching([$store->id]);
                    $usersUpdated++;
                });

                DB::commit();

                $this->info("Tenant {$tenant->id}: synced {$usersUpdated} user(s) to store {$store->id}.");
            } catch (Throwable $throwable) {
                DB::rollBack();
                $hadFailure = true;

                $this->error("Tenant {$tenant->id}: failed to sync users. {$throwable->getMessage()}");
            }
        });

        return $hadFailure ? self::FAILURE : self::SUCCESS;
    }
}
