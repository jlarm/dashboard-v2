<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Sds;

use App\Models\Sds;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Override;

class Index extends Component
{
    use Searchable, WithPagination;

    #[Override]
    protected $listeners = ['refresh' => '$refresh'];

    public function render(): View
    {
        $query = Sds::query();
        $query = $this->applySearch($query);
        $sheets = $query->paginate(10);

        return view('livewire.central.sds.index', [
            'sheets' => $sheets,
        ])->layout('layouts.app');
    }
}
