<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateMikesPhoneNumberCommand extends Command
{
    protected $signature = 'update:mikes-phone-number {--tenants=* : The tenant IDs to run the command for}';
    protected $description = 'Update Mike\'s phone number across tenants';

    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
            $this->info("Running command for tenant {$tenant->id}");

            $mike = User::where('email', 'mbacker@autorisknow.com')->first();

            if (! $mike) {
                $this->info('Mike not found');

                return;
            }

            $mike->update([
                'phone' => '7579452241',
            ]);

            $this->info('Mike updated successfully');
        });
    }
}
