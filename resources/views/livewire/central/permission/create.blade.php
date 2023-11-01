<form wire:submit.prevent="create" class="space-y-5">
    <div>
        <x-text-input
            wire:model="name"
            id="name"
            class="block mt-1 w-full"
            type="text"
            name="name"
            :value="old('name')"
            required
            autofocus
            placeholder="Permission Name"
        />
    </div>
    <div>
        <x-primary-button>Submit</x-primary-button>
    </div>
</form>
