<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\Fit;

use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;
use Override;

class Index extends Component
{
    public ?Store $store = null;

    #[Override]
    protected $listeners = ['saved' => '$refresh'];

    public function mount(): void
    {
        $this->store = (app()->bound('currentStoreModel') ? resolve('currentStoreModel') : null)
            ?? Store::query()->find(resolve('currentStore'));
    }

    public function render(): View
    {
        $fitTests = $this->store->fitTests()->oldest()
            ->orderBy('employee_name')
            ->get()
            ->fresh();

        return view('livewire.tenant.audit.fit.index', [
            'docs' => $fitTests,
        ])->layout('components.dealer-app');
    }
}
