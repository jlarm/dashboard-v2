<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealer\Store;
use App\Models\User;
use App\Notifications\IncompleteCoursesNotification;
use App\Queries\Feeds\CoursesFeed;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CourseReminderCommand extends Command
{
    protected $signature = 'course:reminder {--tenants=* : The tenant(s) to run the command for. Default all.}
                                           {--debug : Enable detailed debugging output}
                                           {--test : Run in test mode without sending notifications}';
    protected $description = 'Notify user every 15 days until they have attempted all of their courses.';

    public function handle(): void
    {
        $isTestMode = $this->option('test');
        $debugEnabled = $this->option('debug');

        // If in test mode, display a test case scenario
        if ($isTestMode) {
            $this->info('===== TEST MODE =====');
            $testDate = now()->subDays(15); // 15 days ago
            $fifteenDaysAgo = now()->subDays(15);

            $this->info('Test date: '.$testDate->format('Y-m-d H:i:s'));
            $this->info('15 days ago: '.$fifteenDaysAgo->format('Y-m-d H:i:s'));
            $this->info('Is test date before 15 days ago? '.($testDate->lt($fifteenDaysAgo) ? 'Yes' : 'No'));
            $this->info('Is test date after 15 days ago? '.($testDate->gt($fifteenDaysAgo) ? 'Yes' : 'No'));
            $this->info('Days difference: '.$testDate->diffInDays($fifteenDaysAgo));
            $this->info('=====================');

            if (! $this->confirm('Continue with reminder processing?', true)) {
                return;
            }
        }

        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) use ($debugEnabled, $isTestMode): void {
            $this->info("Running command for tenant: {$tenant->id}");

            // Check if tenant has locations feature enabled
            if (tenant('locations')) {
                $this->processTenantsWithLocations($tenant, $debugEnabled, $isTestMode);
            } else {
                $this->processTenantsWithoutLocations($tenant, $debugEnabled, $isTestMode);
            }
        });
    }

    /**
     * Process tenants that have locations/stores feature enabled
     */
    private function processTenantsWithLocations($tenant, bool $debugEnabled, bool $isTestMode): void
    {
        // Get all stores where courses_not_taken_notification is enabled
        $stores = Store::query()->where('courses_not_taken_notification', true)->get();

        if ($stores->isEmpty()) {
            $this->info("No stores with course notifications enabled for tenant: {$tenant->id}");

            return;
        }

        $this->info('Found '.$stores->count().' stores with course notifications enabled');

        // Loop through each store with notifications enabled
        foreach ($stores as $store) {
            $this->info("Processing store: {$store->name} (ID: {$store->id})");

            // Get all users associated with this store
            $users = $store->users()
                ->whereDoesntHave('roles', function ($query): void {
                    $query->where('name', 'super-admin')
                        ->orWhere('name', 'Consultant');
                })
                ->with('roles', 'stores')
                ->select('users.id', 'users.name', 'users.email', 'users.created_at', 'users.last_sent_course_reminder', 'users.department_id')
                ->get();

            $this->info('Found '.$users->count()." users for store {$store->name}");

            // Process each user
            $users->each(function ($user) use ($tenant, $debugEnabled, $isTestMode, $store): void {
                $this->processUser($user, $debugEnabled, $isTestMode, $store);
            });
        }
    }

    /**
     * Process tenants that don't have locations/stores feature enabled
     */
    private function processTenantsWithoutLocations($tenant, bool $debugEnabled, bool $isTestMode): void
    {
        $this->info("Tenant {$tenant->id} doesn't have locations enabled, processing all users");

        if (! Store::query()->first()->courses_not_taken_notification) {
            return;
        }

        User::query()
            ->whereDoesntHave('roles', function ($query): void {
                $query->where('name', 'super-admin')
                    ->orWhere('name', 'Consultant');
            })
            ->with('roles', 'stores')
            ->select('id', 'name', 'email', 'created_at', 'last_sent_course_reminder', 'department_id')
            ->get()
            ->each(function ($user) use ($tenant, $debugEnabled, $isTestMode): void {
                $this->processUser($user, $debugEnabled, $isTestMode);
            });
    }

    /**
     * Process an individual user for course reminders
     */
    private function processUser(User $user, bool $debugEnabled, bool $isTestMode, ?Store $store = null): void
    {
        // Get current time once to ensure consistency in comparisons
        $now = Carbon::now();
        $fifteenDaysAgo = $now->copy()->subDays(15);

        if ($debugEnabled) {
            $this->info("User: {$user->name} ({$user->email})");
            $this->info('Last reminder sent: '.($user->last_sent_course_reminder ? $user->last_sent_course_reminder->format('Y-m-d H:i:s') : 'Never'));
            $this->info('15 days ago: '.$fifteenDaysAgo->format('Y-m-d H:i:s'));
        }

        // Check if user has never received a reminder or if the last reminder was sent > 15 days ago
        $shouldSendReminder = is_null($user->last_sent_course_reminder) ||
                             $user->last_sent_course_reminder->lt($fifteenDaysAgo);

        if ($debugEnabled) {
            $this->info('Should send reminder? '.($shouldSendReminder ? 'Yes' : 'No'));

            if (! is_null($user->last_sent_course_reminder)) {
                $daysSinceLastReminder = $now->diffInDays($user->last_sent_course_reminder);
                $this->info("Days since last reminder: {$daysSinceLastReminder}");
            }
        }

        if ($shouldSendReminder) {
            $courseFeed = new CoursesFeed($user);
            $courseCounts = $courseFeed->getCourseCounts();

            if ($courseCounts['incomplete'] > 0) {
                $storeInfo = $store instanceof Store ? " for store {$store->name}" : '';
                $this->info("User {$user->name} has {$courseCounts['incomplete']} incomplete courses{$storeInfo}");

                if (! $isTestMode) {
                    $user->update(['last_sent_course_reminder' => $now]);
                    $user->notify(new IncompleteCoursesNotification(
                        $user->name,
                    ));
                    $this->info("Sent notification to {$user->email}{$storeInfo}");
                } else {
                    $this->info("[TEST MODE] Would send notification to {$user->email}{$storeInfo}");
                }
            } elseif ($debugEnabled) {
                $this->info("User {$user->name} has no incomplete courses");
            }
        }
    }
}
