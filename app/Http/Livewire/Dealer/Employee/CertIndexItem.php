<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Certificate;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class CertIndexItem extends Component
{
    public User $user;

    public Certificate $cert;

    public function render()
    {
        return view('livewire.dealer.employee.cert-index-item', [
            'url' => Storage::disk('armp-certs')->temporaryUrl(tenant('id').'/'.$this->user->id.'/'.$this->cert->file_name, now()->addSeconds(15)),
        ]);
    }
}
