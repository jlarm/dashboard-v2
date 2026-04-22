<?php

declare(strict_types=1);

use App\Models\Sds;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('model_has_roles')->truncate();
    DB::table('users')->truncate();
    DB::table('sds')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    Storage::fake('sds-sheets');
});

describe('authorization', function (): void {
    it('forbids Consultants from uploading', function (): void {
        asConsultant()
            ->from(route('sds.index'))
            ->post(route('sds.store'), [
                'name' => 'Blocked',
                'file' => UploadedFile::fake()->create('blocked.pdf', 10, 'application/pdf'),
            ])
            ->assertForbidden();

        expect(Sds::query()->count())->toBe(0);
    });

    it('forbids plain users from uploading', function (): void {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('sds.store'), [
                'name' => 'Blocked',
                'file' => UploadedFile::fake()->create('blocked.pdf', 10, 'application/pdf'),
            ])
            ->assertForbidden();
    });
});

describe('validation', function (): void {
    it('requires a name', function (): void {
        asSuperAdmin()
            ->from(route('sds.index'))
            ->post(route('sds.store'), [
                'file' => UploadedFile::fake()->create('handbook.pdf', 10, 'application/pdf'),
            ])
            ->assertSessionHasErrors('name');
    });

    it('requires a file', function (): void {
        asSuperAdmin()
            ->from(route('sds.index'))
            ->post(route('sds.store'), [
                'name' => 'Acetone',
            ])
            ->assertSessionHasErrors('file');
    });

    it('rejects duplicate file names', function (): void {
        Sds::factory()->create(['file_name' => 'acetone.pdf']);

        asSuperAdmin()
            ->from(route('sds.index'))
            ->post(route('sds.store'), [
                'name' => 'Acetone 2',
                'file' => UploadedFile::fake()->create('acetone.pdf', 10, 'application/pdf'),
            ])
            ->assertSessionHasErrors('file');

        expect(Sds::query()->count())->toBe(1);
    });
});

describe('creation', function (): void {
    it('stores the sheet and uploads the pdf', function (): void {
        $file = UploadedFile::fake()->create('My Sheet.pdf', 50, 'application/pdf');

        asSuperAdmin()
            ->from(route('sds.index'))
            ->post(route('sds.store'), [
                'name' => 'Acetone',
                'manufacturer' => 'ChemCo',
                'keywords' => ['solvent', 'flammable'],
                'file' => $file,
            ])
            ->assertRedirect(route('sds.index'));

        $sds = Sds::query()->sole();

        expect($sds->name)->toBe('Acetone');
        expect($sds->manufacturer)->toBe('ChemCo');
        expect($sds->keywords)->toBe(['solvent', 'flammable']);
        expect($sds->file_name)->toBe('My-Sheet.pdf');
        Storage::disk('sds-sheets')->assertExists('My-Sheet.pdf');
    });
});
