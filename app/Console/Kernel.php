<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('invite:reminder-ten-days')->dailyAt('23:00')->emailOutputTo('jlohr@autorisknow.com')->emailOutputOnFailure('jlohr@autorisknow.com');
        $schedule->command('invite:reminder-twenty-days')->dailyAt('00:00')->emailOutputTo('jlohr@autorisknow.com')->emailOutputOnFailure('jlohr@autorisknow.com');
        $schedule->command('delete:temporary-uploads')->dailyAt('01:00')->emailOutputTo('jlohr@autorisknow.com')->emailOutputOnFailure('jlohr@autorisknow.com');
        $schedule->command('delete:old-invites')->dailyAt('02:00')->emailOutputTo('jlohr@autorisknow.com')->emailOutputOnFailure('jlohr@autorisknow.com');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
