<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Store\SingleStore\Employee\Index;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\Department;
use App\Models\User;
use Livewire\Livewire;

describe('single store employee index query optimization', function (): void {
    it('loads only relevant completion-window results and avoids eager loading courses', function (): void {
        $department = Department::query()->create([
            'name' => 'Parts '.uniqid(),
            'slug' => 'parts-'.uniqid(),
        ]);

        $store = Store::query()->firstOrFail();

        $employee = User::query()->create([
            'name' => 'Store Employee',
            'email' => 'single-store-index@test.com',
            'password' => bcrypt('password'),
            'department_id' => $department->id,
        ]);
        $employee->assignRole('Employee');
        $employee->stores()->attach($store->id);

        $course = Course::query()->create([
            'name' => 'Store Relevant Course',
            'slug' => 'store-relevant-course-'.uniqid(),
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $oldResult = CourseResults::query()->create([
            'user_id' => $employee->id,
            'course_id' => $course->id,
            'passed' => 1,
            'percentage' => 100,
            'created_at' => now()->subYears(4),
            'updated_at' => now()->subYears(4),
        ]);

        $recentResult = CourseResults::query()->create([
            'user_id' => $employee->id,
            'course_id' => $course->id,
            'passed' => 1,
            'percentage' => 100,
            'created_at' => now()->subMonths(2),
            'updated_at' => now()->subMonths(2),
        ]);

        $this->actingAs($this->consultant);

        Livewire::test(Index::class, ['store' => $store])
            ->assertStatus(200)
            ->assertViewHas('users', function ($users) use ($employee, $oldResult, $recentResult): bool {
                $indexedEmployee = collect($users->items())->firstWhere('id', $employee->id);
                if (! $indexedEmployee instanceof User) {
                    return false;
                }

                if (! $indexedEmployee->relationLoaded('results')) {
                    return false;
                }

                $resultIds = $indexedEmployee->results->pluck('id')->all();

                return in_array($recentResult->id, $resultIds, true)
                    && ! in_array($oldResult->id, $resultIds, true)
                    && ! $indexedEmployee->relationLoaded('courses');
            });
    });

    it('renders additional assigned stores in a compact +count popover', function (): void {
        $this->tenant->locations = true;
        $this->tenant->save();

        $department = Department::query()->create([
            'name' => 'Accounting '.uniqid(),
            'slug' => 'accounting-'.uniqid(),
        ]);

        $primaryStore = Store::query()->firstOrFail();
        $secondaryStore = Store::query()->create([
            'name' => 'Satellite Store '.uniqid(),
            'slug' => 'satellite-store-'.uniqid(),
            'state' => 'Illinois',
        ]);

        $employee = User::query()->create([
            'name' => 'Single Store Multi Assignment',
            'email' => 'single-store-multi@test.com',
            'password' => bcrypt('password'),
            'department_id' => $department->id,
        ]);
        $employee->assignRole('Employee');
        $employee->stores()->attach([$primaryStore->id, $secondaryStore->id]);

        $this->actingAs($this->consultant);

        Livewire::test(Index::class, ['store' => $primaryStore])
            ->assertOk()
            ->assertSee($primaryStore->name)
            ->assertSee('+1')
            ->assertSee('All Stores')
            ->assertSee($secondaryStore->name);
    });
});
