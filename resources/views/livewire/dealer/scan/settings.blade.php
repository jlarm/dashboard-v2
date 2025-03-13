<div class="max-w-md mx-auto">
    <form wire:submit.prevent="update" class="space-y-5">
        <div>
            <x-input-label class="mb-2" for="name" value="External Scans ID"/>
            <input
                wire:model="externalId"
                type="text"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
            />
        </div>

        <div>
            <x-input-label class="mb-2" for="name" value="Internal Scans ID"/>
            <input
                wire:model="internalId"
                type="text"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
            />
        </div>

        <x-primary-button>Update</x-primary-button>
    </form>
</div>
