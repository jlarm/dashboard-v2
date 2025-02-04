<div class="bg-white rounded-md p-6">
    <h1 class="text-2xl font-bold mb-10">{{ $name }} Quiz</h1>
    <form wire:submit.prevent="update" class="max-w-4xl mx-auto">
        <div>
            {{ $this->form }}
        </div>
        <x-primary-button>Update</x-primary-button>
    </form>
</div>
