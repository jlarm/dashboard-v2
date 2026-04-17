<?php

declare(strict_types=1);

namespace WireElements\Pro\Components\Modal;

use Livewire\Component;

/**
 * Compatibility shim for removed wire-elements/pro package.
 * Components that extend this will boot but modal/close behaviour is no-op
 * until they are migrated to Flux <flux:modal>.
 */
abstract class Modal extends Component
{
    public static function behavior(): array
    {
        return [];
    }

    public function closeModal(): void
    {
        $this->dispatch('close-modal');
    }

    public function forceCloseModal(): void
    {
        $this->dispatch('close-modal');
    }
}
