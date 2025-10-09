<?php

namespace App\Http\Livewire\Central\AuditStatements\Glba;

use App\Http\Livewire\Central\AuditStatements\Traits\Keywordable;
use App\Models\GlbaViolationStatements;
use Filament\Notifications\Notification;
use Livewire\Component;

class Edit extends Component
{
    use Keywordable;

    public GlbaViolationStatements $glbaViolation;
    public $statement;
    public $keywords = [];
    public $newKeyword = '';

    public function mount()
    {
        $this->statement = $this->glbaViolation->statement;
        $this->keywords = json_decode($this->glbaViolation->keywords);
    }

    public function update()
    {
        $this->validate([
            'statement' => 'required',
            'keywords' => 'nullable',
        ]);

        $this->glbaViolation->update([
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
        return view('livewire.central.audit-statements.glba.edit');
    }
}
