<?php

namespace App\Console\Commands;

use App\Mail\TenDayOpenInviteReminderMail;
use App\Models\Dealer\Invite;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InviteReminderTenDaysCommand extends Command
{
    protected $signature = 'invite:reminder-ten-days {--tenants=* : The tenant(s) to run the command for. Default all.}';

    protected $description = 'Daily check to send reminder to invitees 10 days after invite was sent';

    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
            $this->info("Running command for tenant {$tenant->id} ({$tenant->name})");

            $invites = Invite::where('created_at', '=', Carbon::now()->subDays(10))->get();

            foreach ($invites as $invite) {
                try {
                    Mail::to($invite->email)->send(new TenDayOpenInviteReminderMail($invite));
                    Log::info('Ten day reminder sent for invite ' . $invite->email);
                } catch (\Exception $e) {
                    Log::error('Error sending ten day reminder for invite ' . $invite->email . ': ' . $e->getMessage());
                }
            }

            $this->info('Command completed successfully');

        });
    }
}
