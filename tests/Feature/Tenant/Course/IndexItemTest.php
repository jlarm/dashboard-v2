<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Course\IndexItem;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\User;
use Livewire\Livewire;

describe('Course IndexItem Component - DOT Module Tracking', function () {
    it('tracks dot module 1 completion status', function () {
        $course = Course::create([
            'name' => 'DOT Hazardous Materials Transportation',
            'slug' => 'dot-hazardous-materials-transportation',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'dot-module1@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        Store::create([
            'name' => 'Test Store',
            'slug' => 'test-store',
            'state' => 'Texas',
        ]);

        // Create a passing result
        CourseResults::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'passed' => true,
            'score' => 90,
            'percentage' => 90,
        ]);

        $this->actingAs($user);

        Livewire::test(IndexItem::class, ['course' => $course])
            ->assertSet('module1', true);
    });

    it('tracks dot module 2 completion status', function () {
        $course = Course::create([
            'name' => 'DOT Identifying Hazardous Materials',
            'slug' => 'dot-hazardous-materials-transportation-identifying-hazardous-materials',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'dot-module2@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        Store::create([
            'name' => 'Test Store 2',
            'slug' => 'test-store-2',
            'state' => 'Texas',
        ]);

        // Create a passing result
        CourseResults::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'passed' => true,
            'score' => 85,
            'percentage' => 85,
        ]);

        $this->actingAs($user);

        Livewire::test(IndexItem::class, ['course' => $course])
            ->assertSet('module2', true);
    });

    it('tracks dot module 3 completion status', function () {
        $course = Course::create([
            'name' => 'DOT Preparing Hazardous Materials for Shipment',
            'slug' => 'dot-hazardous-materials-transportation-preparing-hazardous-materials-for-shipment',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'dot-module3@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        Store::create([
            'name' => 'Test Store 3',
            'slug' => 'test-store-3',
            'state' => 'Texas',
        ]);

        // Create a passing result
        CourseResults::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'passed' => true,
            'score' => 95,
            'percentage' => 95,
        ]);

        $this->actingAs($user);

        Livewire::test(IndexItem::class, ['course' => $course])
            ->assertSet('module3', true);
    });

    it('shows null for incomplete dot modules', function () {
        $course = Course::create([
            'name' => 'DOT Hazardous Materials Transportation',
            'slug' => 'dot-hazardous-materials-transportation',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'dot-incomplete@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        Store::create([
            'name' => 'Test Store 4',
            'slug' => 'test-store-4',
            'state' => 'Texas',
        ]);

        $this->actingAs($user);

        Livewire::test(IndexItem::class, ['course' => $course])
            ->assertSet('module1', null)
            ->assertSet('module2', null)
            ->assertSet('module3', null);
    });

    it('shows false for failed dot module attempts', function () {
        $course = Course::create([
            'name' => 'DOT Hazardous Materials Transportation',
            'slug' => 'dot-hazardous-materials-transportation',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'dot-failed@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        Store::create([
            'name' => 'Test Store 5',
            'slug' => 'test-store-5',
            'state' => 'Texas',
        ]);

        // Create a failing result
        CourseResults::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'passed' => false,
            'score' => 50,
            'percentage' => 50,
        ]);

        $this->actingAs($user);

        Livewire::test(IndexItem::class, ['course' => $course])
            ->assertSet('module1', false);
    });

    it('uses latest result for dot module status', function () {
        $course = Course::create([
            'name' => 'DOT Hazardous Materials Transportation',
            'slug' => 'dot-hazardous-materials-transportation',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'dot-retake@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        Store::create([
            'name' => 'Test Store 6',
            'slug' => 'test-store-6',
            'state' => 'Texas',
        ]);

        // Create failing result first
        CourseResults::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'passed' => false,
            'score' => 50,
            'percentage' => 50,
            'created_at' => now()->subDays(2),
        ]);

        // Create passing result later
        CourseResults::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'passed' => true,
            'score' => 90,
            'percentage' => 90,
            'created_at' => now()->subDay(),
        ]);

        $this->actingAs($user);

        Livewire::test(IndexItem::class, ['course' => $course])
            ->assertSet('module1', true);
    });

    it('loads default store when no user stores exist', function () {
        $course = Course::create([
            'name' => 'Test Course',
            'slug' => 'test-course-store',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $store = Store::create([
            'name' => 'Default Store',
            'slug' => 'default-store',
            'state' => 'Texas',
        ]);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'dot-default-store@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $this->actingAs($user);

        Livewire::test(IndexItem::class, ['course' => $course])
            ->assertSet('store', fn ($store) => $store instanceof Store);
    });
});
