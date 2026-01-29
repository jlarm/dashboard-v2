<?php

declare(strict_types=1);

use App\Http\Livewire\Central\AuditStatements\Osha\Create;
use App\Http\Livewire\Central\AuditStatements\Osha\Edit;
use App\Http\Livewire\Central\AuditStatements\Osha\Index;
use App\Models\OshaViolationStatements;
use Database\Seeders\RoleAndPermissionSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RoleAndPermissionSeeder::class);
});

describe('OSHA Violation Statements Index', function () {
    it('displays violations with weight column', function () {
        $violation = OshaViolationStatements::create([
            'statement' => 'Test violation statement',
            'keywords' => json_encode(['safety', 'compliance']),
            'weight' => 5,
        ]);

        asSuperAdmin();

        Livewire::test(Index::class)
            ->assertSee('Test violation statement')
            ->assertSee('5');
    });

    it('truncates long violation statements', function () {
        $longStatement = str_repeat('A', 150);
        $violation = OshaViolationStatements::create([
            'statement' => $longStatement,
            'keywords' => json_encode([]),
            'weight' => 3,
        ]);

        asSuperAdmin();

        Livewire::test(Index::class)
            ->assertSee(mb_substr($longStatement, 0, 100).'...')
            ->assertDontSee($longStatement);
    });
});

describe('OSHA Violation Statements Create', function () {
    it('can create a violation statement with weight', function () {
        asSuperAdmin();

        Livewire::test(Create::class)
            ->set('statement', 'New OSHA violation')
            ->set('weight', 7)
            ->set('keywords', ['hazard', 'warning'])
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('osha_violation_statements', [
            'statement' => 'New OSHA violation',
            'weight' => 7,
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

describe('OSHA Violation Statements Edit', function () {
    it('loads existing violation data including weight', function () {
        $violation = OshaViolationStatements::create([
            'statement' => 'Existing OSHA violation',
            'keywords' => json_encode(['existing']),
            'weight' => 8,
        ]);

        asSuperAdmin();

        Livewire::test(Edit::class, ['oshaViolation' => $violation])
            ->assertSet('statement', 'Existing OSHA violation')
            ->assertSet('weight', 8);
    });

    it('can update violation statement with weight', function () {
        $violation = OshaViolationStatements::create([
            'statement' => 'Original statement',
            'keywords' => json_encode([]),
            'weight' => 3,
        ]);

        asSuperAdmin();

        Livewire::test(Edit::class, ['oshaViolation' => $violation])
            ->set('statement', 'Updated statement')
            ->set('weight', 9)
            ->call('update')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('osha_violation_statements', [
            'id' => $violation->id,
            'statement' => 'Updated statement',
            'weight' => 9,
        ]);
    });

    it('validates weight on update', function () {
        $violation = OshaViolationStatements::create([
            'statement' => 'Test statement',
            'keywords' => json_encode([]),
            'weight' => 5,
        ]);

        asSuperAdmin();

        Livewire::test(Edit::class, ['oshaViolation' => $violation])
            ->set('weight', 15)
            ->call('update')
            ->assertHasErrors(['weight']);
    });
});
