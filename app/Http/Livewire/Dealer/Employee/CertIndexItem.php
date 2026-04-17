<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Certificate;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class CertIndexItem extends Component
{
    public User $user;
    public Certificate $cert;

    public function render(): Factory|View
    {
        return view('livewire.dealer.employee.cert-index-item', [
            'url' => Storage::disk('armp-certs')->temporaryUrl(tenant('id').'/'.$this->user->id.'/'.$this->cert->file_name, now()->addSeconds(15)),
        ]);
    }
}
