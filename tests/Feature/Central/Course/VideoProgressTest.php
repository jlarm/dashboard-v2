<?php

declare(strict_types=1);

use App\Models\Course;
use App\Models\User;
use App\Models\VideoProgress;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('model_has_roles')->truncate();
    DB::table('users')->truncate();
    DB::table('video_progress')->truncate();
    DB::table('courses')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

it('records video progress for the authenticated user', function (): void {
    $course = Course::factory()->create(['video_id' => '987654']);

    $user = User::factory()->create();
    $user->assignRole('Consultant');

    $this->actingAs($user)
        ->post(route('courses.progress.store', $course))
        ->assertRedirect(route('courses.show', $course));

    $progress = VideoProgress::query()->sole();

    expect($progress->user_id)->toBe($user->id)
        ->and((int) $progress->video_id)->toBe(987654)
        ->and((bool) $progress->completed)->toBeTrue();
});

it('returns 404 when the course has no video_id', function (): void {
    $course = Course::factory()->create(['video_id' => null]);

    asSuperAdmin()
        ->post(route('courses.progress.store', $course))
        ->assertNotFound();

    expect(VideoProgress::query()->count())->toBe(0);
});

it('forbids users without a central role', function (): void {
    $course = Course::factory()->create(['video_id' => '987654']);

    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('courses.progress.store', $course))
        ->assertForbidden();

    expect(VideoProgress::query()->count())->toBe(0);
});
