<?php

declare(strict_types=1);

namespace WireElements\Pro\Components\SlideOver;

use Livewire\Component;

/**
 * Compatibility shim for removed wire-elements/pro package.
 * Components that extend this will boot but slide-over behaviour is no-op
 * until they are migrated to Flux <flux:modal variant="flyout">.
 */
abstract class SlideOver extends Component
{
    final public static function behavior(): array
    {
        return [];
    }

    final public function closeSlideOver(): void
    {
        $this->dispatch('close-slide-over');
    }

    final public function forceCloseSlideOver(): void
    {
        $this->dispatch('close-slide-over');
    }
}
