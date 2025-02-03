<x-app-layout>
    <div class="space-y-5">
        <div class="flex justify-between items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Editing {{ $document->title }}</h1>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <livewire:central.shared-docs.edit :shared-document="$document" />
    </div>
</x-app-layout>
