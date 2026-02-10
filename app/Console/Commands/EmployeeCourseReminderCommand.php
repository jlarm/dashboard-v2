<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealer\CourseUserNotificationSent;
use App\Models\User;
use App\Notifications\ExpiredCourseNotification;
use App\Services\UserCourseService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EmployeeCourseReminderCommand extends Command
{
    protected $signature = 'run:course-reminder  {--tenants=* : The tenant(s) to run the command for. Default all.}';
    protected $description = 'Reminder employee that course expires soon or expired.';

    public function __construct(public UserCourseService $userCourseService)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant): void {

            $this->info("Running command for tenant {$tenant->id} ({$tenant->name})");

            $this->deleteOutdatedNotifications();

            User::query()->select(['id', 'name', 'email', 'department_id'])
                ->with('roles', 'stores')
                ->whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer'])
                ->get()
                ->each(fn ($user) => $this->processUserResults($user));

            $this->info("Command for tenant {$tenant->id} ({$tenant->name}) completed");
        });
    }

    private function processUserResults(User $user): void
    {
        // Use UserCourseService to get the correct course IDs assigned to this user
        $assignedCourseIds = $this->userCourseService->getCourseIds($user);

        // Get all passed courses that are still assigned to the user
        $results = $user->results()
            ->select('id', 'created_at', 'course_id')
            ->whereIn('course_id', $assignedCourseIds)
            ->where('passed', 1)
            ->orderBy('id', 'desc')
            ->get()
            ->groupBy('course_id')
            ->map(fn ($result) => $result->first());

        // Group courses by their expiration status
        $coursesToNotify = [
            'expiring_soon' => [],
            'expired_today' => [],
            'expired_30_days' => [],
        ];

        $results->each(function ($result) use (&$coursesToNotify, $user): void {
            // Course expires 1 year (365 days) after completion
            $expirationDate = Carbon::parse($result->created_at)->addYear();
            $now = Carbon::now();
            $daysUntilExpiration = $now->diffInDays($expirationDate, false);

            // Determine notification type based on days until expiration
            $notificationType = null;

            // 30 days before expiration (between 29 and 30 days)
            if ($daysUntilExpiration >= 29 && $daysUntilExpiration <= 30) {
                $notificationType = 'expiring_soon';
            }
            // On expiration day (between -1 and 1 days)
            elseif ($daysUntilExpiration >= -1 && $daysUntilExpiration <= 1) {
                $notificationType = 'expired_today';
            }
            // 30 days after expiration (between -31 and -29 days)
            elseif ($daysUntilExpiration >= -31 && $daysUntilExpiration <= -29) {
                $notificationType = 'expired_30_days';
            }

            if ($notificationType) {
                // Check if notification was already sent recently (within last 7 days to avoid duplicates)
                $recentNotification = CourseUserNotificationSent::query()->where('user_id', $user->id)
                    ->where('course_id', $result->course_id)
                    ->where('sent', '>=', Carbon::now()->subDays(7))
                    ->first();

                if (! $recentNotification) {
                    $coursesToNotify[$notificationType][] = $result->course_id;
                }
            }
        });

        // If there are courses to notify about, send a single notification with all courses
        $hasCourses = array_filter($coursesToNotify, fn ($courses): bool => $courses !== []);

        if ($hasCourses !== []) {
            $user->notify(new ExpiredCourseNotification($coursesToNotify, $user->name));

            // Record that notifications were sent for these courses
            foreach ($coursesToNotify as $courses) {
                foreach ($courses as $courseId) {
                    CourseUserNotificationSent::query()->create([
                        'user_id' => $user->id,
                        'course_id' => $courseId,
                        'sent' => Carbon::now(),
                    ]);
                }
            }
        }
    }

    private function deleteOutdatedNotifications(): void
    {
        // Delete notifications older than 60 days to keep the table clean
        // We keep them for 60 days to ensure we have a record across all three notification periods
        CourseUserNotificationSent::query()->where('sent', '<', Carbon::now()->subDays(60))->delete();
    }
}
