<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\TenDayOpenInviteReminderMail;
use App\Mail\TwentyDayOpenInviteReminderMail;
use App\Models\Dealer\Invite;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Override;

class RunInvitesCommand extends Command
{
    #[Override]
    protected $signature = 'run:invites {--tenants=* : The tenant(s) to run the command for. Default all.}';

    #[Override]
    protected $description = 'Daily check to send invites for 10 or 20 days then delete anything older than 30 days.';

    public function handle(): void
    {
        /** @var Collection<int, string> $tenants */
        $tenants = collect($this->option('tenants'))
            ->filter(static fn (mixed $tenant): bool => is_string($tenant) && $tenant !== '')
            ->values();

        tenancy()->runForMultiple($tenants->isEmpty() ? null : $tenants, function ($tenant): void {
            $this->info("Running command for tenant {$tenant->id} ({$tenant->name})");

            $invites = Invite::all();

            foreach ($invites as $invite) {
                $daysOld = (int) $invite->created_at->diffInDays(now());

                if ($daysOld === 10) {
                    Mail::to($invite->email)->send(new TenDayOpenInviteReminderMail($invite));
                    Log::info('Ten day reminder sent for invite '.$invite->email);
                } elseif ($daysOld === 20) {
                    Mail::to($invite->email)->send(new TwentyDayOpenInviteReminderMail($invite));
                    Log::info('Twenty day reminder sent for invite '.$invite->email);
                }
            }
        });
    }
}
