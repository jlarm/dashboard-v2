<?php

declare(strict_types=1);

use App\Models\ViolationStatement;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('model_has_roles')->truncate();
    DB::table('users')->truncate();
    DB::table('violation_statements')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    Storage::fake('digitalocean');
});

describe('authorization', function (): void {
    it('forbids Consultants from deleting statements', function (): void {
        $statement = ViolationStatement::factory()->create();

        asConsultant()
            ->from(route('violation-statements.index'))
            ->delete(route('violation-statements.destroy', $statement))
            ->assertForbidden();

        expect(ViolationStatement::query()->whereKey($statement->id)->exists())->toBeTrue();
    });
});

describe('deletion', function (): void {
    it('deletes a statement and its stored image for super-admin', function (): void {
        $storagePath = 'violation-statements/doomed.jpg';
        Storage::disk('digitalocean')->put($storagePath, 'content');

        $statement = ViolationStatement::factory()->create([
            'reference_image_url' => 'https://test-bucket.nyc3.digitaloceanspaces.com/'.$storagePath,
        ]);

        asSuperAdmin()
            ->from(route('violation-statements.index'))
            ->delete(route('violation-statements.destroy', $statement))
            ->assertRedirect(route('violation-statements.index'));

        expect(ViolationStatement::query()->whereKey($statement->id)->exists())->toBeFalse();
        Storage::disk('digitalocean')->assertMissing($storagePath);
    });
});
