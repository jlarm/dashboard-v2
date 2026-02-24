<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store\SingleStore\Employee;

use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
    public Store $store;

    public function mount(Store $store): void
    {
        $this->store = $store;
    }

    public function render(): View
    {
        return view('livewire.dealer.store.single-store.employee.create')->layout('components.dealer-app');
    }
}
