<?php

declare(strict_types=1);

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
    public int $weight;

    public function mount(): void
    {
        $this->statement = $this->bodyShopViolation->statement;
        $keywords = $this->bodyShopViolation->keywords;
        $this->keywords = is_string($keywords) ? (json_decode($keywords, true) ?? []) : (array) $keywords;
        $this->weight = $this->bodyShopViolation->weight;
    }

    public function update(): void
    {
        $this->validate([
            'statement' => 'required',
            'keywords' => 'nullable',
            'weight' => 'required|integer|min:1|max:10',
        ]);

        $this->bodyShopViolation->update([
            'statement' => $this->statement,
            'keywords' => $this->keywords,
            'weight' => $this->weight,
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
