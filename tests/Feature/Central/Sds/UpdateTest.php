<?php

declare(strict_types=1);

use App\Models\Sds;
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

it('forbids Consultants from updating', function (): void {
    $sds = Sds::factory()->create();

    asConsultant()
        ->from(route('sds.index'))
        ->patch(route('sds.update', $sds), ['name' => 'Updated'])
        ->assertForbidden();
});

it('updates name, manufacturer, and keywords without touching the file', function (): void {
    Storage::disk('sds-sheets')->put('original.pdf', 'contents');

    $sds = Sds::factory()->create([
        'name' => 'Original',
        'manufacturer' => 'Old',
        'keywords' => ['old'],
        'file_name' => 'original.pdf',
    ]);

    asSuperAdmin()
        ->from(route('sds.index'))
        ->patch(route('sds.update', $sds), [
            'name' => 'Updated',
            'manufacturer' => 'New',
            'keywords' => ['fresh', 'keyword'],
        ])
        ->assertRedirect(route('sds.index'));

    $sds->refresh();

    expect($sds->name)->toBe('Updated');
    expect($sds->manufacturer)->toBe('New');
    expect($sds->keywords)->toBe(['fresh', 'keyword']);
    expect($sds->file_name)->toBe('original.pdf');
    Storage::disk('sds-sheets')->assertExists('original.pdf');
});

it('replaces the pdf when a new file is uploaded', function (): void {
    Storage::disk('sds-sheets')->put('original.pdf', 'contents');

    $sds = Sds::factory()->create([
        'name' => 'Original',
        'file_name' => 'original.pdf',
    ]);

    asSuperAdmin()
        ->from(route('sds.index'))
        ->patch(route('sds.update', $sds), [
            'name' => 'Original',
            'file' => UploadedFile::fake()->create('replacement.pdf', 20, 'application/pdf'),
        ])
        ->assertRedirect(route('sds.index'));

    $sds->refresh();

    expect($sds->file_name)->toBe('replacement.pdf');
    Storage::disk('sds-sheets')->assertMissing('original.pdf');
    Storage::disk('sds-sheets')->assertExists('replacement.pdf');
});

it('rejects a replacement file name already used by another sheet', function (): void {
    Sds::factory()->create(['file_name' => 'shared.pdf']);
    $sds = Sds::factory()->create(['file_name' => 'mine.pdf']);

    asSuperAdmin()
        ->from(route('sds.index'))
        ->patch(route('sds.update', $sds), [
            'name' => 'Mine',
            'file' => UploadedFile::fake()->create('shared.pdf', 10, 'application/pdf'),
        ])
        ->assertSessionHasErrors('file');

    expect($sds->refresh()->file_name)->toBe('mine.pdf');
});
