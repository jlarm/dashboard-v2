<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Employee\Index;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\Department;
use App\Models\User;
use Livewire\Livewire;

describe('employee index component query optimization', function (): void {
    it('eager loads only relevant completion window course results', function (): void {
        $department = Department::query()->create([
            'name' => 'Service '.uniqid(),
            'slug' => 'service-'.uniqid(),
        ]);

        $store = Store::query()->firstOrFail();

        $employee = User::query()->create([
            'name' => 'Employee Example',
            'email' => 'employee-index@test.com',
            'password' => bcrypt('password'),
            'department_id' => $department->id,
        ]);
        $employee->assignRole('Employee');
        $employee->stores()->attach($store->id);

        $course = Course::query()->create([
            'name' => 'Relevant Course',
            'slug' => 'relevant-course-'.uniqid(),
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
            'created_at' => now()->subMonths(3),
            'updated_at' => now()->subMonths(3),
        ]);

        $this->actingAs($this->consultant);

        Livewire::test(Index::class)
            ->assertOk()
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
                    && ! in_array($oldResult->id, $resultIds, true);
            });
    });

    it('renders multiple stores as primary store with a compact additional count', function (): void {
        $this->tenant->locations = true;
        $this->tenant->save();

        $department = Department::query()->create([
            'name' => 'Sales '.uniqid(),
            'slug' => 'sales-'.uniqid(),
        ]);

        $primaryStore = Store::query()->firstOrFail();
        $secondaryStore = Store::query()->create([
            'name' => 'Secondary Store '.uniqid(),
            'slug' => 'secondary-store-'.uniqid(),
            'state' => 'Indiana',
        ]);

        $employee = User::query()->create([
            'name' => 'Multi Store Employee',
            'email' => 'multi-store-employee@test.com',
            'password' => bcrypt('password'),
            'department_id' => $department->id,
        ]);
        $employee->assignRole('Employee');
        $employee->stores()->attach([$primaryStore->id, $secondaryStore->id]);

        $this->actingAs($this->consultant);

        Livewire::test(Index::class)
            ->assertOk()
            ->assertSee($primaryStore->name)
            ->assertSee('+1')
            ->assertSee('All Stores')
            ->assertSee($secondaryStore->name);
    });
});
