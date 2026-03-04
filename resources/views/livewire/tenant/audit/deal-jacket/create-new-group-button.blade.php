<div>
    @if (is_int($storeId))
        <x-armp.button wire:click.prevent="create" size="sm" variant="primary">Start Quarterly Audit</x-armp.button>
    @endif
</div>
