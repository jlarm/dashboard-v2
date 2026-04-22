<?php

declare(strict_types=1);

use App\Models\Course;
use App\Services\VimeoService;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Mockery\MockInterface;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('model_has_roles')->truncate();
    DB::table('users')->truncate();
    DB::table('course_results')->truncate();
    DB::table('courses')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    $this->mock(VimeoService::class, function (MockInterface $mock): void {
        $mock->shouldReceive('getVideo')->andReturn(null);
    });
});

it('renders the show component with slides and a signed quiz link for super-admin', function (): void {
    $course = Course::factory()->create([
        'slides' => [['title' => 'Slide 1', 'description' => '<p>Hi</p>']],
    ]);

    asSuperAdmin()
        ->get(route('courses.show', $course))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('central/course/Show')
            ->where('course.slug', $course->slug)
            ->has('slides', 1)
            ->has('quiz_link')
            ->where('video_completed', false)
        );
});

it('renders the show component for Consultants', function (): void {
    $course = Course::factory()->create();

    asConsultant()
        ->get(route('courses.show', $course))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('central/course/Show'));
});

it('returns 404 for an unknown course slug', function (): void {
    asSuperAdmin()
        ->get(route('courses.show', 'does-not-exist'))
        ->assertNotFound();
});
