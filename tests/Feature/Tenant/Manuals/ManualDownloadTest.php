<?php

declare(strict_types=1);

use App\Models\CmsManual;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake('do-manuals');
    $this->store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $this->store->id]);
});

dataset('manual_download_routes', [
    'cms' => [
        CmsManual::class,
        'dealer.manual.cms.download',
        'cms',
        [
            'qi_name' => 'QI',
            'standard_dpp_rate' => 1.0,
            'adoption_approval_name_one' => 'A',
            'adoption_approval_signature_one' => '',
            'adoption_approval_name_two' => '',
            'adoption_approval_signature_two' => '',
            'adoption_approval_name_three' => '',
            'adoption_approval_signature_three' => '',
            'dealer_participation_program_name' => 'D',
            'dealer_participation_program_signature' => '',
            'acknowledgement_name' => 'Ack',
            'acknowledgement_signature' => '',
        ],
    ],
    'isp' => [
        Isp::class,
        'dealer.manual.isp.download',
        'isp',
        ['qualified_individual_name' => 'QI', 'qualified_individual_phone' => '555'],
    ],
    'osha' => [
        Osha::class,
        'dealer.manual.osha.download',
        'osha',
        ['qualified_individual_name' => 'QI', 'qualified_individual_phone' => '555'],
    ],
    'red-flag' => [
        RedFlag::class,
        'dealer.manual.red-flag.download',
        'red-flags',
        ['qualified_individual_name' => 'QI', 'qualified_individual_phone' => '555'],
    ],
]);

it('streams the pdf from do-manuals through the app domain', function (
    string $modelClass,
    string $routeName,
    string $diskPrefix,
    array $attrs,
): void {
    $pdfName = 'manual-'.uniqid().'.pdf';
    $manual = $modelClass::query()->create([
        'store_id' => $this->store->id,
        'user_id' => $this->consultant->id,
        'pdf_path' => $pdfName,
        ...$attrs,
    ]);

    Storage::disk('do-manuals')->put(tenant('id').'/'.$diskPrefix.'/'.$pdfName, 'pdf-bytes');

    $this->actingAs($this->consultant)
        ->get(route($routeName, $manual))
        ->assertOk()
        ->assertHeader('Content-Type', 'application/pdf');
})->with('manual_download_routes');

it('returns 404 when the manual has no pdf_path set', function (
    string $modelClass,
    string $routeName,
    string $diskPrefix,
    array $attrs,
): void {
    $manual = $modelClass::query()->create([
        'store_id' => $this->store->id,
        'user_id' => $this->consultant->id,
        'pdf_path' => null,
        ...$attrs,
    ]);

    $this->actingAs($this->consultant)
        ->get(route($routeName, $manual))
        ->assertNotFound();
})->with('manual_download_routes');

it('returns 404 when the manual belongs to a store the user cannot scope to', function (
    string $modelClass,
    string $routeName,
    string $diskPrefix,
    array $attrs,
): void {
    $otherStore = Store::query()->create(['name' => 'Other', 'slug' => 'other-'.uniqid()]);
    $manual = $modelClass::query()->create([
        'store_id' => $otherStore->id,
        'user_id' => $this->consultant->id,
        'pdf_path' => 'whatever.pdf',
        ...$attrs,
    ]);

    Storage::disk('do-manuals')->put(tenant('id').'/'.$diskPrefix.'/whatever.pdf', 'pdf-bytes');

    // Owner has the right role to hit the manual routes but is only attached
    // to the original store, so the manual on $otherStore should 404 via
    // authorizeManualScope rather than be exposed.
    $owner = App\Models\User::query()->create([
        'name' => 'Scoped Owner',
        'email' => 'scoped-owner-'.uniqid().'@test-tenant.localhost',
        'password' => bcrypt('password'),
    ]);
    $owner->assignRole('Owner');
    $owner->stores()->sync([$this->store->id]);
    $owner->update(['current_store_id' => $this->store->id]);
    app()->make(Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

    $this->actingAs($owner)
        ->get(route($routeName, $manual))
        ->assertNotFound();
})->with('manual_download_routes');
