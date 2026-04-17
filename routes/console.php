<?php

declare(strict_types=1);

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function (Command $command): void {
    $command->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('vendor:send-notification')
    ->daily()
    ->runInBackground()
    ->withoutOverlapping()
    ->onOneServer()
    ->emailOutputOnFailure(config('app.admin_email'));

// Clean activity logs - removes old activity log records
Schedule::command('activitylog:clean --force')
    ->dailyAt('00:15')
    ->runInBackground()
    ->withoutOverlapping()
    ->onOneServer()
    ->emailOutputOnFailure(config('app.admin_email'));

// Process user invitations
Schedule::command('run:invites')
    ->dailyAt('00:30')
    ->runInBackground()
    ->withoutOverlapping()
    ->onOneServer()
    ->emailOutputOnFailure(config('app.admin_email'));

// Clean temporary uploads
Schedule::command('delete:temporary-uploads')
    ->dailyAt('00:45')
    ->runInBackground()
    ->withoutOverlapping()
    ->onOneServer()
    ->emailOutputOnFailure(config('app.admin_email'));

// Clear Livewire temporary files for all tenants
Schedule::command('livewire:clear-temp-files')
    ->dailyAt('01:00')
    ->runInBackground()
    ->withoutOverlapping()
    ->onOneServer()
    ->emailOutputOnFailure(config('app.admin_email'));

// Create backups
Schedule::command('backups:go')
    ->dailyAt('01:30')
    ->runInBackground()
    ->withoutOverlapping()
    ->onOneServer()
    ->emailOutputOnFailure(config('app.admin_email'));

// Clean old backups
Schedule::command('backups:clean')
    ->dailyAt('03:01')
    ->runInBackground()
    ->withoutOverlapping()
    ->onOneServer()
    ->emailOutputOnFailure(config('app.admin_email'));

// Synchronize GoPhish user groups
Schedule::command('run:go-phish-user-groups')
    ->dailyAt('04:00')
    ->runInBackground()
    ->withoutOverlapping()
    ->onOneServer()
    ->emailOutputOnFailure(config('app.admin_email'));

// Synchronize GoPhish user group departments
Schedule::command('run:go-phish-user-group-departments')
    ->dailyAt('04:30')
    ->runInBackground()
    ->withoutOverlapping()
    ->onOneServer()
    ->emailOutputOnFailure(config('app.admin_email'));

Schedule::command('course:reminder')
    ->dailyAt('05:00')
    ->runInBackground()
    ->withoutOverlapping()
    ->onOneServer()
    ->emailOutputOnFailure(config('app.admin_email'));

Schedule::command('remediation:reminder')
    ->dailyAt('05:30')
    ->runInBackground()
    ->withoutOverlapping()
    ->onOneServer()
    ->emailOutputOnFailure(config('app.admin_email'));

Schedule::command('run:course-reminder')
    ->dailyAt('06:00')
    ->runInBackground()
    ->withoutOverlapping()
    ->onOneServer()
    ->emailOutputOnFailure(config('app.admin_email'));

Schedule::command('compliance-summary:send')
    ->dailyAt('07:00')
    ->runInBackground()
    ->withoutOverlapping()
    ->onOneServer()
    ->emailOutputOnFailure(config('app.admin_email'));

// Clean up old deal jacket reports
Schedule::command('deal-jacket-reports:clean')
    ->dailyAt('02:00')
    ->runInBackground()
    ->withoutOverlapping()
    ->onOneServer()
    ->emailOutputOnFailure(config('app.admin_email'));

// Commented out commands - preserved for reference or future use
// Schedule::command('course:check-reminders')->dailyAt('05:00')->runInBackground();
// Schedule::command('run:course-reminder')->dailyAt('05:30')->runInBackground();
