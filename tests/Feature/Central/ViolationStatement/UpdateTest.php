<?php

declare(strict_types=1);

use App\Enums\ViolationStatementCategory;
use App\Models\ViolationStatement;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Http\UploadedFile;
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
    it('forbids Consultants from updating statements', function (): void {
        $statement = ViolationStatement::factory()->create();

        asConsultant()
            ->from(route('violation-statements.index'))
            ->patch(route('violation-statements.update', $statement), [
                'statement' => 'Changed',
                'weight' => 5,
                'categories' => [ViolationStatementCategory::Osha->value],
            ])
            ->assertForbidden();
    });
});

describe('updates', function (): void {
    it('updates statement fields for super-admin', function (): void {
        $statement = ViolationStatement::factory()->create([
            'statement' => 'Original',
            'weight' => 2,
            'categories' => [ViolationStatementCategory::Osha->value],
        ]);

        asSuperAdmin()
            ->from(route('violation-statements.index'))
            ->patch(route('violation-statements.update', $statement), [
                'statement' => 'Updated',
                'weight' => 9,
                'categories' => [ViolationStatementCategory::Glba->value],
                'keywords' => ['a', 'b'],
            ])
            ->assertRedirect(route('violation-statements.index'));

        $statement->refresh();

        expect($statement->statement)->toBe('Updated');
        expect($statement->weight)->toBe(9);
        expect($statement->categories->all())->toBe([ViolationStatementCategory::Glba]);
        expect($statement->keywords)->toBe(['a', 'b']);
    });

    it('deletes the old stored image when a new image is uploaded', function (): void {
        $storagePath = 'violation-statements/old-image.jpg';
        Storage::disk('digitalocean')->put($storagePath, 'old content');

        $statement = ViolationStatement::factory()->create([
            'reference_image_url' => 'https://test-bucket.nyc3.digitaloceanspaces.com/'.$storagePath,
        ]);

        asSuperAdmin()
            ->from(route('violation-statements.index'))
            ->patch(route('violation-statements.update', $statement), [
                'statement' => $statement->statement,
                'weight' => $statement->weight,
                'categories' => $statement->categories->map->value->all(),
                'image' => UploadedFile::fake()->image('new-image.jpg'),
            ]);

        Storage::disk('digitalocean')->assertMissing($storagePath);
        expect($statement->fresh()->reference_image_url)->not->toBe('https://test-bucket.nyc3.digitaloceanspaces.com/'.$storagePath);
    });

    it('removes the stored image when remove_image is set', function (): void {
        $storagePath = 'violation-statements/to-remove.jpg';
        Storage::disk('digitalocean')->put($storagePath, 'bytes');

        $statement = ViolationStatement::factory()->create([
            'reference_image_url' => 'https://test-bucket.nyc3.digitaloceanspaces.com/'.$storagePath,
        ]);

        asSuperAdmin()
            ->from(route('violation-statements.index'))
            ->patch(route('violation-statements.update', $statement), [
                'statement' => $statement->statement,
                'weight' => $statement->weight,
                'categories' => $statement->categories->map->value->all(),
                'remove_image' => '1',
            ]);

        Storage::disk('digitalocean')->assertMissing($storagePath);
        expect($statement->fresh()->reference_image_url)->toBeNull();
    });
});
