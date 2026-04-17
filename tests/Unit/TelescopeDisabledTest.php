<?php

declare(strict_types=1);

use App\Console\Kernel;
use Illuminate\Console\Scheduling\Schedule;
use Stancl\Tenancy\Features\TelescopeTags;
use Tests\TestCase;

uses(TestCase::class);

it('disables telescope by default', function (): void {
    expect(config('telescope.enabled'))->toBeFalsy();
});

it('does not include telescope tenancy features', function (): void {
    expect(config('tenancy.features'))->not->toContain(TelescopeTags::class);
});

it('does not schedule telescope pruning', function (): void {
    $schedule = resolve(Schedule::class);
    $kernel = resolve(Kernel::class);

    $method = new ReflectionMethod($kernel, 'schedule');
    $method->invoke($kernel, $schedule);

    $commands = collect($schedule->events())
        ->map(fn ($event): ?string => $event->command)
        ->filter()
        ->values()
        ->all();

    expect($commands)->not->toContain('telescope:prune');
});
