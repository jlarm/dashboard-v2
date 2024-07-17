<?php

namespace App\Http\Livewire\Central\Sds;

use App\Models\Sds;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use Searchable, WithPagination;

    public function render()
    {
        $query = Sds::query();
        $query = $this->applySearch($query);
        $sheets = $query->paginate(10);

        return view('livewire.central.sds.index', [
            'sheets' => $sheets,
        ])->layout('layouts.app');
    }
}
