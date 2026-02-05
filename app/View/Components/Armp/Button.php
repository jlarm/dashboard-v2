<?php

declare(strict_types=1);

namespace App\View\Components\Armp;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public function __construct(
        public string $variant = 'outline',
        public string $size = 'base',
        public bool $square = false,
        public string $align = 'center',
        public ?string $as = null,
        public ?string $href = null,
        public string $type = 'button',
        public bool $loading = false,
        public ?string $tooltip = null,
        public string $tooltipPosition = 'top',
    ) {}

    public function render(): View
    {
        return view('components.armp.button');
    }
}
