<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Profile;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CertIndex extends Component
{
    public function render(): Factory|View
    {
        return view('livewire.dealer.profile.cert-index', [
            'certs' => auth()->user()->certificates()->latest()->get(),
        ]);
    }
}
