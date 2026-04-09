<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\ViolationStatements;

use App\Models\ViolationStatement;
use Illuminate\View\View;
use Livewire\Component;

class PrintView extends Component
{
    public function render(): View
    {
        return view('livewire.central.violation-statements.print-view', [
            'statements' => ViolationStatement::query()->orderBy('statement')->get(),
        ])->layout('layouts.guest');
    }
}
