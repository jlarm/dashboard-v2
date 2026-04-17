<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealership;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Override;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 25;

    #[Override]
    protected $listeners = [
        'refreshDealerships' => '$refresh',
        'deleteDealership' => 'deleteDealership',
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function deleteDealership(string $dealershipId): void
    {
        Gate::authorize('delete-dealership');

        try {
            DB::beginTransaction();

            $dealership = Dealership::query()->findOrFail($dealershipId);
            $dealership->users()->detach();
            $dealership->delete();

            DB::commit();

            Notification::make()
                ->title('Dealership Deleted')
                ->success()
                ->send();
        } catch (Exception $e) {
            DB::rollBack();

            Notification::make()
                ->title('Error Deleting Dealership')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function updatedPerPage(): void
    {
        abort_unless(in_array($this->perPage, [10, 25, 50], true), 422);
        $this->resetPage();
    }

    public function render(): View
    {
        $dealerships = $this->getDealerships()
            ->orderBy('name')
            ->search('name', $this->search)
            ->with('users')
            ->paginate($this->perPage);

        return view('livewire.central.dealership.index', [
            'dealerships' => $dealerships,
        ]);
    }

    private function getDealerships(): Builder
    {
        if (auth()->user()->hasRole('super-admin')) {
            return Dealership::query();
        }

        return Dealership::query()
            ->whereHas('users', function (Builder $query): void {
                $query->where('user_id', auth()->id());
            })
            ->orWhere('id', config('dashboard.default_dealership_id'));
    }
}
