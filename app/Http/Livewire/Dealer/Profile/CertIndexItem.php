<?php

namespace App\Http\Livewire\Dealer\Profile;

use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class CertIndexItem extends Component
{
    public Certificate $cert;

    public function render()
    {
        return view('livewire.dealer.profile.cert-index-item', [
            'url' => Storage::disk('armp-certs')->temporaryUrl(tenant('id').'/'.auth()->user()->id.'/'.$this->cert->file_name, now()->addSeconds(15)),
        ]);
    }
}
