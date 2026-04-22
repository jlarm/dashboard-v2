<?php

declare(strict_types=1);

use App\Models\Sds;
use Database\Seeders\RoleAndPermissionSeeder;
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

it('forbids Consultants from deleting', function (): void {
    $sds = Sds::factory()->create();

    asConsultant()
        ->from(route('sds.index'))
        ->delete(route('sds.destroy', $sds))
        ->assertForbidden();

    expect(Sds::query()->count())->toBe(1);
});

it('super-admins can delete a sheet and its file', function (): void {
    Storage::disk('sds-sheets')->put('sheet.pdf', 'contents');

    $sds = Sds::factory()->create(['file_name' => 'sheet.pdf']);

    asSuperAdmin()
        ->from(route('sds.index'))
        ->delete(route('sds.destroy', $sds))
        ->assertRedirect(route('sds.index'));

    expect(Sds::query()->count())->toBe(0);
    Storage::disk('sds-sheets')->assertMissing('sheet.pdf');
});
