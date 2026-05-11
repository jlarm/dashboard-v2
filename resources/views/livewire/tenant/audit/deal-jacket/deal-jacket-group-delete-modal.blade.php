<form wire:submit="delete" class="space-y-4">
    <h2 class="text-lg font-semibold">Delete Deal Jacket Group</h2>

    <div>
        Are you sure you want to delete the quarterly audit and its audits?
    </div>

    <div class="flex justify-end gap-2">
        <x-secondary-button type="button" wire:click="$dispatch('modal-close')">Cancel</x-secondary-button>
        <x-danger-button type="submit">Delete</x-danger-button>
    </div>
</form>
