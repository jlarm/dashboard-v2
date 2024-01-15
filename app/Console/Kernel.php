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
        $schedule->command('invite:reminder-ten-days')->dailyAt('23:00')->runInBackground()->emailOutputOnFailure('jlohr@autorisknow.com');
        $schedule->command('invite:reminder-twenty-days')->dailyAt('23:30')->runInBackground()->emailOutputOnFailure('jlohr@autorisknow.com');
        $schedule->command('delete:temporary-uploads')->dailyAt('00:00')->runInBackground()->emailOutputOnFailure('jlohr@autorisknow.com');
        $schedule->command('delete:old-invites')->dailyAt('00:30')->runInBackground()->emailOutputOnFailure('jlohr@autorisknow.com');
        $schedule->command('red-sentry:report-generation')->dailyAt('01:00')->runInBackground()->emailOutputTo('jlohr@autorisknow.com')->emailOutputOnFailure('jlohr@autorisknow.com');
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
