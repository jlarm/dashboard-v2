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
        $schedule->command('invite:reminder-ten-days')->dailyAt('23:00')->runInBackground();
        $schedule->command('invite:reminder-twenty-days')->dailyAt('23:30')->runInBackground();
        $schedule->command('delete:temporary-uploads')->dailyAt('00:00')->runInBackground();
        $schedule->command('delete:old-invites')->dailyAt('00:30')->runInBackground();
        $schedule->command('red-sentry:report-generation')->dailyAt('01:00')->runInBackground()->emailOutputTo('jlohr@autorisknow.com');
        $schedule->command('backups:go')->dailyAt('01:30')->runInBackground()->withoutOverlapping();
        $schedule->command('backups:clean')->dailyAt('03:01')->runInBackground()->withoutOverlapping();
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
