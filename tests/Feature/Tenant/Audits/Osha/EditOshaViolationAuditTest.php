<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Audit\Osha\Edit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use App\Models\Dealer\Violation;
use App\Models\ViolationStatement;
use Illuminate\Support\Str;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();
    $this->actingAs($this->consultant);

    $this->audit = OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-04-13',
    ]);
});

it('does not render the reference image toggle for violations without a reference image', function (): void {
    $statement = tenancy()->central(fn () => ViolationStatement::factory()->create([
        'reference_image_url' => null,
    ]));

    $this->audit->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => $statement->id,
        'statement' => $statement->statement,
        'comment' => 'Missing PPE observed.',
    ]);

    Livewire::test(Edit::class, ['oshaViolationAudit' => $this->audit])
        ->assertDontSee('Include reference image in report');
});

it('renders the reference image toggle for violations with a reference image', function (): void {
    $statement = tenancy()->central(fn () => ViolationStatement::factory()->create([
        'reference_image_url' => 'https://cdn.example.com/reference.jpg',
    ]));

    $this->audit->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => $statement->id,
        'statement' => $statement->statement,
        'comment' => 'Eye wash station obstructed.',
    ]);

    Livewire::test(Edit::class, ['oshaViolationAudit' => $this->audit])
        ->assertSee('Include reference image in report');
});

it('saves show_reference_image as true when toggled on', function (): void {
    $statement = tenancy()->central(fn () => ViolationStatement::factory()->create([
        'reference_image_url' => 'https://cdn.example.com/reference.jpg',
    ]));

    $violation = $this->audit->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => $statement->id,
        'statement' => $statement->statement,
        'comment' => 'Exit sign missing.',
        'risk' => false,
        'severity' => 3,
        'show_reference_image' => false,
    ]);

    Livewire::test(Edit::class, ['oshaViolationAudit' => $this->audit])
        ->set('violations.0.show_reference_image', true)
        ->call('edit')
        ->assertHasNoErrors();

    expect(Violation::query()->find($violation->id)->show_reference_image)->toBeTrue();
});

it('saves show_reference_image as false when toggled off', function (): void {
    $statement = tenancy()->central(fn () => ViolationStatement::factory()->create([
        'reference_image_url' => 'https://cdn.example.com/reference.jpg',
    ]));

    $violation = $this->audit->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => $statement->id,
        'statement' => $statement->statement,
        'comment' => 'Exit sign missing.',
        'risk' => false,
        'severity' => 2,
        'show_reference_image' => true,
    ]);

    Livewire::test(Edit::class, ['oshaViolationAudit' => $this->audit])
        ->set('violations.0.show_reference_image', false)
        ->call('edit')
        ->assertHasNoErrors();

    expect(Violation::query()->find($violation->id)->show_reference_image)->toBeFalse();
});

it('defaults show_reference_image to false for violations without a reference image statement', function (): void {
    $statement = tenancy()->central(fn () => ViolationStatement::factory()->create([
        'reference_image_url' => null,
    ]));

    $violation = $this->audit->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => $statement->id,
        'statement' => $statement->statement,
        'comment' => 'Aisle blocked.',
        'risk' => false,
        'severity' => 1,
    ]);

    Livewire::test(Edit::class, ['oshaViolationAudit' => $this->audit])
        ->call('edit')
        ->assertHasNoErrors();

    expect(Violation::query()->find($violation->id)->show_reference_image)->toBeFalse();
});
