<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealership;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class CheckMultiStateUsersCommand extends Command
{
    protected $signature = 'users:check-multi-state
        {--tenant= : Limit to a specific tenant ID}';
    protected $description = 'List users assigned to stores in more than one state across all tenants';

    public function handle(): int
    {
        $tenantId = $this->option('tenant');

        $tenants = Dealership::query()
            ->when(
                is_string($tenantId) && $tenantId !== '',
                fn (Builder $query): Builder => $query->where('id', $tenantId)
            )
            ->orderBy('id')
            ->get(['id', 'name']);

        if ($tenants->isEmpty()) {
            $this->warn('No tenants matched the filter.');

            return self::SUCCESS;
        }

        $totalFound = 0;

        foreach ($tenants as $tenant) {
            $tenant->run(function () use ($tenant, &$totalFound): void {
                $users = User::query()
                    ->has('stores', '>', 1)
                    ->with(['stores:id,name,state'])
                    ->get(['id', 'name', 'email']);

                $multiStateUsers = $users->filter(function (User $user): bool {
                    $states = $user->stores
                        ->pluck('state')
                        ->filter()
                        ->map(fn (string $s): string => mb_strtolower(trim($s)))
                        ->unique();

                    return $states->count() > 1;
                });

                if ($multiStateUsers->isEmpty()) {
                    return;
                }

                $this->line('');
                $this->info("Tenant: {$tenant->name} ({$tenant->id})");

                foreach ($multiStateUsers as $user) {
                    $storeList = $user->stores
                        ->map(fn ($store): string => "{$store->name} ({$store->state})")
                        ->implode(', ');

                    $this->line("  {$user->name} <{$user->email}> — {$storeList}");
                    $totalFound++;
                }
            });
        }

        $this->line('');
        $this->info("Done. Total multi-state users found: {$totalFound}");

        return self::SUCCESS;
    }
}
