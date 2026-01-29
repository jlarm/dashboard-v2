<?php

declare(strict_types=1);

use App\Http\Livewire\Central\AuditStatements\BodyShop\Create;
use App\Http\Livewire\Central\AuditStatements\BodyShop\Edit;
use App\Http\Livewire\Central\AuditStatements\BodyShop\Index;
use App\Models\BodyShopViolationStatement;
use Database\Seeders\RoleAndPermissionSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RoleAndPermissionSeeder::class);
});

describe('Body Shop Violation Statements Index', function () {
    it('displays violations with weight column', function () {
        $violation = BodyShopViolationStatement::create([
            'statement' => 'Test body shop violation',
            'keywords' => json_encode(['paint', 'safety']),
            'weight' => 4,
        ]);

        asSuperAdmin();

        Livewire::test(Index::class)
            ->assertSee('Test body shop violation')
            ->assertSee('4');
    });

    it('truncates long violation statements', function () {
        $longStatement = str_repeat('B', 150);
        $violation = BodyShopViolationStatement::create([
            'statement' => $longStatement,
            'keywords' => json_encode([]),
            'weight' => 2,
        ]);

        asSuperAdmin();

        Livewire::test(Index::class)
            ->assertSee(mb_substr($longStatement, 0, 100).'...')
            ->assertDontSee($longStatement);
    });
});

describe('Body Shop Violation Statements Create', function () {
    it('can create a violation statement with weight', function () {
        asSuperAdmin();

        Livewire::test(Create::class)
            ->set('statement', 'New body shop violation')
            ->set('weight', 6)
            ->set('keywords', ['equipment', 'ventilation'])
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('body_shop_violation_statements', [
            'statement' => 'New body shop violation',
            'weight' => 6,
        ]);
    });

    it('validates weight is between 1 and 10', function () {
        asSuperAdmin();

        Livewire::test(Create::class)
            ->set('statement', 'Test violation')
            ->set('weight', 11)
            ->call('create')
            ->assertHasErrors(['weight']);

        Livewire::test(Create::class)
            ->set('statement', 'Test violation')
            ->set('weight', 0)
            ->call('create')
            ->assertHasErrors(['weight']);
    });

    it('defaults weight to 1', function () {
        asSuperAdmin();

        Livewire::test(Create::class)
            ->assertSet('weight', 1);
    });
});

describe('Body Shop Violation Statements Edit', function () {
    it('loads existing violation data including weight', function () {
        $violation = BodyShopViolationStatement::create([
            'statement' => 'Existing body shop violation',
            'keywords' => json_encode(['existing']),
            'weight' => 7,
        ]);

        asSuperAdmin();

        Livewire::test(Edit::class, ['bodyShopViolation' => $violation])
            ->assertSet('statement', 'Existing body shop violation')
            ->assertSet('weight', 7);
    });

    it('can update violation statement with weight', function () {
        $violation = BodyShopViolationStatement::create([
            'statement' => 'Original statement',
            'keywords' => json_encode([]),
            'weight' => 4,
        ]);

        asSuperAdmin();

        Livewire::test(Edit::class, ['bodyShopViolation' => $violation])
            ->set('statement', 'Updated statement')
            ->set('weight', 10)
            ->call('update')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('body_shop_violation_statements', [
            'id' => $violation->id,
            'statement' => 'Updated statement',
            'weight' => 10,
        ]);
    });

    it('validates weight on update', function () {
        $violation = BodyShopViolationStatement::create([
            'statement' => 'Test statement',
            'keywords' => json_encode([]),
            'weight' => 5,
        ]);

        asSuperAdmin();

        Livewire::test(Edit::class, ['bodyShopViolation' => $violation])
            ->set('weight', 15)
            ->call('update')
            ->assertHasErrors(['weight']);
    });
});
