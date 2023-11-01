<form wire:submit.prevent="create" class="space-y-3.5">
    <div>
        <x-text-input
            wire:model.defer="name"
            id="name"
            class="block mt-1 w-full"
            type="text"
            name="name"
            :value="old('name')"
            required
            autofocus
            placeholder="Department Name"
        />
    </div>
    <x-primary-button>Save</x-primary-button>
</form>
