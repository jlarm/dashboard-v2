<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\CourseExpiredNotification;
use App\Notifications\CourseExpiringSoonNotification;
use App\Services\UserCourseService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CourseExpiringEmailCommand extends Command
{
    protected $signature = 'course:check-reminders {--tenants=* : The tenant(s) to run the command for. Default all.}';
    protected $description = 'Send notifications for courses expiring soon.';

    public function __construct(public UserCourseService $userCourseService)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
            User::select(['id', 'name', 'email', 'department_id'])
                ->with('roles', 'stores')
                ->whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer'])
                ->get()
                ->each(fn ($user) => $this->processUserResults($tenant, $user));
        });
    }

    private function processUserResults($tenant, User $user): void
    {
        $results = $this->getExpiringCourses($user);

        $this->info($results);

        foreach ($results as $result) {
            if ($result->created_at->addYear()->subDays(15)->isSameDay(Carbon::now())) {
                $user->notify(new CourseExpiringSoonNotification($tenant->domain, $user->name, $result->course_id, $result->created_at->addYear()));
            }

            if ($result->created_at->addYear()->addDays(15)->isSameDay(Carbon::now()) || $result->created_at->addYear()->addDays(30)->isSameDay(Carbon::now())) {
                $user->notify(new CourseExpiredNotification($tenant->domain, $user->name, $result->course_id, $result->created_at->addYear()));
            }
        }
    }

    private function getExpiringCourses(User $user)
    {
        $lastYear = Carbon::now()->subYear()->addDays(15)->format('Y-m-d');
        $fifteenDays = Carbon::now()->subYear()->subDays(15)->format('Y-m-d');
        $thirtyDays = Carbon::now()->subYear()->subDays(30)->format('Y-m-d');

        // Use UserCourseService to get the correct course IDs assigned to this user
        $courseIds = $this->userCourseService->getCourseIds($user);

        $results = $user->results()
            ->whereIn('course_id', $courseIds)
            ->where('passed', 1)
            ->where(function ($query) use ($lastYear, $fifteenDays, $thirtyDays) {
                $query->whereDate('created_at', $lastYear)
                    ->orWhereDate('created_at', $fifteenDays)
                    ->orWhereDate('created_at', $thirtyDays);
            })
            ->get()
            ->unique('course_id');

        return $results;
    }
}
