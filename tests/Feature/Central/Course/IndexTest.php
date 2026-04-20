<?php

declare(strict_types=1);

use App\Models\Course;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
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
});

describe('authorization', function (): void {
    it('redirects guests to login', function (): void {
        $this->get(route('courses.index'))->assertRedirect(route('login'));
    });

    it('forbids users with neither super-admin nor Consultant', function (): void {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('courses.index'))
            ->assertForbidden();
    });

    it('allows super-admins', function (): void {
        asSuperAdmin()
            ->get(route('courses.index'))
            ->assertOk();
    });

    it('allows Consultants', function (): void {
        asConsultant()
            ->get(route('courses.index'))
            ->assertOk();
    });
});

describe('initial render', function (): void {
    it('renders the index component with paginated courses', function (): void {
        Course::query()->create([
            'slug' => 'alpha-course',
            'name' => 'Alpha Course',
            'slides' => [],
            'questions' => [],
        ]);
        Course::query()->create([
            'slug' => 'bravo-course',
            'name' => 'Bravo Course',
            'slides' => [],
            'questions' => [],
        ]);

        asSuperAdmin()
            ->get(route('courses.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('central/course/Index')
                ->has('courses.data', 2)
                ->where('courses.data.0.status.label', 'Not Started')
            );
    });
});
