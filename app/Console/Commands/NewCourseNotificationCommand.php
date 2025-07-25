<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\NewCourseNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class NewCourseNotificationCommand extends Command
{
    protected $signature = 'new:course-notification {--tenants=* : The tenant(s) to run the command for. Default all.}';

    protected $description = 'Send new course notification to all users.';

    public function handle()
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
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
