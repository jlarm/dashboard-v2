<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Docs;

use App\Models\Document;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public Document $doc;

    public function render(): Factory|View
    {
        return view('livewire.central.docs.index-item');
    }
}
