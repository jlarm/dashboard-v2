<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\AuditStatements\Osha;

use App\Http\Livewire\Central\AuditStatements\Traits\Keywordable;
use App\Models\OshaViolationStatements;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
    use Keywordable;

    public string $statement = '';
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

        OshaViolationStatements::query()->create([
            'statement' => $this->statement,
            'keywords' => json_encode($this->keywords, JSON_THROW_ON_ERROR) ?: null,
            'weight' => $this->weight,
        ]);

        $this->reset(['statement', 'keywords', 'newKeyword', 'weight']);

        Notification::make()
            ->title('Violation Added Successfully!')
            ->success()
            ->send();

    }

    public function render(): View
    {
        return view('livewire.central.audit-statements.osha.create');
    }
}
