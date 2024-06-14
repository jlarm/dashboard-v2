<div class="max-w-md mx-auto">
    <form wire:submit.prevent="update" class="space-y-5">
        <div>
            <x-input-label class="mb-2" for="name" value="Dealership Name"/>
            <input wire:model.defer="name" type="text"
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
            <p class="mt-2 text-sm text-gray-500">The dealership name must match the name in Red
                Sentry in order to display results.</p>
        </div>
        <x-primary-button>Update</x-primary-button>
    </form>
</div>
