<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class SubNav extends Component
{
    public ?Store $store = null;

    public function render(): View
    {
        return view('livewire.dealer.employee.sub-nav');
    }
}
