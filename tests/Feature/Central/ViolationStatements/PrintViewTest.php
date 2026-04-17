<?php

declare(strict_types=1);

use App\Enums\ViolationStatementCategory;
use App\Http\Livewire\Central\ViolationStatements\PrintView;
use App\Models\ViolationStatement;
use Livewire\Livewire;

it('renders all violation statements with statement, weight, categories, and keywords', function (): void {
    ViolationStatement::factory()->create([
        'statement' => 'Failure to post required OSHA notices',
        'weight' => 7,
        'categories' => [ViolationStatementCategory::Osha->value],
        'keywords' => ['notices', 'posting'],
    ]);

    ViolationStatement::factory()->create([
        'statement' => 'Missing GLBA privacy notice',
        'weight' => 5,
        'categories' => [ViolationStatementCategory::Glba->value],
        'keywords' => ['privacy'],
    ]);

    Livewire::test(PrintView::class)
        ->assertSee('Failure to post required OSHA notices')
        ->assertSee('Missing GLBA privacy notice')
        ->assertSee('Weight: 7')
        ->assertSee('Weight: 5')
        ->assertSee('OSHA')
        ->assertSee('GLBA')
        ->assertSee('notices')
        ->assertSee('privacy');
});

it('renders statements in alphabetical order', function (): void {
    ViolationStatement::factory()->create(['statement' => 'Zebra violation statement here']);
    ViolationStatement::factory()->create(['statement' => 'Alpha violation statement here']);

    $view = Livewire::test(PrintView::class);

    $view->assertSee('Zebra violation statement here')
        ->assertSee('Alpha violation statement here');

    $rendered = $view->lastRenderedDom ?? $view->payload['effects']['html'] ?? '';
    expect(mb_strpos((string) $rendered, 'Alpha violation'))->toBeLessThan(mb_strpos((string) $rendered, 'Zebra violation'));
});
