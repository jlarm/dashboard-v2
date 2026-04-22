<?php

declare(strict_types=1);

use App\Models\SharedDocument;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('model_has_roles')->truncate();
    DB::table('users')->truncate();
    DB::table('shared_documents')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    Storage::fake('central-docs');
});

it('streams the shared document to super-admin', function (): void {
    Storage::disk('central-docs')->put('shared-documents/handbook.pdf', 'contents');

    $document = SharedDocument::factory()->create([
        'url' => null,
        'file_name' => 'shared-documents/handbook.pdf',
    ]);

    asSuperAdmin()
        ->get(route('shared-documents.download', $document))
        ->assertOk();
});

it('streams the shared document to Consultants', function (): void {
    Storage::disk('central-docs')->put('shared-documents/handbook.pdf', 'contents');

    $document = SharedDocument::factory()->create([
        'url' => null,
        'file_name' => 'shared-documents/handbook.pdf',
    ]);

    asConsultant()
        ->get(route('shared-documents.download', $document))
        ->assertOk();
});

it('returns 404 when no file_name is set', function (): void {
    $document = SharedDocument::factory()->create(['url' => 'https://example.com', 'file_name' => null]);

    asSuperAdmin()
        ->get(route('shared-documents.download', $document))
        ->assertNotFound();
});
