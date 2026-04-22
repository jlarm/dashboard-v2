<?php

declare(strict_types=1);

use App\Models\Document;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('model_has_roles')->truncate();
    DB::table('users')->truncate();
    DB::table('documents')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    Storage::fake('central-docs');
});

it('streams the file to super-admin', function (): void {
    Storage::disk('central-docs')->put('handbook.pdf', 'contents');

    $document = Document::factory()->create(['url' => null, 'file_name' => 'handbook.pdf']);

    asSuperAdmin()
        ->get(route('documents.download', $document))
        ->assertOk();
});

it('streams the file to Consultants', function (): void {
    Storage::disk('central-docs')->put('handbook.pdf', 'contents');

    $document = Document::factory()->create(['url' => null, 'file_name' => 'handbook.pdf']);

    asConsultant()
        ->get(route('documents.download', $document))
        ->assertOk();
});

it('returns 404 when the document has no file_name', function (): void {
    $document = Document::factory()->create(['url' => 'https://example.com', 'file_name' => null]);

    asSuperAdmin()
        ->get(route('documents.download', $document))
        ->assertNotFound();
});
