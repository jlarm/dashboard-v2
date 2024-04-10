<?php

namespace App\Console\Commands;

use App\Models\Dealer\CourseUserNotificationSent;
use App\Models\User;
use App\Notifications\ExpiredCourseNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EmployeeCourseReminderCommand extends Command
{
    protected $signature = 'run:course-reminder  {--tenants=* : The tenant(s) to run the command for. Default all.}';

    protected $description = 'Reminder employee that course expires soon or expired.';

    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {

            $this->info("Running command for tenant $tenant->id ($tenant->name)");

            $this->deleteOutdatedNotifications();

            User::select(['id', 'name', 'email'])
                ->whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer'])
                ->get()
                ->each(fn ($user) => $this->processUserResults($user));

            $this->info("Command for tenant $tenant->id ($tenant->name) completed");
        });
    }

    private function processUserResults(User $user): void
    {
        $results = $user->results()
            ->select('id', 'created_at', 'course_id')
            ->where('passed', 1)
            ->whereDate('created_at', '<', Carbon::now()->subYear())
            ->orderBy('id', 'desc')
            ->get()
            ->groupBy('course_id')
            ->map(function ($result) {
                return $result->first();
            });

        $results->each(fn ($result) => CourseUserNotificationSent::where('user_id', $user->id)
            ->where('course_id', $result->course_id)
            ->firstOr(function () use ($user, $result) {
                $user->notify(new ExpiredCourseNotification($result->course_id));
                CourseUserNotificationSent::create([
                    'user_id' => $user->id,
                    'course_id' => $result->course_id,
                    'sent' => Carbon::now(),
                ]);
            }));
    }

    private function deleteOutdatedNotifications(): void
    {
        $notifications = CourseUserNotificationSent::all();

        foreach ($notifications as $notification) {
            if ($notification->sent->diffInDays(Carbon::now()) > 30) {
                $notification->delete();
            }
        }
    }
}
