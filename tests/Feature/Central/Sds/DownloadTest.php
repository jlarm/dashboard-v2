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

it('downloads the sheet for super-admin', function (): void {
    Storage::disk('sds-sheets')->put('sheet.pdf', 'contents');

    $sds = Sds::factory()->create(['name' => 'Acetone', 'file_name' => 'sheet.pdf']);

    asSuperAdmin()
        ->get(route('sds.download', $sds))
        ->assertOk();
});

it('downloads the sheet for Consultants', function (): void {
    Storage::disk('sds-sheets')->put('sheet.pdf', 'contents');

    $sds = Sds::factory()->create(['name' => 'Acetone', 'file_name' => 'sheet.pdf']);

    asConsultant()
        ->get(route('sds.download', $sds))
        ->assertOk();
});

it('returns 404 when the sheet has an empty file_name', function (): void {
    $sds = Sds::factory()->create(['file_name' => 'tmp.pdf']);

    DB::table('sds')->where('id', $sds->id)->update(['file_name' => '']);

    asSuperAdmin()
        ->get(route('sds.download', $sds))
        ->assertNotFound();
});
