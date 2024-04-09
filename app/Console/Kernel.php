<?php

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
        $schedule->command('activitylog:clean')->daily()->runInBackground();
        $schedule->command('run:invites')->daily()->runInBackground();
        $schedule->command('run:course-reminder')->daily()->runInBackground();
        $schedule->command('delete:temporary-uploads')->daily()->runInBackground();
        $schedule->command('red-sentry:report-generation')->dailyAt('01:00')->runInBackground()->emailOutputTo('jlohr@autorisknow.com');
        $schedule->command('backups:go')->dailyAt('01:30')->runInBackground()->withoutOverlapping();
        $schedule->command('backups:clean')->dailyAt('03:01')->runInBackground()->withoutOverlapping();
        $schedule->command('run:go-phish-user-groups')->daily()->runInBackground();
        $schedule->command('run:go-phish-user-group-departments')->daily()->runInBackground();
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
