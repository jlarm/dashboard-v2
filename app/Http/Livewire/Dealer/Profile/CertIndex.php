<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Profile;

use Livewire\Component;

class CertIndex extends Component
{
    public function render()
    {
        return view('livewire.dealer.profile.cert-index', [
            'certs' => auth()->user()->certificates()->latest()->get(),
        ]);
    }
}
