<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\AuditStatements\Glba;

use App\Http\Livewire\Central\AuditStatements\Traits\Keywordable;
use App\Models\GlbaViolationStatements;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    use Keywordable;

    public $statement;
    public $keywords = [];
    public int $weight = 1;
    protected $rules = [
        'statement' => 'required|string|max:255',
        'keywords' => 'nullable|array',
        'weight' => 'required|integer|min:1|max:10',
    ];

    public function create(): void
    {
        $this->validate();

        if ($this->keywords === null) {
            $this->keywords = [];
        }

        GlbaViolationStatements::query()->create([
            'statement' => $this->statement,
            'keywords' => $this->keywords ?: null,
            'weight' => $this->weight,
        ]);

        $this->reset(['statement', 'keywords', 'newKeyword', 'weight']);

        Notification::make()
            ->title('Violation Added Successfully!')
            ->success()
            ->send();

    }

    public function render(): Factory|View
    {
        return view('livewire.central.audit-statements.glba.create');
    }
}
