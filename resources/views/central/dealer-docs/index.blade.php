<x-app-layout>
    <div class="space-y-5">
        <div class="flex justify-between items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Dealership Documents</h1>
                <p class="text-sm text-gray-500 mt-1">These documents will be accessible to all dealerships.</p>
            </div>
            <div>
                <x-button.primary href="{{ route('dealer-docs.create') }}">Upload</x-button.primary>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <livewire:central.shared-docs.index />
    </div>
</x-app-layout>
