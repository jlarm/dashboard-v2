<?php

declare(strict_types=1);

use App\Enums\ViolationStatementCategory;
use App\Http\Livewire\Dealer\Audit\BodyShop\Modal;
use App\Models\ViolationStatement;
use Livewire\Livewire;

it('emits violationSelected with id and statement when selectViolation is called', function (): void {
    $violation = tenancy()->central(fn () => ViolationStatement::factory()->create([
        'statement' => 'Welding area lacks proper ventilation',
        'categories' => [ViolationStatementCategory::BodyShop->value],
    ]));

    Livewire::test(Modal::class)
        ->call('selectViolation', $violation->id)
        ->assertDispatched('violationSelected', ['id' => $violation->id, 'statement' => $violation->statement]);
});

it('does not throw when the violation id exists as a ViolationStatement (not BodyShopViolationStatement)', function (): void {
    $violation = tenancy()->central(fn () => ViolationStatement::factory()->create([
        'categories' => [ViolationStatementCategory::BodyShop->value],
    ]));

    // If the bug were present this would throw "Call to a member function only() on null"
    Livewire::test(Modal::class)
        ->call('selectViolation', $violation->id)
        ->assertDispatched('violationSelected');
});
