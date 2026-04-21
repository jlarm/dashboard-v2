<?php

declare(strict_types=1);

use App\Enums\ViolationStatementCategory;
use App\Models\User;
use App\Models\ViolationStatement;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('model_has_roles')->truncate();
    DB::table('users')->truncate();
    DB::table('violation_statements')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

describe('authorization', function (): void {
    it('allows super-admin to view the index', function (): void {
        asSuperAdmin()
            ->get(route('violation-statements.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('central/violation-statements/Index')
                ->where('can.create', true)
                ->where('can.update', true)
                ->where('can.delete', true)
            );
    });

    it('allows Consultants to view the index but not create or modify', function (): void {
        asConsultant()
            ->get(route('violation-statements.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('central/violation-statements/Index')
                ->where('can.create', false)
                ->where('can.update', false)
                ->where('can.delete', false)
            );
    });

    it('forbids plain users from viewing the index', function (): void {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('violation-statements.index'))
            ->assertForbidden();
    });
});

describe('filtering', function (): void {
    it('filters by statement search term', function (): void {
        ViolationStatement::factory()->create(['statement' => 'Missing posted OSHA notice']);
        ViolationStatement::factory()->create(['statement' => 'Unlabeled secondary container']);

        asSuperAdmin()
            ->get(route('violation-statements.index', ['search' => 'posted']))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('statements.data', 1)
                ->where('statements.data.0.statement', 'Missing posted OSHA notice')
            );
    });

    it('filters by category', function (): void {
        ViolationStatement::factory()->create([
            'statement' => 'OSHA item',
            'categories' => [ViolationStatementCategory::Osha->value],
        ]);
        ViolationStatement::factory()->create([
            'statement' => 'GLBA item',
            'categories' => [ViolationStatementCategory::Glba->value],
        ]);

        asSuperAdmin()
            ->get(route('violation-statements.index', ['category' => ViolationStatementCategory::Glba->value]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('statements.data', 1)
                ->where('statements.data.0.statement', 'GLBA item')
            );
    });
});
