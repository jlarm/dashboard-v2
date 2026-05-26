<?php

declare(strict_types=1);

use App\Jobs\GenerateIndividualAuditPdfJob;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $this->store->id]);
});

describe('authorization', function (): void {
    it('redirects guests to login from the index', function (): void {
        tenancy()->end();
        $this->tenant->run(function (): void {
            $this->get(route('dealer.audit.individual.index'))
                ->assertRedirect(route('dealer.login'));
        });
    });

    it('forbids non-privileged users from the index', function (): void {
        $this->manager->update(['current_store_id' => $this->store->id]);

        $this->actingAs($this->manager)
            ->get(route('dealer.audit.individual.index'))
            ->assertOk(); // Manager IS in the read group; sanity-check the path renders.

        $employee = App\Models\User::query()->create([
            'name' => 'Bystander',
            'email' => 'bystander@test-tenant.localhost',
            'password' => bcrypt('password'),
        ]);
        $employee->assignRole('Employee');

        $this->actingAs($employee)
            ->get(route('dealer.audit.individual.index'))
            ->assertForbidden();
    });
});

it('renders the individual audits index for the current store', function (): void {
    IndividualAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'audit_date' => now()->subDay()->toDateString(),
        'deal_jacket_date' => now()->subDay()->toDateString(),
        'draft' => false,
    ]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.audit.individual.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('tenant/audits/individual/Index')
            ->where('store.id', $this->store->id)
            ->has('audits', 1)
        );
});

it('creates a draft child audit nested under a parent and redirects to its edit screen', function (): void {
    $parent = IndividualAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'audit_date' => now()->subDays(2)->toDateString(),
        'deal_jacket_date' => now()->subDays(2)->toDateString(),
        'draft' => false,
    ]);

    $this->actingAs($this->consultant)
        ->post(route('dealer.audit.individual.create-child', $parent->uuid))
        ->assertRedirect();

    $child = IndividualAudit::query()->where('parent_id', $parent->id)->sole();
    expect($child->draft)->toBeTrue()
        ->and($child->store_id)->toBe($this->store->id);
});

it('redirects back to the parent after deleting a child audit', function (): void {
    $parent = IndividualAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'audit_date' => now()->subDays(3)->toDateString(),
        'deal_jacket_date' => now()->subDays(3)->toDateString(),
        'draft' => false,
    ]);
    $child = IndividualAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'parent_id' => $parent->id,
        'audit_date' => now()->subDays(2)->toDateString(),
        'deal_jacket_date' => now()->subDays(2)->toDateString(),
        'draft' => false,
    ]);

    $this->actingAs($this->consultant)
        ->delete(route('dealer.audit.individual.destroy', $child->uuid))
        ->assertRedirect(route('dealer.audit.individual.show', $parent->uuid));

    expect(IndividualAudit::query()->find($child->id))->toBeNull();
});

it('redirects to index after deleting a parent audit', function (): void {
    $parent = IndividualAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'audit_date' => now()->subDays(3)->toDateString(),
        'deal_jacket_date' => now()->subDays(3)->toDateString(),
        'draft' => false,
    ]);

    $this->actingAs($this->consultant)
        ->delete(route('dealer.audit.individual.destroy', $parent->uuid))
        ->assertRedirect(route('dealer.audit.individual.index'));
});

it('dispatches the pdf generation job from the generate endpoint', function (): void {
    Queue::fake();

    $audit = IndividualAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'audit_date' => now()->subDay()->toDateString(),
        'deal_jacket_date' => now()->subDay()->toDateString(),
        'draft' => false,
    ]);

    $this->actingAs($this->consultant)
        ->post(route('dealer.audit.individual.generate', $audit->uuid))
        ->assertRedirect();

    Queue::assertPushed(GenerateIndividualAuditPdfJob::class);
});

it('returns 404 download when the pdf has not been generated', function (): void {
    $audit = IndividualAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'audit_date' => now()->subDay()->toDateString(),
        'deal_jacket_date' => now()->subDay()->toDateString(),
        'draft' => false,
        'pdf_path' => null,
    ]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.audit.individual.download', $audit->uuid))
        ->assertNotFound();
});

it('redirects download to the do-audits temporary url when pdf_path is set', function (): void {
    Illuminate\Support\Facades\Storage::fake('do-audits');

    $audit = IndividualAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'audit_date' => now()->subDay()->toDateString(),
        'deal_jacket_date' => now()->subDay()->toDateString(),
        'draft' => false,
        'pdf_path' => 'report.pdf',
    ]);

    $response = $this->actingAs($this->consultant)
        ->get(route('dealer.audit.individual.download', $audit->uuid));

    $response->assertRedirect();
    expect($response->headers->get('Location'))
        ->toContain(tenant('id').'/individual-audits/report.pdf');
});
