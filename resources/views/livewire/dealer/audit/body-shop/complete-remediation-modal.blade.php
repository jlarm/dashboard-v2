<x-wire-elements-pro::tailwind.modal on-submit="generate">
    <x-slot name="title">Generate Remediation PDF</x-slot>

    <div class="text-gray-600">
        Are you sure you want to generate this remediation PDF?
    </div>

    <x-slot name="buttons">
        <div class="w-full flex items-center gap-2">
            <x-loading-icon wire:loading />
            <x-secondary-button class="ml-auto" type="button" wire:click="$emit('modal.close')">Cancel</x-secondary-button>
            <x-primary-button type="submit">Generate</x-primary-button>
        </div>
    </x-slot>
</x-wire-elements-pro::tailwind.modal>
