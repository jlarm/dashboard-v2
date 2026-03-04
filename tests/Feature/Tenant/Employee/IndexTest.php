<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Employee\Index;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

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
        app()->instance('currentStore', null);
        app()->instance('scopedStoreIds', collect([$store->id]));

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

        $this->consultant->update([
            'current_store_id' => null,
        ]);

        $this->actingAs($this->consultant);
        app()->instance('currentStore', null);
        app()->instance('scopedStoreIds', collect([$primaryStore->id, $secondaryStore->id]));

        Livewire::test(Index::class)
            ->assertOk()
            ->assertSee($primaryStore->name)
            ->assertSee('+1')
            ->assertSee('All Stores')
            ->assertSee('x-teleport="body"', false)
            ->assertSee($secondaryStore->name);
    });

    it('filters employees by current store id for regular users', function (): void {
        $this->tenant->locations = true;
        $this->tenant->save();

        $storeA = Store::query()->firstOrFail();
        $storeB = Store::query()->create([
            'name' => 'Scoped Store B '.uniqid(),
            'slug' => 'scoped-store-b-'.uniqid(),
            'state' => 'Indiana',
        ]);

        $manager = User::query()->create([
            'name' => 'Store Scoped Manager',
            'email' => 'store-scoped-manager@test.com',
            'password' => bcrypt('password'),
            'current_store_id' => $storeA->id,
        ]);
        $manager->assignRole('Manager');
        $manager->stores()->attach([$storeA->id, $storeB->id]);

        $employeeInStoreA = User::query()->create([
            'name' => 'Employee In Store A',
            'email' => 'employee-in-store-a@test.com',
            'password' => bcrypt('password'),
        ]);
        $employeeInStoreA->assignRole('Employee');
        $employeeInStoreA->stores()->attach($storeA->id);

        $employeeInStoreB = User::query()->create([
            'name' => 'Employee In Store B',
            'email' => 'employee-in-store-b@test.com',
            'password' => bcrypt('password'),
        ]);
        $employeeInStoreB->assignRole('Employee');
        $employeeInStoreB->stores()->attach($storeB->id);

        $this->actingAs($manager);
        app()->instance('currentStore', $storeA->id);
        app()->instance('scopedStoreIds', collect([$storeA->id]));

        Livewire::test(Index::class)
            ->assertOk()
            ->assertViewHas('users', function ($users) use ($employeeInStoreA, $employeeInStoreB): bool {
                $ids = collect($users->items())->pluck('id')->all();

                return in_array($employeeInStoreA->id, $ids, true)
                    && ! in_array($employeeInStoreB->id, $ids, true);
            });
    });

    it('shows employees across all assigned stores when current store is null for regular users', function (): void {
        $this->tenant->locations = true;
        $this->tenant->save();

        $storeA = Store::query()->firstOrFail();
        $storeB = Store::query()->create([
            'name' => 'Overview Store B '.uniqid(),
            'slug' => 'overview-store-b-'.uniqid(),
            'state' => 'Indiana',
        ]);

        $manager = User::query()->create([
            'name' => 'Overview Manager',
            'email' => 'overview-manager@test.com',
            'password' => bcrypt('password'),
            'current_store_id' => null,
        ]);
        $manager->assignRole('Manager');
        $manager->stores()->attach([$storeA->id, $storeB->id]);

        $employeeInStoreA = User::query()->create([
            'name' => 'Overview Employee A',
            'email' => 'overview-employee-a@test.com',
            'password' => bcrypt('password'),
        ]);
        $employeeInStoreA->assignRole('Employee');
        $employeeInStoreA->stores()->attach($storeA->id);

        $employeeInStoreB = User::query()->create([
            'name' => 'Overview Employee B',
            'email' => 'overview-employee-b@test.com',
            'password' => bcrypt('password'),
        ]);
        $employeeInStoreB->assignRole('Employee');
        $employeeInStoreB->stores()->attach($storeB->id);

        $this->actingAs($manager);
        app()->instance('currentStore', null);
        app()->instance('scopedStoreIds', collect([$storeA->id, $storeB->id]));

        Livewire::test(Index::class)
            ->assertOk()
            ->assertViewHas('users', function ($users) use ($employeeInStoreA, $employeeInStoreB): bool {
                $ids = collect($users->items())->pluck('id')->all();

                return in_array($employeeInStoreA->id, $ids, true)
                    && in_array($employeeInStoreB->id, $ids, true);
            });
    });

    it('does not issue per-user california store existence queries when current store is null', function (): void {
        $this->tenant->locations = true;
        $this->tenant->save();

        $storeA = Store::query()->firstOrFail();
        $storeB = Store::query()->create([
            'name' => 'Query Overview Store B '.uniqid(),
            'slug' => 'query-overview-store-b-'.uniqid(),
            'state' => 'Indiana',
        ]);

        $manager = User::query()->create([
            'name' => 'Query Overview Manager',
            'email' => 'query-overview-manager@test.com',
            'password' => bcrypt('password'),
            'current_store_id' => null,
        ]);
        $manager->assignRole('Manager');
        $manager->stores()->attach([$storeA->id, $storeB->id]);

        foreach (range(1, 3) as $index) {
            $employee = User::query()->create([
                'name' => 'Query Overview Employee '.$index,
                'email' => "query-overview-employee-{$index}@test.com",
                'password' => bcrypt('password'),
            ]);
            $employee->assignRole('Employee');
            $employee->stores()->attach($index % 2 === 0 ? $storeB->id : $storeA->id);
        }

        $this->actingAs($manager);
        app()->instance('currentStore', null);
        app()->instance('scopedStoreIds', collect([$storeA->id, $storeB->id]));

        DB::flushQueryLog();
        DB::enableQueryLog();

        Livewire::test(Index::class)->assertOk();

        $duplicateStoreExistsQueries = collect(DB::getQueryLog())
            ->filter(fn (array $query): bool => str_contains((string) $query['query'], 'select exists(select * from `stores` inner join `store_user`')
                    && str_contains((string) $query['query'], 'and `state` = ?')
                    && in_array('California', $query['bindings'], true))
            ->count();

        expect($duplicateStoreExistsQueries)->toBe(0);
    });

    it('filters employees by current store id for consultant users', function (): void {
        $this->tenant->locations = true;
        $this->tenant->save();

        $storeA = Store::query()->firstOrFail();
        $storeB = Store::query()->create([
            'name' => 'Consultant Scoped Store B '.uniqid(),
            'slug' => 'consultant-scoped-store-b-'.uniqid(),
            'state' => 'Indiana',
        ]);

        $this->consultant->update([
            'current_store_id' => $storeA->id,
        ]);

        $employeeInStoreA = User::query()->create([
            'name' => 'Consultant Scoped Employee A',
            'email' => 'consultant-scoped-employee-a@test.com',
            'password' => bcrypt('password'),
        ]);
        $employeeInStoreA->assignRole('Employee');
        $employeeInStoreA->stores()->attach($storeA->id);

        $employeeInStoreB = User::query()->create([
            'name' => 'Consultant Scoped Employee B',
            'email' => 'consultant-scoped-employee-b@test.com',
            'password' => bcrypt('password'),
        ]);
        $employeeInStoreB->assignRole('Employee');
        $employeeInStoreB->stores()->attach($storeB->id);

        $this->actingAs($this->consultant);
        app()->instance('currentStore', $storeA->id);
        app()->instance('scopedStoreIds', collect([$storeA->id]));

        Livewire::test(Index::class)
            ->assertOk()
            ->assertViewHas('users', function ($users) use ($employeeInStoreA, $employeeInStoreB): bool {
                $ids = collect($users->items())->pluck('id')->all();

                return in_array($employeeInStoreA->id, $ids, true)
                    && ! in_array($employeeInStoreB->id, $ids, true);
            });
    });

    it('builds overdue compliance summaries when required courses are expired', function (): void {
        $store = Store::query()->firstOrFail();
        $employeeRole = Role::query()->where('name', 'Employee')->firstOrFail();

        $course = Course::query()->create([
            'name' => 'Annual Compliance '.uniqid(),
            'slug' => 'annual-compliance-'.uniqid(),
            'slides' => [],
            'questions' => [],
            'optional' => false,
            'years_expires' => 1,
        ]);
        $course->roles()->attach($employeeRole->id);

        $employee = User::query()->create([
            'name' => 'Expired Worker',
            'email' => 'expired-worker@test.com',
            'password' => bcrypt('password'),
        ]);
        $employee->assignRole('Employee');
        $employee->stores()->attach($store->id);

        CourseResults::query()->create([
            'user_id' => $employee->id,
            'course_id' => $course->id,
            'passed' => 1,
            'percentage' => 100,
            'created_at' => now()->subYears(2),
            'updated_at' => now()->subYears(2),
        ]);

        $this->actingAs($this->consultant);
        app()->instance('currentStore', $store->id);
        app()->instance('scopedStoreIds', collect([$store->id]));

        Livewire::test(Index::class)
            ->assertOk()
            ->assertViewHas('trainingSummaries', function (Collection $trainingSummaries) use ($employee): bool {
                $summary = $trainingSummaries->get($employee->id);

                return is_array($summary)
                    && $summary['status'] === 'overdue'
                    && $summary['expired'] > 0
                    && $summary['not_completed'] > 0;
            });
    });

    it('filters the list to only employees with expired courses', function (): void {
        $store = Store::query()->firstOrFail();
        $employeeRole = Role::query()->where('name', 'Employee')->firstOrFail();

        $course = Course::query()->create([
            'name' => 'Filter Compliance '.uniqid(),
            'slug' => 'filter-compliance-'.uniqid(),
            'slides' => [],
            'questions' => [],
            'optional' => false,
            'years_expires' => 1,
        ]);
        $course->roles()->attach($employeeRole->id);

        $expiredEmployee = User::query()->create([
            'name' => 'Expired Only Employee',
            'email' => 'expired-only-employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $expiredEmployee->assignRole('Employee');
        $expiredEmployee->stores()->attach($store->id);

        $compliantEmployee = User::query()->create([
            'name' => 'Compliant Employee',
            'email' => 'compliant-employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $compliantEmployee->assignRole('Employee');
        $compliantEmployee->stores()->attach($store->id);

        CourseResults::query()->create([
            'user_id' => $expiredEmployee->id,
            'course_id' => $course->id,
            'passed' => 1,
            'percentage' => 100,
            'created_at' => now()->subYears(2),
            'updated_at' => now()->subYears(2),
        ]);

        CourseResults::query()->create([
            'user_id' => $compliantEmployee->id,
            'course_id' => $course->id,
            'passed' => 1,
            'percentage' => 100,
            'created_at' => now()->subMonths(2),
            'updated_at' => now()->subMonths(2),
        ]);

        $this->actingAs($this->consultant);
        app()->instance('currentStore', $store->id);
        app()->instance('scopedStoreIds', collect([$store->id]));

        Livewire::test(Index::class)
            ->set('showExpiredCourseUsers', true)
            ->assertSee('Expired Only Employee')
            ->assertDontSee('Compliant Employee');
    });

    it('filters the list to only employees with courses expiring soon', function (): void {
        $store = Store::query()->firstOrFail();
        $employeeRole = Role::query()->where('name', 'Employee')->firstOrFail();

        $course = Course::query()->create([
            'name' => 'Expiring Soon Compliance '.uniqid(),
            'slug' => 'expiring-soon-compliance-'.uniqid(),
            'slides' => [],
            'questions' => [],
            'optional' => false,
            'years_expires' => 1,
        ]);
        $course->roles()->attach($employeeRole->id);

        $expiringSoonEmployee = User::query()->create([
            'name' => 'Expiring Soon Employee',
            'email' => 'expiring-soon-employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $expiringSoonEmployee->assignRole('Employee');
        $expiringSoonEmployee->stores()->attach($store->id);

        $compliantEmployee = User::query()->create([
            'name' => 'Stable Compliant Employee',
            'email' => 'stable-compliant-employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $compliantEmployee->assignRole('Employee');
        $compliantEmployee->stores()->attach($store->id);

        CourseResults::query()->create([
            'user_id' => $expiringSoonEmployee->id,
            'course_id' => $course->id,
            'passed' => 1,
            'percentage' => 100,
            'created_at' => now()->subYear()->addDays(20),
            'updated_at' => now()->subYear()->addDays(20),
        ]);

        CourseResults::query()->create([
            'user_id' => $compliantEmployee->id,
            'course_id' => $course->id,
            'passed' => 1,
            'percentage' => 100,
            'created_at' => now()->subMonths(3),
            'updated_at' => now()->subMonths(3),
        ]);

        $this->actingAs($this->consultant);
        app()->instance('currentStore', $store->id);
        app()->instance('scopedStoreIds', collect([$store->id]));

        Livewire::test(Index::class)
            ->set('showExpiringSoonCourseUsers', true)
            ->assertSee('Expiring Soon Employee')
            ->assertDontSee('Stable Compliant Employee');
    });

    it('provides training counts for the employee stats summary cards', function (): void {
        $store = Store::query()->firstOrFail();

        $employee = User::query()->create([
            'name' => 'Stats Summary Employee',
            'email' => 'stats-summary-employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $employee->assignRole('Employee');
        $employee->stores()->attach($store->id);

        $this->actingAs($this->consultant);
        app()->instance('currentStore', $store->id);
        app()->instance('scopedStoreIds', collect([$store->id]));

        Livewire::test(Index::class)
            ->assertViewHas('trainingCounts', fn (array $trainingCounts): bool => isset(
                $trainingCounts['employees'],
                $trainingCounts['compliant'],
                $trainingCounts['at_risk'],
                $trainingCounts['overdue'],
                $trainingCounts['unassigned'],
                $trainingCounts['incomplete_courses'],
                $trainingCounts['expired_courses'],
                $trainingCounts['expiring_soon_courses']
            ) && $trainingCounts['employees'] > 0);
    });

    it('shows a qualified individual icon next to the name instead of a role badge', function (): void {
        $store = Store::query()->firstOrFail();

        $qualifiedIndividual = User::query()->create([
            'name' => 'Qualified Individual Employee',
            'email' => 'qualified-individual-employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $qualifiedIndividual->assignRole(['Manager', 'Qualified Individual']);
        $qualifiedIndividual->stores()->attach($store->id);

        $this->actingAs($this->consultant);
        app()->instance('currentStore', $store->id);
        app()->instance('scopedStoreIds', collect([$store->id]));

        Livewire::test(Index::class)
            ->assertOk()
            ->assertSee('Qualified Individual Employee')
            ->assertSeeHtml('data-qi-indicator')
            ->assertSee('Qualified Individual')
            ->assertSeeHtml('data-role-badge="manager"')
            ->assertDontSeeHtml('data-role-badge="qualified-individual"');
    });
});
