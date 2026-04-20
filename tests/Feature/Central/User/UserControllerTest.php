<?php

declare(strict_types=1);

use App\Models\Course;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('course_results')->truncate();
    DB::table('courses')->truncate();
    DB::table('model_has_roles')->truncate();
    DB::table('model_has_permissions')->truncate();
    DB::table('users')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

describe('index', function (): void {
    it('returns users and defers total courses count on initial render', function (): void {
        Course::factory()->count(3)->create();

        $user = User::factory()->create(['name' => 'Alpha User']);
        $user->assignRole('Consultant');

        asSuperAdmin()
            ->get(route('employees.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('central/user/Index')
                ->has('users.data')
                ->missing('totalCoursesCount')
            );
    });

    it('paginates users with a page size of 10', function (): void {
        User::factory()->count(15)->create();

        asSuperAdmin()
            ->get(route('employees.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('users.data', 10)
                ->where('users.meta.per_page', 10)
                ->where('users.meta.total', fn ($total): bool => $total >= 15)
            );
    });

    it('exposes the completed courses count per user from the index query subquery', function (): void {
        $user = User::factory()->create();
        $user->assignRole('Consultant');

        $course = Course::factory()->create();

        DB::table('course_results')->insert([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'percentage' => 100,
            'passed' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        asSuperAdmin()
            ->get(route('employees.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->where('users.data', fn ($data): bool => collect($data)
                    ->contains(fn (array $row): bool => $row['id'] === $user->id
                        && $row['completed_courses_count'] === 1)
                )
            );
    });

    it('denies consultants', function (): void {
        asConsultant()
            ->get(route('employees.index'))
            ->assertForbidden();
    });

    it('redirects guests to login', function (): void {
        $this->get(route('employees.index'))
            ->assertRedirect(route('login'));
    });
});

describe('show', function (): void {
    it('renders the user page with eager-loaded roles', function (): void {
        $user = User::factory()->create();
        $user->assignRole('Consultant');

        asSuperAdmin()
            ->get(route('employees.show', ['user' => $user->slug]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('central/user/Show')
                ->where('user.id', $user->id)
                ->where('user.role', 'Consultant')
            );
    });

    it('does not lazy-load roles on the resolved model', function (): void {
        $user = User::factory()->create();
        $user->assignRole('Consultant');

        // If show() forgot to eager-load, preventLazyLoading would throw here.
        asSuperAdmin()
            ->get(route('employees.show', ['user' => $user->slug]))
            ->assertOk();
    });

    it('does not ship completed_courses_count when not computed', function (): void {
        $user = User::factory()->create();
        $user->assignRole('Consultant');

        asSuperAdmin()
            ->get(route('employees.show', ['user' => $user->slug]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->missing('user.completed_courses_count')
            );
    });

    it('returns 404 for unknown slugs', function (): void {
        asSuperAdmin()
            ->get(route('employees.show', ['user' => 'nope-not-a-user']))
            ->assertNotFound();
    });

    it('denies consultants', function (): void {
        $user = User::factory()->create();

        asConsultant()
            ->get(route('employees.show', ['user' => $user->slug]))
            ->assertForbidden();
    });
});

describe('deleted', function (): void {
    it('lists only trashed users', function (): void {
        $active = User::factory()->create();
        $active->assignRole('Consultant');

        $trashed = User::factory()->create();
        $trashed->assignRole('Consultant');
        $trashed->delete();

        asSuperAdmin()
            ->get(route('employees.deleted'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('central/user/Deleted')
                ->has('users.data', 1)
                ->where('users.data.0.id', $trashed->id)
            );
    });

    it('denies consultants', function (): void {
        asConsultant()
            ->get(route('employees.deleted'))
            ->assertForbidden();
    });

    it('redirects guests to login', function (): void {
        $this->get(route('employees.deleted'))
            ->assertRedirect(route('login'));
    });
});
