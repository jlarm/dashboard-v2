<?php

declare(strict_types=1);

use App\Jobs\Contracts\GeneratePdfJob;
use App\Jobs\Contracts\UploadToDigitalOceanJob;
use App\Models\Contract;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('contract_statuses')->truncate();
    DB::table('contracts')->truncate();
    DB::table('model_has_roles')->truncate();
    DB::table('model_has_permissions')->truncate();
    DB::table('users')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

it('dispatches the PDF generation chain when ARMP has signed', function (): void {
    Bus::fake();

    $contract = Contract::factory()->create([
        'armp_signature' => 'armp/path.png',
        'pdf_path' => null,
    ]);

    asSuperAdmin()
        ->post(route('contracts.pdf.generate', $contract))
        ->assertRedirect();

    Bus::assertChained([
        GeneratePdfJob::class,
        UploadToDigitalOceanJob::class,
    ]);
});

it('forbids PDF generation before the ARMP signature exists', function (): void {
    Bus::fake();

    $owner = User::factory()->create();
    $owner->assignRole('Consultant');

    $contract = Contract::factory()->create([
        'user_id' => $owner->id,
        'armp_signature' => null,
    ]);

    $this->actingAs($owner)
        ->post(route('contracts.pdf.generate', $contract))
        ->assertForbidden();

    Bus::assertNothingDispatched();
});

it('downloads the PDF from the armpcon disk', function (): void {
    Storage::fake('armpcon');

    $contract = Contract::factory()->create([
        'armp_signature' => 'armp/path.png',
        'pdf_path' => 'pdfs/contract.pdf',
    ]);

    Storage::disk('armpcon')->put($contract->pdf_path, '%PDF-1.4 fake');

    asSuperAdmin()
        ->get(route('contracts.pdf.download', $contract))
        ->assertOk();
});

it('forbids downloading when no PDF has been generated', function (): void {
    $owner = User::factory()->create();
    $owner->assignRole('Consultant');

    $contract = Contract::factory()->create([
        'user_id' => $owner->id,
        'pdf_path' => null,
    ]);

    $this->actingAs($owner)
        ->get(route('contracts.pdf.download', $contract))
        ->assertForbidden();
});
