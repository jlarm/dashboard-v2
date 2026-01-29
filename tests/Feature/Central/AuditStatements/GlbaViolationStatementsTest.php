<?php

declare(strict_types=1);

use App\Http\Livewire\Central\AuditStatements\Glba\Create;
use App\Http\Livewire\Central\AuditStatements\Glba\Edit;
use App\Http\Livewire\Central\AuditStatements\Glba\Index;
use App\Models\GlbaViolationStatements;
use Database\Seeders\RoleAndPermissionSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RoleAndPermissionSeeder::class);
});

describe('GLBA Violation Statements Index', function () {
    it('displays violations with weight column', function () {
        $violation = GlbaViolationStatements::create([
            'statement' => 'Test GLBA violation',
            'keywords' => json_encode(['privacy', 'data']),
            'weight' => 6,
        ]);

        asSuperAdmin();

        Livewire::test(Index::class)
            ->assertSee('Test GLBA violation')
            ->assertSee('6');
    });

    it('truncates long violation statements', function () {
        $longStatement = str_repeat('C', 150);
        $violation = GlbaViolationStatements::create([
            'statement' => $longStatement,
            'keywords' => json_encode([]),
            'weight' => 1,
        ]);

        asSuperAdmin();

        Livewire::test(Index::class)
            ->assertSee(mb_substr($longStatement, 0, 100).'...')
            ->assertDontSee($longStatement);
    });
});

describe('GLBA Violation Statements Create', function () {
    it('can create a violation statement with weight', function () {
        asSuperAdmin();

        Livewire::test(Create::class)
            ->set('statement', 'New GLBA violation')
            ->set('weight', 8)
            ->set('keywords', ['disclosure', 'consent'])
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('glba_violation_statements', [
            'statement' => 'New GLBA violation',
            'weight' => 8,
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

describe('GLBA Violation Statements Edit', function () {
    it('loads existing violation data including weight', function () {
        $violation = GlbaViolationStatements::create([
            'statement' => 'Existing GLBA violation',
            'keywords' => json_encode(['existing']),
            'weight' => 9,
        ]);

        asSuperAdmin();

        Livewire::test(Edit::class, ['glbaViolation' => $violation])
            ->assertSet('statement', 'Existing GLBA violation')
            ->assertSet('weight', 9);
    });

    it('can update violation statement with weight', function () {
        $violation = GlbaViolationStatements::create([
            'statement' => 'Original statement',
            'keywords' => json_encode([]),
            'weight' => 2,
        ]);

        asSuperAdmin();

        Livewire::test(Edit::class, ['glbaViolation' => $violation])
            ->set('statement', 'Updated statement')
            ->set('weight', 5)
            ->call('update')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('glba_violation_statements', [
            'id' => $violation->id,
            'statement' => 'Updated statement',
            'weight' => 5,
        ]);
    });

    it('validates weight on update', function () {
        $violation = GlbaViolationStatements::create([
            'statement' => 'Test statement',
            'keywords' => json_encode([]),
            'weight' => 5,
        ]);

        asSuperAdmin();

        Livewire::test(Edit::class, ['glbaViolation' => $violation])
            ->set('weight', 15)
            ->call('update')
            ->assertHasErrors(['weight']);
    });
});
