<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetCurrentStoreCommand extends Command
{
    protected $signature = 'set:current-store  {--tenants=* : The tenant(s) to run the command for. Default all.}';
    protected $description = 'Update all employees current_store_id to their first store id';

    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant): void {
            DB::beginTransaction();
            try {
                if (! $tenant->locations) {
                    foreach (User::all() as $user) {
                        $user->update(['current_store_id' => 1]);
                    }
                } else {
                    foreach (User::all() as $user) {
                        if (! $user->hasAnyRole(['super-admin', 'Consultant'])) {
                            $firstStore = $user->stores()->first();
                            if (! $firstStore) {
                                $this->info("User {$user->id} {$user->name} does not belong to any stores in {$tenant->name} - skipping");

                                continue;
                            }
                            $user->update(['current_store_id' => $firstStore->id]);
                        }
                    }
                }
                $this->info('Successfully updated users in tenant '.$tenant->name);
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                $this->info('Failed to update users in tenant '.$tenant->name);
                $this->error("Failed to update users in tenant {$tenant->name}: {$e->getMessage()}");
            }
        });
    }
}
