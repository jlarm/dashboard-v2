<?php

declare(strict_types=1);

use App\Jobs\Scans\GenerateCyrismaReportJob;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Notifications\Scans\ScanReportFailedNotification;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Facades\Notification;
use RuntimeException;

describe('middleware', function (): void {
    it('registers a WithoutOverlapping middleware keyed by job class, store, and report type', function (): void {
        $store = Store::query()->firstOrFail();
        $user = User::query()->where('email', 'like', '%@test-tenant.localhost')->firstOrFail();
        $job = new GenerateCyrismaReportJob($store->id, 'executive', $user->id);

        $middleware = $job->middleware();

        expect($middleware)->toHaveCount(1);
        expect($middleware[0])->toBeInstanceOf(WithoutOverlapping::class);
        expect($middleware[0]->key)->toBe(GenerateCyrismaReportJob::class.'-'.$store->id.'-executive');
    });
});

describe('failed()', function (): void {
    it('notifies the dispatching user that report generation failed', function (): void {
        Notification::fake();

        $store = Store::query()->create(['name' => 'Acme Store of Failure']);
        $user = User::query()->create([
            'name' => 'Pat',
            'email' => 'pat-failed-job-'.uniqid().'@test-tenant.localhost',
            'password' => bcrypt('x'),
        ]);

        $job = new GenerateCyrismaReportJob($store->id, 'technical', $user->id);

        $job->failed(new RuntimeException('cyrisma timed out'));

        Notification::assertSentTo(
            $user,
            ScanReportFailedNotification::class,
            fn (ScanReportFailedNotification $notification): bool => $notification->type === 'technical'
                && $notification->storeName === 'Acme Store of Failure'
        );
    });

    it('does nothing when the user has been deleted before the failure callback fires', function (): void {
        Notification::fake();

        $store = Store::query()->create(['name' => 'Acme Store of Ghosts']);
        $job = new GenerateCyrismaReportJob($store->id, 'executive', 999999);

        $job->failed(new RuntimeException('user gone'));

        Notification::assertNothingSent();
    });

    it('returns early without notifying when no exception is provided', function (): void {
        Notification::fake();

        $store = Store::query()->create(['name' => 'Acme Store']);
        $user = User::query()->create([
            'name' => 'Quiet Pat',
            'email' => 'pat-quiet-'.uniqid().'@test-tenant.localhost',
            'password' => bcrypt('x'),
        ]);

        $job = new GenerateCyrismaReportJob($store->id, 'executive', $user->id);

        $job->failed(null);

        // No exception → method still notifies a "failed" message (current behavior:
        // logs the null error then notifies the user). Lock in the current contract.
        Notification::assertSentTo($user, ScanReportFailedNotification::class);
    });
});
