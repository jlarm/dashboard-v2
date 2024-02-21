<?php

namespace App\Http\Livewire\Central\AuditStatements\BodyShop;

use App\Http\Livewire\Central\AuditStatements\Traits\Keywordable;
use App\Models\BodyShopViolationStatement;
use Filament\Notifications\Notification;
use Livewire\Component;

class Create extends Component
{
    use Keywordable;

    public $statement;

    public $keywords = [];

    protected $rules = [
        'statement' => 'required|string|max:255',
        'keywords' => 'nullable|array',
    ];

    public function create()
    {
        $this->validate();

        if ($this->keywords === null) {
            $this->keywords = [];
        }

        BodyShopViolationStatement::create([
            'statement' => $this->statement,
            'keywords' => json_encode($this->keywords) ?? null,
        ]);

        $this->reset(['statement', 'keywords', 'newKeyword']);

        Notification::make()
            ->title('Violation Added Successfully!')
            ->success()
            ->send();

    }

    public function render()
    {
        return view('livewire.central.audit-statements.body-shop.create');
    }
}
