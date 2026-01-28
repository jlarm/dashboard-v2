<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit;

use App\Models\Dealer\Violation;
use WireElements\Pro\Components\Modal\Modal;

class ImageModal extends Modal
{
    public $filesId;
    public $violation;

    public static function attributes(): array
    {
        return [
            'size' => '3xl',
        ];
    }

    public function mount(Violation $violation)
    {
        $this->violation = $violation;
    }

    public function render()
    {
        return view('livewire.dealer.audit.image-modal');
    }
}
