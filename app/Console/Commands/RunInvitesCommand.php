<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\TenDayOpenInviteReminderMail;
use App\Mail\TwentyDayOpenInviteReminderMail;
use App\Models\Dealer\Invite;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RunInvitesCommand extends Command
{
    protected $signature = 'run:invites {--tenants=* : The tenant(s) to run the command for. Default all.}';
    protected $description = 'Daily check to send invites for 10 or 20 days then delete anything older than 30 days.';

    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant): void {
            $this->info("Running command for tenant {$tenant->id} ({$tenant->name})");

            $invites = Invite::all();

            foreach ($invites as $invite) {
                if ($invite->created_at->diffInDays(now()) === 10) {
                    // Send 10 day reminder
                    Mail::to($invite->email)->send(new TenDayOpenInviteReminderMail($invite));
                    Log::info('Ten day reminder sent for invite '.$invite->email);
                } elseif ($invite->created_at->diffInDays(now()) === 20) {
                    // Send 20 day reminder
                    Mail::to($invite->email)->send(new TwentyDayOpenInviteReminderMail($invite));
                    Log::info('Twenty day reminder sent for invite '.$invite->email);
                }
            }
        });
    }
}
