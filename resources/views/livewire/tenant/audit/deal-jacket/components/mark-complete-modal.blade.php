<form wire:submit="markComplete" class="space-y-4">
    <h2 class="text-lg font-semibold">Complete Deal Jacket Group</h2>

    <div>
        Are you sure you want to complete this quarterly audit?
    </div>

    <div class="flex justify-end gap-2">
        <x-secondary-button type="button" wire:click="$dispatch('modal-close')">Cancel</x-secondary-button>
        <x-primary-button type="submit">Complete</x-primary-button>
    </div>
</form>
