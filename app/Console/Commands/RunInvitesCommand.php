<?php

namespace App\Console\Commands;

use App\Mail\TenDayOpenInviteReminderMail;
use App\Mail\TwentyDayOpenInviteReminderMail;
use App\Models\Dealer\Invite;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;
use Mail;

class RunInvitesCommand extends Command
{
    protected $signature = 'run:invites {--tenants=* : The tenant(s) to run the command for. Default all.}';

    protected $description = 'Daily check to send invites for 10 or 20 days then delete anything older than 30 days.';

    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
            $this->info("Running command for tenant $tenant->id ($tenant->name)");

            $invites = Invite::all();

            foreach ($invites as $invite) {
                if ($invite->created_at->diffInDays(now()) === 10) {
                    // Send 10 day reminder
                    Mail::to($invite->email)->send(new TenDayOpenInviteReminderMail($invite));
                    Log::info('Ten day reminder sent for invite ' . $invite->email);
                } elseif ($invite->created_at->diffInDays(now()) === 20) {
                    // Send 20 day reminder
                    Mail::to($invite->email)->send(new TwentyDayOpenInviteReminderMail($invite));
                    Log::info('Twenty day reminder sent for invite ' . $invite->email);
                } elseif ($invite->created_at->diffInDays(Carbon::now()) > 30) {
                    // Delete old invites older than 30 days
                    $invite->delete();
                    Log::info('Old invite deleted for ' . $invite->email);
                }
            }
        });
    }
}
