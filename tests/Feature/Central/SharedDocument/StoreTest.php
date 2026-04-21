<?php

declare(strict_types=1);

use App\Models\SharedDocument;
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
    DB::table('shared_documents')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    Storage::fake('central-docs');
});

describe('authorization', function (): void {
    it('forbids Consultants from uploading', function (): void {
        asConsultant()
            ->from(route('shared-documents.index'))
            ->post(route('shared-documents.store'), [
                'title' => 'Blocked',
                'url' => 'https://example.com',
            ])
            ->assertForbidden();

        expect(SharedDocument::query()->count())->toBe(0);
    });

    it('forbids plain users from uploading', function (): void {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('shared-documents.store'), [
                'title' => 'Blocked',
                'url' => 'https://example.com',
            ])
            ->assertForbidden();
    });
});

describe('validation', function (): void {
    it('requires a title', function (): void {
        asSuperAdmin()
            ->from(route('shared-documents.index'))
            ->post(route('shared-documents.store'), [
                'url' => 'https://example.com',
            ])
            ->assertSessionHasErrors('title');
    });

    it('requires either a url or a file', function (): void {
        asSuperAdmin()
            ->from(route('shared-documents.index'))
            ->post(route('shared-documents.store'), [
                'title' => 'Missing source',
            ])
            ->assertSessionHasErrors('file');
    });
});

describe('creation', function (): void {
    it('stores a link-only document', function (): void {
        asSuperAdmin()
            ->from(route('shared-documents.index'))
            ->post(route('shared-documents.store'), [
                'title' => 'Onboarding',
                'url' => 'https://example.com/doc',
            ])
            ->assertRedirect(route('shared-documents.index'));

        $document = SharedDocument::query()->sole();

        expect($document->title)->toBe('Onboarding');
        expect($document->url)->toBe('https://example.com/doc');
        expect($document->file_name)->toBeNull();
    });

    it('stores an uploaded file on the central-docs disk', function (): void {
        $file = UploadedFile::fake()->create('handbook.pdf', 50, 'application/pdf');

        asSuperAdmin()
            ->from(route('shared-documents.index'))
            ->post(route('shared-documents.store'), [
                'title' => 'Handbook',
                'file' => $file,
            ])
            ->assertRedirect(route('shared-documents.index'));

        $document = SharedDocument::query()->sole();

        expect($document->file_name)->toBe('shared-documents/handbook.pdf');
        Storage::disk('central-docs')->assertExists('shared-documents/handbook.pdf');
    });
});
