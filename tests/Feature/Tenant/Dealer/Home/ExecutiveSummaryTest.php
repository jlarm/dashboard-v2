<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Home\ExecutiveSummary;
use App\Models\Dealer\Store;
use App\Services\ComplianceSummaryPdfService;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\File;
use Livewire\Livewire;

use function Pest\Laravel\mock;

describe('ExecutiveSummary', function (): void {

    beforeEach(function (): void {
        $this->pdfPath = storage_path('app/compliance-summary/test-'.uniqid().'.pdf');

        if (! File::isDirectory(dirname($this->pdfPath))) {
            File::makeDirectory(dirname($this->pdfPath), 0777, true, true);
        }

        File::put($this->pdfPath, '%PDF-1.4 stub');

        $this->store = Store::query()->where('slug', 'test-store')->firstOrFail();

        app()->instance('currentStore', $this->store->id);
        app()->instance('currentStoreModel', $this->store);
    });

    afterEach(function (): void {
        File::delete($this->pdfPath);
    });

    it('forbids roles that are not authorized to download the executive summary', function (): void {
        $this->consultant->syncRoles('Manager');
        $this->consultant->stores()->sync([$this->store->id]);

        Livewire::actingAs($this->consultant)
            ->test(ExecutiveSummary::class)
            ->call('download')
            ->assertForbidden();
    });

    it('forbids an unauthenticated user from downloading', function (): void {
        Livewire::test(ExecutiveSummary::class)
            ->call('download')
            ->assertForbidden();
    });

    it('allows authorized roles with access to the store to download', function (string $role): void {
        $this->consultant->syncRoles($role);
        $this->consultant->stores()->sync([$this->store->id]);

        mock(ComplianceSummaryPdfService::class)
            ->shouldReceive('generate')
            ->once()
            ->withArgs(fn (EloquentCollection $stores): bool => $stores->count() === 1 && $stores->first()->id === $this->store->id)
            ->andReturn($this->pdfPath);

        Livewire::actingAs($this->consultant)
            ->test(ExecutiveSummary::class)
            ->call('download')
            ->assertFileDownloaded();
    })->with(['Owner', 'GM', 'CFO', 'GSM', 'Qualified Individual']);

    it('allows super-admins to download even without a pivot assignment', function (): void {
        $this->consultant->syncRoles('super-admin');
        $this->consultant->stores()->detach();

        mock(ComplianceSummaryPdfService::class)
            ->shouldReceive('generate')
            ->once()
            ->andReturn($this->pdfPath);

        Livewire::actingAs($this->consultant)
            ->test(ExecutiveSummary::class)
            ->call('download')
            ->assertFileDownloaded();
    });

    it('forbids an authorized non-admin user from downloading a store they do not belong to', function (): void {
        $otherStore = Store::query()->create(['name' => 'Other Store', 'slug' => 'other-store']);

        $this->consultant->syncRoles('Owner');
        $this->consultant->stores()->sync([$this->store->id]);

        // The current store context points at a store the user has no pivot to.
        app()->instance('currentStore', $otherStore->id);
        app()->instance('currentStoreModel', $otherStore);

        Livewire::actingAs($this->consultant)
            ->test(ExecutiveSummary::class)
            ->call('download')
            ->assertForbidden();
    });

    it('re-resolves the store from server-side context on download rather than trusting component state', function (): void {
        $secondStore = Store::query()->create(['name' => 'Second Store', 'slug' => 'second-store']);

        $this->consultant->syncRoles('Owner');
        $this->consultant->stores()->sync([$this->store->id, $secondStore->id]);

        $component = Livewire::actingAs($this->consultant)
            ->test(ExecutiveSummary::class);

        // Simulate the user switching the selected store between mount and download.
        app()->instance('currentStore', $secondStore->id);
        app()->instance('currentStoreModel', $secondStore);

        mock(ComplianceSummaryPdfService::class)
            ->shouldReceive('generate')
            ->once()
            ->withArgs(fn (EloquentCollection $stores): bool => $stores->first()->id === $secondStore->id)
            ->andReturn($this->pdfPath);

        $component
            ->call('download')
            ->assertFileDownloaded();
    });

    it('returns 404 when no store can be resolved', function (): void {
        $this->consultant->syncRoles('Owner');
        $this->consultant->stores()->detach();

        app()->forgetInstance('currentStore');
        app()->forgetInstance('currentStoreModel');
        app()->instance('accessibleStoreIds', collect());
        app()->instance('scopedStoreIds', collect());

        Livewire::actingAs($this->consultant)
            ->test(ExecutiveSummary::class)
            ->call('download')
            ->assertStatus(404);
    });

});
