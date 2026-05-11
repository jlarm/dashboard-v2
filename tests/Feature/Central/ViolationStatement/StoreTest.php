<?php

declare(strict_types=1);

use App\Enums\ViolationStatementCategory;
use App\Models\User;
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
    it('forbids Consultants from creating statements', function (): void {
        asConsultant()
            ->from(route('violation-statements.index'))
            ->post(route('violation-statements.store'), [
                'statement' => 'Blocked',
                'weight' => 5,
                'categories' => [ViolationStatementCategory::Osha->value],
            ])
            ->assertForbidden();

        expect(ViolationStatement::query()->count())->toBe(0);
    });

    it('forbids plain users from creating statements', function (): void {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('violation-statements.store'), [
                'statement' => 'Blocked',
                'weight' => 5,
                'categories' => [ViolationStatementCategory::Osha->value],
            ])
            ->assertForbidden();
    });
});

describe('validation', function (): void {
    it('requires statement, weight, and categories', function (): void {
        asSuperAdmin()
            ->from(route('violation-statements.index'))
            ->post(route('violation-statements.store'), [])
            ->assertSessionHasErrors(['statement', 'weight', 'categories']);
    });

    it('rejects invalid category values', function (): void {
        asSuperAdmin()
            ->from(route('violation-statements.index'))
            ->post(route('violation-statements.store'), [
                'statement' => 'Test',
                'weight' => 5,
                'categories' => ['invalid-category'],
            ])
            ->assertSessionHasErrors('categories.0');
    });

    it('rejects weight outside 1-10 range', function (): void {
        asSuperAdmin()
            ->from(route('violation-statements.index'))
            ->post(route('violation-statements.store'), [
                'statement' => 'Test',
                'weight' => 11,
                'categories' => [ViolationStatementCategory::Osha->value],
            ])
            ->assertSessionHasErrors('weight');
    });
});

describe('creation', function (): void {
    it('stores a statement without an image', function (): void {
        asSuperAdmin()
            ->from(route('violation-statements.index'))
            ->post(route('violation-statements.store'), [
                'statement' => 'Unlabeled container',
                'weight' => 7,
                'categories' => [
                    ViolationStatementCategory::Osha->value,
                    ViolationStatementCategory::BodyShop->value,
                ],
                'keywords' => ['label', 'chemical'],
            ])
            ->assertRedirect(route('violation-statements.index'));

        $statement = ViolationStatement::query()->sole();

        expect($statement->statement)->toBe('Unlabeled container');
        expect($statement->weight)->toBe(7);
        expect($statement->categories->all())->toBe([
            ViolationStatementCategory::Osha,
            ViolationStatementCategory::BodyShop,
        ]);
        expect($statement->keywords)->toBe(['label', 'chemical']);
        expect($statement->reference_image_url)->toBeNull();
    });

    it('stores an uploaded image on the digitalocean disk', function (): void {
        $image = UploadedFile::fake()->image('reference.jpg');

        asSuperAdmin()
            ->from(route('violation-statements.index'))
            ->post(route('violation-statements.store'), [
                'statement' => 'With image',
                'weight' => 3,
                'categories' => [ViolationStatementCategory::Glba->value],
                'image' => $image,
            ])
            ->assertRedirect(route('violation-statements.index'));

        $statement = ViolationStatement::query()->sole();

        expect($statement->reference_image_url)->toContain('violation-statements/');
        Storage::disk('digitalocean')->assertExists('violation-statements/'.$image->hashName());
    });
});
