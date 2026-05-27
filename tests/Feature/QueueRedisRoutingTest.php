<?php

declare(strict_types=1);

use Tests\TestCase;

uses(TestCase::class);

it('exposes a dedicated "queue" redis connection in config/database.php', function (): void {
    expect(config('database.redis.queue'))->toBeArray();
});

it('defaults the "queue" redis connection to database 3 so it does not collide with default/cache/sessions', function (): void {
    // Cast: env returns a string when no .env override is loaded.
    expect((int) config('database.redis.queue.database'))->toBe(3);
});

it('partitions default/cache/sessions/queue across distinct redis databases', function (): void {
    $defaults = [
        'default' => 0,
        'cache' => 1,
        'sessions' => 2,
        'queue' => 3,
    ];

    foreach ($defaults as $name => $db) {
        expect((int) config("database.redis.{$name}.database"))->toBe($db);
    }
});

it('does not set a redis key prefix on the "queue" connection so tenancy initialization cannot rewrite job keys', function (): void {
    $prefix = config('database.redis.queue.prefix') ?? '';
    expect($prefix)->toBe('');
});
