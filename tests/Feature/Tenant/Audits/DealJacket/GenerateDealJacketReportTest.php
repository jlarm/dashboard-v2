<?php

declare(strict_types=1);

use App\Http\Livewire\Tenant\Audit\DealJacket\GenerateReport;
use App\Jobs\Audit\GenerateDealJacketReportJob;
use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function (): void {
    $this->user = User::factory()->create();
    actingAs($this->user);
});

it('can mount the generate report modal with a deal jacket group', function (): void {
    $dealJacketGroup = DealJacketGroup::factory()->create(['completed' => true]);

    Livewire::test(GenerateReport::class, ['dealJacketGroupId' => $dealJacketGroup->id])
        ->assertSet('dealJacketGroup.id', $dealJacketGroup->id);
});

it('dispatches job when generating report for completed deal jacket group', function (): void {
    Queue::fake();

    $dealJacketGroup = DealJacketGroup::factory()->create(['completed' => true]);

    Livewire::test(GenerateReport::class, ['dealJacketGroupId' => $dealJacketGroup->id])
        ->call('generate')
        ->assertHasNoErrors();

    Queue::assertPushed(GenerateDealJacketReportJob::class);
});

it('shows error when trying to generate report for incomplete deal jacket group', function (): void {
    $dealJacketGroup = DealJacketGroup::factory()->create(['completed' => false]);

    Livewire::test(GenerateReport::class, ['dealJacketGroupId' => $dealJacketGroup->id])
        ->call('generate')
        ->assertHasErrors(['generation']);
});

it('can instantiate job with deal jacket group', function (): void {
    $dealJacketGroup = DealJacketGroup::factory()
        ->has(DealJacket::factory()->count(3), 'dealJackets')
        ->create(['completed' => true]);

    $job = new GenerateDealJacketReportJob($dealJacketGroup, $this->user);

    expect($job)->toBeInstanceOf(GenerateDealJacketReportJob::class);
});

it('renders House in report manager summary and manager detail sections', function (): void {
    $dealJacketGroup = DealJacketGroup::factory()->create(['completed' => true]);

    $html = view('dealer.audit.deal-jacket.pdf-report', [
        'dealJacketGroup' => $dealJacketGroup,
        'user' => $this->user,
        'issuesByUser' => ['House' => 2],
        'dealJacketDetails' => [[
            'customer_name' => 'Jane Doe',
            'customer_deal_number' => 'D-1001',
            'user_name' => 'House',
            'purchase_type' => 'finance',
            'vehicle_type' => 'used',
            'mileage' => '12000',
            'date_of_deal_jacket' => now(),
            'issues' => [[
                'statement' => 'Menu is not present.',
                'comment' => 'Missing',
            ]],
        ]],
        'dealJacketsByUser' => [
            'House' => [[
                'customer_name' => 'Jane Doe',
                'customer_deal_number' => 'D-1001',
                'user_name' => 'House',
                'issues' => [[
                    'statement' => 'Menu is not present.',
                    'comment' => 'Missing',
                ]],
            ]],
        ],
        'totalIssues' => 2,
        'issuesByStatementAndUser' => [
            'Menu is not present.' => ['House' => 2],
        ],
        'allUsers' => ['House'],
    ])->render();

    expect($html)
        ->toContain('Finance Manager')
        ->toContain('House')
        ->toContain('2 Issues Found');
});
