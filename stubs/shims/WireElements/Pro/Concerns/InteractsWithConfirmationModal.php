<?php

declare(strict_types=1);

namespace WireElements\Pro\Concerns;

use Closure;

/**
 * Compatibility shim for removed wire-elements/pro confirmation-modal trait.
 * askForConfirmation() is a no-op until components are migrated to Flux.
 * Deliberately does NOT invoke the callback to avoid bypassing confirmations.
 */
trait InteractsWithConfirmationModal
{
    public function askForConfirmation(?Closure $callback = null, array $prompt = []): void
    {
        //
    }

    public function askForConfirmationAsync(?Closure $callback = null, array $prompt = []): void
    {
        //
    }
}
