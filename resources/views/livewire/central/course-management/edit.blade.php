<div class="bg-white rounded-md p-6">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <form wire:submit.prevent="update" class="space-y-10">
        <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">{{ $name }}</h1>
        <div>
            <x-input-label for="name" :value="__('Course Name')"/>
            <x-text-input
                wire:model.defer="name"
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
            />
        </div>
        <div class="space-y-10">
            @foreach($slides as $slide)
                <div class="space-y-5">
                    <x-text-input
                        wire:model.defer="slides.{{ $loop->index }}.title"
                        id="slides.{{ $loop->index }}.title"
                        class="block mt-1 w-full"
                        type="text"
                        name="slides.{{ $loop->index }}.title"
                        :value="old('slides.{{ $loop->index }}.title')"
                        required
                        autofocus
                    />
                    <div
                        x-data="initQuillEditor($refs, $dispatch)"
                        class="bg-white">
                        <input
                            type="text"
                            x-ref="descriptionInput"
                            wire:model.defer="slides.{{ $loop->index }}.description"
                        >
                        <div x-ref="quill" wire:ignore></div>
                    </div>
                </div>
            @endforeach
        </div>
        <x-primary-button>Update</x-primary-button>
    </form>
    <script>
        function initQuillEditor(refs, dispatch) {
            return {
                init() {
                    let quill = new Quill(refs.quill, {
                        theme: 'snow',
                        modules: {
                            toolbar: [['bold', 'italic', {'list': 'ordered'}, {'list': 'bullet'}, 'image']]
                        }
                    });

                    quill.root.innerHTML = refs.descriptionInput.value;

                    quill.on('text-change', () => {
                        refs.descriptionInput.value = quill.root.innerHTML;
                    });
                }
            };
        }
    </script>
</div>
