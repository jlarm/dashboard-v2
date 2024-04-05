<?php

namespace App\Console\Commands;

use App\Models\Dealer\Invite;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Stancl\Tenancy\Concerns\HasATenantsOption;

class DeleteOldInvitesCommand extends Command
{
    use HasATenantsOption;

    protected $signature = 'delete:old-invites {--tenants=* : The tenant(s) to run the command for. Default all.}';

    protected $description = 'Daily check to delete invites older than 30 days';

    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
            $this->info("Running command for tenant {$tenant->id} ({$tenant->name})");

            $invites = Invite::where('created_at', '<', Carbon::now()->subDays(30))->get();

            foreach ($invites as $invite) {
                $invite->delete();
            }
            Log::info('Old invites deleted for tenant ' . $tenant->name);
            $this->info('Command completed successfully');
        });
    }
}
