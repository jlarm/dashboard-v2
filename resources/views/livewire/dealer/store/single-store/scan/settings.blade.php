<div>
    <livewire:dealer.store.single-store-sub-nav :store="$store"/>
    <form wire:submit.prevent="update" class="space-y-5 max-w-md mx-auto">
        <div>
            <x-input-label class="mb-2" for="name" value="Dealership Name"/>
            <input wire:model.defer="name" type="text"
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
            <p class="mt-2 text-sm text-gray-500">The dealership name must match the name in Red
                Sentry in order to display results.</p>
        </div>
        <x-primary-button>Update</x-primary-button>
        <a
            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
            href="{{ route('dealer.stores.scans', $store) }}">Cancel</a>
    </form>
</div>
