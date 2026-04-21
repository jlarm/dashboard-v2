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

it('forbids Consultants from deleting', function (): void {
    $document = SharedDocument::factory()->create();

    asConsultant()
        ->from(route('shared-documents.index'))
        ->delete(route('shared-documents.destroy', $document))
        ->assertForbidden();

    expect(SharedDocument::query()->count())->toBe(1);
});

it('super-admins can delete a link document', function (): void {
    $document = SharedDocument::factory()->create();

    asSuperAdmin()
        ->from(route('shared-documents.index'))
        ->delete(route('shared-documents.destroy', $document))
        ->assertRedirect(route('shared-documents.index'));

    expect(SharedDocument::query()->count())->toBe(0);
});

it('super-admins can delete a file document and the underlying file', function (): void {
    Storage::disk('central-docs')->put('shared-documents/handbook.pdf', 'contents');

    $document = SharedDocument::factory()->create([
        'url' => null,
        'file_name' => 'shared-documents/handbook.pdf',
    ]);

    asSuperAdmin()
        ->from(route('shared-documents.index'))
        ->delete(route('shared-documents.destroy', $document))
        ->assertRedirect(route('shared-documents.index'));

    expect(SharedDocument::query()->count())->toBe(0);
    Storage::disk('central-docs')->assertMissing('shared-documents/handbook.pdf');
});
