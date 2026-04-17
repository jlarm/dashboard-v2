<?php

declare(strict_types=1);

use App\Http\Livewire\Central\Employee\Index;
use App\Models\Course;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    $this->actingAs(User::factory()->create());
});

it('renders the employee index with users', function (): void {
    $users = User::factory()->count(3)->create();

    Livewire::test(Index::class)
        ->assertStatus(200)
        ->assertSee($users->first()->name);
});

it('passes totalCourses and completed counts to each index-item', function (): void {
    $course = Course::factory()->create();
    $user = User::factory()->create();

    DB::table('course_results')->insert([
        'course_id' => $course->id,
        'user_id' => $user->id,
        'percentage' => 100,
        'passed' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    Livewire::test(Index::class)
        ->assertStatus(200)
        ->assertSee($user->name)
        ->assertSee('1 of 1 passed');
});

it('shows zero completed for users with no course results', function (): void {
    User::factory()->create();

    Course::factory()->count(2)->create();

    Livewire::test(Index::class)
        ->assertStatus(200)
        ->assertSee('0 of');
});

it('does not count failed course results as completed', function (): void {
    $course = Course::factory()->create();
    $user = User::factory()->create();

    DB::table('course_results')->insert([
        'course_id' => $course->id,
        'user_id' => $user->id,
        'percentage' => 40,
        'passed' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    Livewire::test(Index::class)
        ->assertStatus(200)
        ->assertSee('0 of');
});

it('does not count course results older than one year', function (): void {
    $course = Course::factory()->create();
    $user = User::factory()->create();

    DB::table('course_results')->insert([
        'course_id' => $course->id,
        'user_id' => $user->id,
        'percentage' => 100,
        'passed' => 1,
        'created_at' => now()->subYear()->subDay(),
        'updated_at' => now()->subYear()->subDay(),
    ]);

    Livewire::test(Index::class)
        ->assertStatus(200)
        ->assertSee('0 of');
});
