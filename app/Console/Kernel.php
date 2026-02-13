<?php

declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('telescope:prune')
            ->daily()
            ->emailOutputOnFailure(config('app.admin_email'));

        $schedule->command('vendor:send-notification')
            ->daily()
            ->runInBackground()
            ->withoutOverlapping()
            ->emailOutputOnFailure(config('app.admin_email'));

        // Clean activity logs - removes old activity log records
        $schedule->command('activitylog:clean --force')
            ->dailyAt('00:15')
            ->runInBackground()
            ->withoutOverlapping()
            ->emailOutputOnFailure(config('app.admin_email'));

        // Process user invitations
        $schedule->command('run:invites')
            ->dailyAt('00:30')
            ->runInBackground()
            ->withoutOverlapping()
            ->emailOutputOnFailure(config('app.admin_email'));

        // Clean temporary uploads
        $schedule->command('delete:temporary-uploads')
            ->dailyAt('00:45')
            ->runInBackground()
            ->withoutOverlapping()
            ->emailOutputOnFailure(config('app.admin_email'));

        // Clear Livewire temporary files for all tenants
        $schedule->command('livewire:clear-temp-files')
            ->dailyAt('01:00')
            ->runInBackground()
            ->withoutOverlapping()
            ->emailOutputOnFailure(config('app.admin_email'));

        // Create backups
        $schedule->command('backups:go')
            ->dailyAt('01:30')
            ->runInBackground()
            ->withoutOverlapping()
            ->emailOutputOnFailure(config('app.admin_email'));

        // Clean old backups
        $schedule->command('backups:clean')
            ->dailyAt('03:01')
            ->runInBackground()
            ->withoutOverlapping()
            ->emailOutputOnFailure(config('app.admin_email'));

        // Synchronize GoPhish user groups
        $schedule->command('run:go-phish-user-groups')
            ->dailyAt('04:00')
            ->runInBackground()
            ->withoutOverlapping()
            ->emailOutputOnFailure(config('app.admin_email'));

        // Synchronize GoPhish user group departments
        $schedule->command('run:go-phish-user-group-departments')
            ->dailyAt('04:30')
            ->runInBackground()
            ->withoutOverlapping()
            ->emailOutputOnFailure(config('app.admin_email'));

        $schedule->command('course:reminder')
            ->dailyAt('05:00')
            ->runInBackground()
            ->withoutOverlapping()
            ->emailOutputOnFailure(config('app.admin_email'));

        $schedule->command('remediation:reminder')
            ->dailyAt('05:30')
            ->runInBackground()
            ->withoutOverlapping()
            ->emailOutputOnFailure(config('app.admin_email'));

        $schedule->command('run:course-reminder')
            ->dailyAt('06:00')
            ->runInBackground()
            ->withoutOverlapping()
            ->emailOutputOnFailure(config('app.admin_email'));

        // Clean up old deal jacket reports
        $schedule->command('deal-jacket-reports:clean')
            ->dailyAt('02:00')
            ->runInBackground()
            ->withoutOverlapping()
            ->emailOutputOnFailure(config('app.admin_email'));

        // Commented out commands - preserved for reference or future use
        // $schedule->command('course:check-reminders')->dailyAt('05:00')->runInBackground();
        // $schedule->command('run:course-reminder')->dailyAt('05:30')->runInBackground();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
