<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\AuditStatements\Osha;

use App\Http\Livewire\Central\AuditStatements\Traits\Keywordable;
use App\Models\OshaViolationStatements;
use Filament\Notifications\Notification;
use Livewire\Component;

class Edit extends Component
{
    use Keywordable;

    public OshaViolationStatements $oshaViolation;
    public $statement;
    public $keywords = [];
    public $newKeyword = '';

    public function mount()
    {
        $this->statement = $this->oshaViolation->statement;
        $this->keywords = json_decode($this->oshaViolation->keywords);
    }

    public function update()
    {
        $this->validate([
            'statement' => 'required',
            'keywords' => 'nullable',
        ]);

        $this->oshaViolation->update([
            'statement' => $this->statement,
            'keywords' => json_encode($this->keywords),
        ]);

        Notification::make()
            ->title('Violation Updated Successfully!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.central.audit-statements.osha.edit');
    }
}
