<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Home\TrainingCompliance;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

it('renders compliance totals and priority training alerts for the current store scope', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    $employeeRole = Role::query()->where('name', 'Employee')->firstOrFail();
    $course = Course::query()->create([
        'name' => 'Widget Compliance '.uniqid(),
        'slug' => 'widget-compliance-'.uniqid(),
        'slides' => [],
        'questions' => [],
        'optional' => false,
        'years_expires' => 1,
    ]);
    $course->roles()->attach($employeeRole->id);

    $overdueEmployee = User::query()->create([
        'name' => 'Widget Overdue Employee',
        'email' => 'widget-overdue@test.com',
        'password' => bcrypt('password'),
    ]);
    $overdueEmployee->assignRole('Employee');
    $overdueEmployee->stores()->attach($store->id);

    $expiringSoonEmployee = User::query()->create([
        'name' => 'Widget Expiring Employee',
        'email' => 'widget-expiring@test.com',
        'password' => bcrypt('password'),
    ]);
    $expiringSoonEmployee->assignRole('Employee');
    $expiringSoonEmployee->stores()->attach($store->id);

    $compliantEmployee = User::query()->create([
        'name' => 'Widget Compliant Employee',
        'email' => 'widget-compliant@test.com',
        'password' => bcrypt('password'),
    ]);
    $compliantEmployee->assignRole('Employee');
    $compliantEmployee->stores()->attach($store->id);

    CourseResults::query()->create([
        'user_id' => $overdueEmployee->id,
        'course_id' => $course->id,
        'passed' => 1,
        'percentage' => 100,
        'created_at' => now()->subYears(2),
        'updated_at' => now()->subYears(2),
    ]);

    CourseResults::query()->create([
        'user_id' => $expiringSoonEmployee->id,
        'course_id' => $course->id,
        'passed' => 1,
        'percentage' => 100,
        'created_at' => now()->subYear()->addDays(10),
        'updated_at' => now()->subYear()->addDays(10),
    ]);

    CourseResults::query()->create([
        'user_id' => $compliantEmployee->id,
        'course_id' => $course->id,
        'passed' => 1,
        'percentage' => 100,
        'created_at' => now()->subMonths(1),
        'updated_at' => now()->subMonths(1),
    ]);

    app()->instance('currentStore', $store->id);
    app()->instance('scopedStoreIds', collect([$store->id]));

    Livewire::actingAs($this->consultant)
        ->test(TrainingCompliance::class)
        ->call('loadStats')
        ->assertSee('Training Compliance Snapshot')
        ->assertSee('Overdue')
        ->assertSee('At Risk')
        ->assertSee('Priority Alerts')
        ->assertSee('Widget Overdue Employee')
        ->assertSee('Widget Expiring Employee')
        ->assertSee('Widget Compliant Employee');
});
