<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Home\GroupExecutiveSummary;
use App\Models\Dealer\Store;
use App\Services\ComplianceSummaryPdfService;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\File;
use Livewire\Livewire;

use function Pest\Laravel\mock;

describe('GroupExecutiveSummary', function (): void {

    beforeEach(function (): void {
        $this->pdfPath = storage_path('app/compliance-summary/test-'.uniqid().'.pdf');

        if (! File::isDirectory(dirname($this->pdfPath))) {
            File::makeDirectory(dirname($this->pdfPath), 0777, true, true);
        }

        File::put($this->pdfPath, '%PDF-1.4 stub');
    });

    afterEach(function (): void {
        File::delete($this->pdfPath);
    });

    it('forbids roles that are not authorized to download the group report', function (string $role): void {
        $this->consultant->syncRoles($role);

        Livewire::actingAs($this->consultant)
            ->test(GroupExecutiveSummary::class)
            ->call('download')
            ->assertForbidden();
    })->with(['Manager', 'Consultant', 'Employee']);

    it('forbids unauthenticated users from downloading the group report', function (): void {
        Livewire::test(GroupExecutiveSummary::class)
            ->call('download')
            ->assertForbidden();
    });

    it('allows authorized roles to download the group report', function (string $role): void {
        $this->consultant->syncRoles($role);
        $this->consultant->stores()->sync(Store::query()->pluck('id')->all());

        mock(ComplianceSummaryPdfService::class)
            ->shouldReceive('generate')
            ->once()
            ->andReturn($this->pdfPath);

        Livewire::actingAs($this->consultant)
            ->test(GroupExecutiveSummary::class)
            ->call('download')
            ->assertFileDownloaded();
    })->with(['Owner', 'GM', 'CFO', 'GSM', 'Qualified Individual']);

    it('returns 404 when the authorized user has no assigned stores', function (): void {
        $this->consultant->syncRoles('Owner');
        $this->consultant->stores()->detach();

        Livewire::actingAs($this->consultant)
            ->test(GroupExecutiveSummary::class)
            ->call('download')
            ->assertStatus(404);
    });

    it('scopes the report to every store the authorized non-admin user belongs to', function (): void {
        $extraStore = Store::query()->create(['name' => 'Extra Store', 'slug' => 'extra-store']);
        $unassignedStore = Store::query()->create(['name' => 'Unassigned Store', 'slug' => 'unassigned-store']);

        $this->consultant->syncRoles('Owner');
        $this->consultant->stores()->sync([
            Store::query()->where('slug', 'test-store')->value('id'),
            $extraStore->id,
        ]);

        mock(ComplianceSummaryPdfService::class)
            ->shouldReceive('generate')
            ->once()
            ->withArgs(function (EloquentCollection $stores) use ($unassignedStore): bool {
                $ids = $stores->pluck('id')->all();

                return count($ids) === 2 && ! in_array($unassignedStore->id, $ids, true);
            })
            ->andReturn($this->pdfPath);

        Livewire::actingAs($this->consultant)
            ->test(GroupExecutiveSummary::class)
            ->call('download')
            ->assertFileDownloaded();
    });

    it('includes every tenant store for super-admins regardless of pivot assignments', function (): void {
        Store::query()->create(['name' => 'Second Store', 'slug' => 'second-store']);

        $this->consultant->syncRoles('super-admin');
        $this->consultant->stores()->detach();

        $expectedCount = Store::query()->count();

        mock(ComplianceSummaryPdfService::class)
            ->shouldReceive('generate')
            ->once()
            ->withArgs(fn (EloquentCollection $stores): bool => $stores->count() === $expectedCount)
            ->andReturn($this->pdfPath);

        Livewire::actingAs($this->consultant)
            ->test(GroupExecutiveSummary::class)
            ->call('download')
            ->assertFileDownloaded();
    });

});
