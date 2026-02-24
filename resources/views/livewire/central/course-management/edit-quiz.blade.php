<div
    x-data="{ showToast: false, toastType: 'success', toastMessage: '' }"
    x-on:course-quiz-updated.window="
        toastType = $event.detail.status;
        toastMessage = $event.detail.message;
        showToast = true;
        setTimeout(() => showToast = false, 3000);
    "
    class="bg-white rounded-md p-6"
>
    <div
        x-cloak
        x-show="showToast"
        x-transition
        class="mb-6 rounded-md px-4 py-3 text-sm font-medium"
        :class="toastType === 'success' ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-red-50 text-red-800 border border-red-200'"
    >
        <span x-text="toastMessage"></span>
    </div>

    <h1 class="text-2xl font-bold mb-10">{{ $name }} Quiz</h1>
    <form wire:submit.prevent="update" class="max-w-4xl mx-auto">
        <div>
            {{ $this->form }}
        </div>
        <x-primary-button wire:loading.attr="disabled" wire:target="update" class="mt-4">
            <x-loading-icon wire:loading wire:target="update" class="!text-white mr-2 size-4" />
            <span wire:loading.remove wire:target="update">Update</span>
            <span wire:loading wire:target="update">Updating...</span>
        </x-primary-button>
    </form>
</div>
