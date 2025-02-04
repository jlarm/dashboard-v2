<div class="bg-white rounded-md p-6">
    <form wire:submit.prevent="update" class="max-w-4xl mx-auto">
        <div>
            {{ $this->form }}
        </div>
        <x-primary-button>Update</x-primary-button>
    </form>
</div>
