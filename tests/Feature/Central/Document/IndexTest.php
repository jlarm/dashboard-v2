<?php

declare(strict_types=1);

use App\Models\Document;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('model_has_roles')->truncate();
    DB::table('users')->truncate();
    DB::table('documents')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

describe('authorization', function (): void {
    it('redirects guests to login', function (): void {
        $this->get(route('documents.index'))->assertRedirect(route('login'));
    });

    it('forbids users with neither super-admin nor Consultant', function (): void {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('documents.index'))
            ->assertForbidden();
    });

    it('allows super-admins', function (): void {
        asSuperAdmin()
            ->get(route('documents.index'))
            ->assertOk();
    });

    it('allows Consultants', function (): void {
        asConsultant()
            ->get(route('documents.index'))
            ->assertOk();
    });
});

describe('initial render', function (): void {
    it('renders the index component with paginated documents', function (): void {
        Document::factory()->create(['title' => 'Alpha Handbook']);
        Document::factory()->create(['title' => 'Bravo Handbook']);

        asSuperAdmin()
            ->get(route('documents.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('central/document/Index')
                ->has('documents.data', 2)
                ->where('documents.data.0.title', 'Alpha Handbook')
                ->has('filters')
                ->where('can.create', true)
                ->where('can.delete', true)
            );
    });

    it('filters documents by title via search query', function (): void {
        Document::factory()->create(['title' => 'Safety Manual']);
        Document::factory()->create(['title' => 'Finance Policy']);

        asSuperAdmin()
            ->get(route('documents.index', ['search' => 'Safety']))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('central/document/Index')
                ->has('documents.data', 1)
                ->where('documents.data.0.title', 'Safety Manual')
                ->where('filters.search', 'Safety')
            );
    });

    it('exposes narrower permissions for Consultants', function (): void {
        asConsultant()
            ->get(route('documents.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->where('can.create', false)
                ->where('can.delete', false)
            );
    });
});
