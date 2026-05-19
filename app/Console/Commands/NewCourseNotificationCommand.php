<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealership;
use App\Models\User;
use App\Notifications\NewCourseNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;
use Override;

class NewCourseNotificationCommand extends Command
{
    #[Override]
    protected $signature = 'new:course-notification {--tenants=* : The tenant(s) to run the command for. Default all.}';

    #[Override]
    protected $description = 'Send new course notification to all users.';

    public function handle(): void
    {
        /** @var Collection<int, string> $tenants */
        $tenants = collect($this->option('tenants'))
            ->filter(static fn (mixed $tenant): bool => is_string($tenant) && $tenant !== '')
            ->values();

        tenancy()->runForMultiple($tenants->isEmpty() ? null : $tenants, function (Dealership $tenant): void {
            $this->info("Running command for tenant {$tenant->id} ({$tenant->name})");

            $users = User::query()
                ->select('id', 'name', 'email')
                ->whereNot('name', 'Joe Lohr')
                ->whereNot('name', 'Terry Dortch')
                ->whereNot('name', 'Mike Backer')
                ->get();

            foreach ($users as $user) {
                Notification::send($user, new NewCourseNotification);
            }

            $this->info('Command completed successfully');

        });
    }
}
