<div class="max-w-xl mx-auto">
    <form class="space-y-5" wire:submit.prevent="update">
        <div>
            <x-input label="Statement" id="statement" type="text" required wire:model.defer="statement" />
        </div>

        <div wire:ignore>
            <x-armp.select label="Weight" variant="listbox" placeholder="Select Weight" :value="(string) $weight" wire:model.defer="weight">
                @for($i = 1; $i < 11; $i++)
                    <x-armp.select.option :value="$i">{{ $i }}</x-armp.select.option>
                @endfor
            </x-armp.select>
        </div>

        <div wire:ignore>
            <x-armp.select label="Categories" variant="listbox" multiple placeholder="Select categories" :value="$categories" wire:model.defer="categories">
                @foreach (\App\Enums\ViolationStatementCategory::cases() as $category)
                    <x-armp.select.option :value="$category->value">{{ $category->label() }}</x-armp.select.option>
                @endforeach
            </x-armp.select>
        </div>

        <div>
            @if ($violationStatement->reference_image_url)
                <div class="mb-2">
                    <p class="text-sm font-medium text-gray-700 mb-1">Current Image</p>
                    <div class="flex items-start gap-3">
                        <img src="{{ $violationStatement->reference_image_url }}" alt="Reference image" class="h-24 rounded-md border border-gray-200 object-cover">
                        <x-armp.button
                            size="xs"
                            variant="danger"
                            @click="confirm('Remove this image?') && $wire.call('removeImage')"
                        >Remove</x-armp.button>
                    </div>
                </div>
            @endif
            <x-input
                type="file"
                wire:model.defer="newImage"
                id="newImage"
                label="{{ $violationStatement->reference_image_url ? 'Replace Image' : 'Reference Image' }}"
            />
        </div>

        <div
            x-data="{
                keywords: $wire.entangle('keywords'),
                newKeyword: '',
                add() {
                    const trimmed = this.newKeyword.trim();
                    if (trimmed !== '' && !this.keywords.includes(trimmed)) {
                        this.keywords.push(trimmed);
                        this.newKeyword = '';
                    }
                },
                remove(index) {
                    this.keywords.splice(index, 1);
                }
            }"
        >
            <div @keydown.enter.prevent="add()">
                <x-input-label for="keyword" :value="__('Add Keywords')"/>
                <x-text-input
                    x-model="newKeyword"
                    class="block mt-1 w-full"
                    type="text"
                />
                <p class="mt-2 text-sm text-gray-500">Hit the enter key to add a keyword.</p>
            </div>
            <div class="flex gap-2 mt-2">
                <template x-for="(keyword, index) in keywords" :key="index">
                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                        <span x-text="keyword"></span>
                        <button type="button" @click="remove(index)" class="text-blue-700 ml-2">&times;</button>
                    </span>
                </template>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <x-armp.button type="submit" variant="primary">Update</x-armp.button>
                <x-armp.button href="{{ route('violation-statements.index') }}">Cancel</x-armp.button>
            </div>
            <x-armp.button
                variant="danger"
                @click="confirm('Are you sure you want to delete this violation statement? This cannot be undone.') && $wire.call('delete')"
            >Delete</x-armp.button>
        </div>
    </form>
</div>
