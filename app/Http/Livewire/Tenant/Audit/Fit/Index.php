<?php

namespace App\Http\Livewire\Tenant\Audit\Fit;

use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public ?Store $store;
    protected $listeners = ['saved' => '$refresh'];

    public function mount(): void
    {
        $this->store = Store::query()->find(app('currentStore'));
    }

    public function render(): View
    {
        $fitTests = $this->store->fitTests()
            ->orderBy('created_at')
            ->orderBy('employee_name')
            ->get()
            ->fresh();

        return view('livewire.tenant.audit.fit.index', [
            'docs' => $fitTests,
        ])->layout('components.dealer-app');
    }
}
