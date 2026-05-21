<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealership;
use App\Models\User;
use App\Notifications\CourseExpiredNotification;
use App\Notifications\CourseExpiringSoonNotification;
use App\Services\UserCourseService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Override;

class CourseExpiringEmailCommand extends Command
{
    #[Override]
    protected $signature = 'courses:check-reminders {--tenants=* : The tenant(s) to run the command for. Default all.}';

    #[Override]
    protected $description = 'Send notifications for courses expiring soon.';

    public function __construct(public UserCourseService $userCourseService)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        /** @var Collection<int, string> $tenants */
        $tenants = collect($this->option('tenants'))
            ->filter(static fn (mixed $tenant): bool => is_string($tenant) && $tenant !== '')
            ->values();

        tenancy()->runForMultiple($tenants->isEmpty() ? null : $tenants, function (Dealership $tenant): void {
            resolve(UserCourseService::class)->clearAllCaches();

            User::query()->select(['id', 'name', 'email', 'department_id'])
                ->with('roles', 'stores')
                ->whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer'])
                ->get()
                ->each(fn (User $user) => $this->processUserResults($tenant, $user));
        });
    }

    private function processUserResults(Dealership $tenant, User $user): void
    {
        $results = $this->getExpiringCourses($user);

        $this->info($results->toJson());

        foreach ($results as $result) {
            if ($result->created_at->addYear()->subDays(15)->isSameDay(Date::now())) {
                $user->notify(new CourseExpiringSoonNotification($tenant->domain, $user->name, $result->course_id, $result->created_at->addYear()));
            }

            if ($result->created_at->addYear()->addDays(15)->isSameDay(Date::now()) || $result->created_at->addYear()->addDays(30)->isSameDay(Date::now())) {
                $user->notify(new CourseExpiredNotification($tenant->domain, $user->name, $result->course_id, $result->created_at->addYear()));
            }
        }
    }

    /**
     * @return Collection<int, \App\Models\Dealer\CourseResults>
     */
    private function getExpiringCourses(User $user): Collection
    {
        $lastYear = Date::now()->subYear()->addDays(15)->format('Y-m-d');
        $fifteenDays = Date::now()->subYear()->subDays(15)->format('Y-m-d');
        $thirtyDays = Date::now()->subYear()->subDays(30)->format('Y-m-d');

        // Use UserCourseService to get the correct course IDs assigned to this user
        $courseIds = $this->userCourseService->getCourseIds($user);

        return $user->results()
            ->whereIn('course_id', $courseIds)
            ->where('passed', 1)
            ->where(function (Builder $query) use ($lastYear, $fifteenDays, $thirtyDays): void {
                $query->whereDate('created_at', $lastYear)
                    ->orWhereDate('created_at', $fifteenDays)
                    ->orWhereDate('created_at', $thirtyDays);
            })
            ->get()
            ->unique('course_id');
    }
}
