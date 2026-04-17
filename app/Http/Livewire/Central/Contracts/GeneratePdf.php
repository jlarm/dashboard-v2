<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Contracts;

use App\Jobs\Contracts\GeneratePdfJob;
use App\Jobs\Contracts\UploadToDigitalOceanJob;
use App\Models\Contract;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Bus;
use Livewire\Component;

class GeneratePdf extends Component
{
    public Contract $contract;

    public function generate(): void
    {
        Bus::chain([
            new GeneratePdfJob($this->contract),
            new UploadToDigitalOceanJob($this->contract),
        ])->dispatch();
    }

    public function render(): Factory|View
    {
        return view('livewire.central.contracts.generate-pdf');
    }
}
