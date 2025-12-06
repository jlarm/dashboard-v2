<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Log;

use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class Index extends Component
{
    use WithPagination;

    public ?Activity $selectedLog = null;

    public function viewLogDetails(int $logId): void
    {
        $this->selectedLog = Activity::with('causer', 'subject')->findOrFail($logId);

        $this->dispatchBrowserEvent('open-log-modal');
    }

    public function closeModal(): void
    {
        $this->selectedLog = null;

        $this->dispatchBrowserEvent('close-log-modal');
    }

    public function render(): View
    {
        return view('livewire.dealer.log.index', [
            'logs' => Activity::with('causer')->latest()->paginate(25),
        ])->layout('components.dealer-app');
    }
}
