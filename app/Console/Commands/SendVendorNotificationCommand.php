<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\IncompleteVendorNotificationJob;
use App\Models\Dealer\VendorForm;
use Illuminate\Console\Command;

class SendVendorNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendor:send-notification {--tenants=* : The tenant(s) to run the command for. Default all.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to vendor every 30 days if they have not completed the form.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant): void {
            $incompleteVendors = VendorForm::query()
                ->whereNull('signature')
                ->where(function ($query): void {
                    $query->whereNull('last_notification_sent_at')
                        ->orWhere('last_notification_sent_at', '<', now()->subMonth());
                })
                ->get();

            foreach ($incompleteVendors as $vendor) {
                IncompleteVendorNotificationJob::dispatch($vendor);
                $vendor->update(['last_notification_sent_at' => now()]);
            }
        });
    }
}
