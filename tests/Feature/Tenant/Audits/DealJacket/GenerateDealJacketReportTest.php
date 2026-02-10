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
