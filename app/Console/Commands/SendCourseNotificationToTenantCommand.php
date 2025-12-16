<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\CourseNotificationMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendCourseNotificationToTenantCommand extends Command
{
    protected $signature = 'course:send-notification
                            {courseLink : The URL link to the course}
                            {--tenants=* : The tenant(s) to run the command for. Default all.}';
    protected $description = 'Send course notification email to all registered users in a specific tenant';

    public function handle(): void
    {
        $courseLink = $this->argument('courseLink');

        if (! is_string($courseLink)) {
            $this->error('Invalid course link provided');

            return;
        }

        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) use ($courseLink) {
            $this->info("Running command for tenant: {$tenant->id} ({$tenant->name})");

            $users = User::query()
                ->whereDoesntHave('roles', function ($query) {
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
