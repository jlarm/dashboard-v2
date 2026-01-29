<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\AuditStatements\Osha;

use App\Http\Livewire\Central\AuditStatements\Traits\Keywordable;
use App\Models\OshaViolationStatements;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Component;

class Edit extends Component
{
    use Keywordable;

    public OshaViolationStatements $oshaViolation;
    public string $statement;
    public $keywords = [];
    public $newKeyword = '';
    public int $weight;

    public function mount(): void
    {
        $this->statement = $this->oshaViolation->statement;
        $this->keywords = json_decode((string) $this->oshaViolation->keywords);
        $this->weight = $this->oshaViolation->weight;
    }

    public function update(): void
    {
        $this->validate([
            'statement' => 'required|string|min:2|max:255',
            'keywords' => 'nullable',
            'weight' => 'required|integer|min:1|max:10',
        ]);

        $this->oshaViolation->update([
            'statement' => $this->statement,
            'keywords' => json_encode($this->keywords),
            'weight' => $this->weight,
        ]);

        Notification::make()
            ->title('Violation Updated Successfully!')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.central.audit-statements.osha.edit');
    }
}
