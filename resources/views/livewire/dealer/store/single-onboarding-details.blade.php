<div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:p-6">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <h3 class="text-base font-semibold leading-6 text-gray-900">Compliance Info</h3>
            <p class="mt-1 text-sm text-gray-500">This information will be displayed publicly so be careful what
                you share.</p>
        </div>
        <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
            <form wire:submit.prevent="update">
                {{ $this->form }}
                <div class="py-3 text-right">
                    <x-primary-button>Update</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>
