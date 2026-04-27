<?php

declare(strict_types=1);

use App\Mail\Tenant\SdsRequestMail;
use App\Models\Sds;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    Storage::fake('sds-sheets');
    Mail::fake();

    $this->employee = User::factory()->create();
    $this->employee->assignRole('Employee');

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

describe('SDS index', function (): void {
    it('renders the inertia page with no records when search is empty', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.sds.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/sds/Index')
                ->where('records', null)
                ->where('filters.search', null));
    });

    it('returns matching SDS records when searching', function (): void {
        tenancy()->central(function (): void {
            Sds::query()->create([
                'name' => 'Brake Cleaner',
                'manufacturer' => 'Acme',
                'keywords' => ['brake', 'cleaner'],
                'file_name' => 'brake-cleaner.pdf',
            ]);

            Sds::query()->create([
                'name' => 'Oil Treatment',
                'manufacturer' => 'Globex',
                'keywords' => ['oil'],
                'file_name' => 'oil-treatment.pdf',
            ]);
        });

        $this->actingAs($this->employee)
            ->get(route('dealer.sds.index', ['search' => 'brake']))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/sds/Index')
                ->has('records.data', 1)
                ->where('records.data.0.name', 'Brake Cleaner')
                ->where('filters.search', 'brake'));
    });

    it('rejects unsupported sort fields', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.sds.index', ['search' => 'foo', 'sort' => 'evil']))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->where('filters.sort', 'name'));
    });
});

describe('SDS view', function (): void {
    it('streams the PDF inline with cache headers', function (): void {
        [$uuid] = tenancy()->central(function (): array {
            Storage::disk('sds-sheets')->put('sds-test.pdf', 'pdf-bytes');

            $sds = Sds::query()->create([
                'name' => 'Test Sheet',
                'manufacturer' => 'Acme',
                'keywords' => [],
                'file_name' => 'sds-test.pdf',
            ]);

            return [$sds->uuid];
        });

        $response = $this->actingAs($this->employee)
            ->get(route('dealer.sds.view', ['uuid' => $uuid]))
            ->assertOk();

        expect($response->headers->get('Content-Type'))->toBe('application/pdf')
            ->and($response->headers->get('Cache-Control'))->toContain('max-age=31536000');
    });
});

describe('SDS request', function (): void {
    it('queues a request email to super-admins', function (): void {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super-admin');

        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->actingAs($this->employee)
            ->post(route('dealer.sds.request'), [
                'name' => 'Mystery Solvent',
                'manufacturer' => 'Acme',
            ])
            ->assertRedirect()
            ->assertSessionHas('flash.success');

        Mail::assertQueued(
            SdsRequestMail::class,
            fn (SdsRequestMail $mail): bool => $mail->chemicalName === 'Mystery Solvent'
                && $mail->manufacturer === 'Acme'
                && $mail->hasTo($superAdmin->email),
        );
    });

    it('validates the chemical name is required', function (): void {
        $this->actingAs($this->employee)
            ->post(route('dealer.sds.request'), ['name' => ''])
            ->assertSessionHasErrors('name');

        Mail::assertNothingQueued();
    });
});
