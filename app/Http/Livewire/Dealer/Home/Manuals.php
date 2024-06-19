<?php

namespace App\Http\Livewire\Dealer\Home;

use App\Models\CmsManual;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Store;
use Livewire\Component;

class Manuals extends Component
{
    public ?Store $store;

    public function mount()
    {
        $this->store = $this->store ?? Store::first();
    }

    public function render()
    {
        return view('livewire.dealer.home.manuals', [
            'isp' => $this->store ? $this->store->isps->count() > 0 : Isp::exists(),
            'osha' => $this->store ? $this->store->oshas->count() > 0 : Osha::exists(),
            'redflag' => $this->store ? $this->store->redflags->count() > 0 : RedFlag::exists(),
            'cms' => $this->store ? $this->store->cmsManuals->count() > 0 : CmsManual::exists(),
        ]);
    }
}
