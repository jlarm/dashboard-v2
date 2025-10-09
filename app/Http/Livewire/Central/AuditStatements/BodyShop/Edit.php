<?php

namespace App\Http\Livewire\Central\AuditStatements\BodyShop;

use App\Http\Livewire\Central\AuditStatements\Traits\Keywordable;
use App\Models\BodyShopViolationStatement;
use Filament\Notifications\Notification;
use Livewire\Component;

class Edit extends Component
{
    use Keywordable;

    public BodyShopViolationStatement $bodyShopViolation;
    public $statement;
    public $keywords = [];
    public $newKeyword = '';

    public function mount()
    {
        $this->statement = $this->bodyShopViolation->statement;
        $this->keywords = json_decode($this->bodyShopViolation->keywords);
    }

    public function update()
    {
        $this->validate([
            'statement' => 'required',
            'keywords' => 'nullable',
        ]);

        $this->bodyShopViolation->update([
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
        return view('livewire.central.audit-statements.body-shop.edit');
    }
}
