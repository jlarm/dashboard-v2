<?php

namespace App\Http\Livewire\Central\Sds;

trait Searchable
{
    public $search = '';

    public function updatedSearchable($property): void
    {
        if ($property === 'search') {
            $this->resetPage();
        }
    }

    protected function applySearch($query)
    {
        return $this->search === ''
            ? $query
            : $query
                ->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('manufacturer', 'like', '%'.$this->search.'%')
                ->orWhere('file_name', 'like', '%'.$this->search.'%');
    }
}
