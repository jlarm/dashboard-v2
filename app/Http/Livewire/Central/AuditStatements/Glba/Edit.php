<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\AuditStatements\Glba;

use App\Http\Livewire\Central\AuditStatements\Traits\Keywordable;
use App\Models\GlbaViolationStatements;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Edit extends Component
{
    use Keywordable;

    public GlbaViolationStatements $glbaViolation;
    public $statement;
    public $keywords = [];
    public $newKeyword = '';
    public int $weight;

    public function mount(): void
    {
        $this->statement = $this->glbaViolation->statement;
        $keywords = $this->glbaViolation->keywords;
        $this->keywords = is_string($keywords) ? (json_decode($keywords, true) ?? []) : (array) $keywords;
        $this->weight = $this->glbaViolation->weight;
    }

    public function update(): void
    {
        $this->validate([
            'statement' => 'required',
            'keywords' => 'nullable',
            'weight' => 'required|integer|min:1|max:10',
        ]);

        $this->glbaViolation->update([
            'statement' => $this->statement,
            'keywords' => $this->keywords,
            'weight' => $this->weight,
        ]);

        Notification::make()
            ->title('Violation Updated Successfully!')
            ->success()
            ->send();
    }

    public function render(): Factory|View
    {
        return view('livewire.central.audit-statements.glba.edit');
    }
}
