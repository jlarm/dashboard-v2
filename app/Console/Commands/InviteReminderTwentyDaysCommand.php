<?php

namespace App\Console\Commands;

use App\Mail\TenDayOpenInviteReminderMail;
use App\Models\Dealer\Invite;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class InviteReminderTwentyDaysCommand extends Command
{
    protected $signature = 'invite:reminder-twenty-days {--tenants=* : The tenant(s) to run the command for. Default all.}';

    protected $description = 'Daily check to send reminder to invitees 20 days after invite was sent';

    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
            $this->info("Running command for tenant {$tenant->id} ({$tenant->name})");

            $invites = Invite::where('created_at', '=', Carbon::now()->subDays(20))->get();

            foreach ($invites as $invite) {
                Mail::to($invite->email)->send(new TenDayOpenInviteReminderMail($invite));
            }

            $this->info('Command completed successfully');

        });
    }
}
