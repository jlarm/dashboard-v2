<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\CourseNotificationMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Override;

class SendCourseNotificationToTenantCommand extends Command
{
    #[Override]
    protected $signature = 'course:send-notification
                            {courseLink : The URL link to the course}
                            {--tenants=* : The tenant(s) to run the command for. Default all.}';

    #[Override]
    protected $description = 'Send course notification email to all registered users in a specific tenant';

    public function handle(): void
    {
        $courseLink = (string) $this->argument('courseLink');

        /** @var Collection<int, string> $tenants */
        $tenants = collect($this->option('tenants'))
            ->filter(static fn (mixed $tenant): bool => is_string($tenant) && $tenant !== '')
            ->values();

        tenancy()->runForMultiple($tenants->isEmpty() ? null : $tenants, function ($tenant) use ($courseLink): void {
            $this->info("Running command for tenant: {$tenant->id} ({$tenant->name})");

            $users = User::query()
                ->whereDoesntHave('roles', function ($query): void {
                    $query->where('name', 'super-admin')
                        ->orWhere('name', 'Consultant');
                })
                ->select('id', 'name', 'email')
                ->get();

            $this->info("Found {$users->count()} registered users");

            foreach ($users as $user) {
                Mail::to($user->email)->send(new CourseNotificationMail($courseLink));
                $this->info("Sent notification to {$user->email}");
            }

            $this->info('Command completed successfully');
        });
    }
}
