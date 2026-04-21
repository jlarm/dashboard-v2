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

it('forbids Consultants from deleting', function (): void {
    $document = Document::factory()->create();

    asConsultant()
        ->from(route('documents.index'))
        ->delete(route('documents.destroy', $document))
        ->assertForbidden();

    expect(Document::query()->count())->toBe(1);
});

it('super-admins can delete a link document', function (): void {
    $document = Document::factory()->create();

    asSuperAdmin()
        ->from(route('documents.index'))
        ->delete(route('documents.destroy', $document))
        ->assertRedirect(route('documents.index'));

    expect(Document::query()->count())->toBe(0);
});

it('super-admins can delete a file document and the underlying file', function (): void {
    Storage::disk('central-docs')->put('handbook.pdf', 'contents');

    $document = Document::factory()->create([
        'url' => null,
        'file_name' => 'handbook.pdf',
    ]);

    asSuperAdmin()
        ->from(route('documents.index'))
        ->delete(route('documents.destroy', $document))
        ->assertRedirect(route('documents.index'));

    expect(Document::query()->count())->toBe(0);
    Storage::disk('central-docs')->assertMissing('handbook.pdf');
});
