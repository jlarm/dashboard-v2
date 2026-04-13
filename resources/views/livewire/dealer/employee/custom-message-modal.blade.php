<x-wire-elements-pro::tailwind.modal on-submit="send" :content-padding="true" max-width="2xl">
    <x-slot name="title">Send Custom Message</x-slot>

    <div class="space-y-4">
        <div class="rounded-md bg-blue-50 px-4 py-3 text-sm text-blue-700">
            Sending to <span class="font-semibold">{{ $userCount }} {{ Str::plural('employee', $userCount) }}</span>. The subject and message below have been pre-filled for you — feel free to customize them before sending.
        </div>

        <div>
            <label for="custom_message_subject" class="block text-sm font-medium text-gray-700">Subject</label>
            <div class="mt-1">
                <input
                    wire:model.defer="subject"
                    id="custom_message_subject"
                    type="text"
                    placeholder="e.g. Action Required: Complete Your Compliance Training"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                />
                @error('subject')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div
            x-data="{
                execCmd(cmd, value) {
                    document.execCommand(cmd, false, value ?? null);
                    this.$refs.editor.focus();
                    this.syncToHidden();
                },
                syncToHidden() {
                    this.$refs.hiddenInput.value = this.$refs.editor.innerHTML;
                    this.$refs.hiddenInput.dispatchEvent(new Event('input'));
                },
                isActive(cmd) {
                    return document.queryCommandState(cmd);
                }
            }"
            x-init="
                $refs.editor.innerHTML = @js(
                    '<p>This is a friendly reminder that you have outstanding compliance training courses that need to be completed. Please log in and complete your assigned courses at your earliest convenience.</p>' .
                    '<p>If you have any questions, please don\'t hesitate to reach out.</p>'
                );
                syncToHidden();
            "
        >
            <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>

            {{-- Toolbar --}}
            <div class="flex flex-wrap items-center gap-1 rounded-t-md border border-b-0 border-gray-300 bg-gray-50 px-2 py-1.5">
                <button
                    type="button"
                    @click="execCmd('bold')"
                    :class="isActive('bold') ? 'bg-gray-200' : ''"
                    class="rounded p-1 text-sm font-bold text-gray-600 hover:bg-gray-200 focus:outline-none"
                    title="Bold"
                >B</button>
                <button
                    type="button"
                    @click="execCmd('italic')"
                    :class="isActive('italic') ? 'bg-gray-200' : ''"
                    class="rounded p-1 text-sm italic text-gray-600 hover:bg-gray-200 focus:outline-none"
                    title="Italic"
                >I</button>
                <button
                    type="button"
                    @click="execCmd('underline')"
                    :class="isActive('underline') ? 'bg-gray-200' : ''"
                    class="rounded p-1 text-sm underline text-gray-600 hover:bg-gray-200 focus:outline-none"
                    title="Underline"
                >U</button>
                <div class="mx-1 h-5 w-px bg-gray-300"></div>
                <button
                    type="button"
                    @click="execCmd('insertUnorderedList')"
                    class="rounded p-1 text-sm text-gray-600 hover:bg-gray-200 focus:outline-none"
                    title="Bullet List"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                </button>
                <button
                    type="button"
                    @click="execCmd('insertOrderedList')"
                    class="rounded p-1 text-sm text-gray-600 hover:bg-gray-200 focus:outline-none"
                    title="Numbered List"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h10M7 16h10M3 8h.01M3 12h.01M3 16h.01" />
                    </svg>
                </button>
                <div class="mx-1 h-5 w-px bg-gray-300"></div>
                <button
                    type="button"
                    @click="execCmd('removeFormat')"
                    class="rounded p-1 text-xs text-gray-600 hover:bg-gray-200 focus:outline-none"
                    title="Clear Formatting"
                >Clear</button>
            </div>

            {{-- Hidden input that Livewire reads on submit --}}
            <textarea wire:model.defer="messageBody" x-ref="hiddenInput" class="hidden"></textarea>

            {{-- Editor --}}
            <div
                x-ref="editor"
                contenteditable="true"
                @input="syncToHidden()"
                @keydown.tab.prevent="execCmd('insertHTML', '&nbsp;&nbsp;&nbsp;&nbsp;')"
                class="min-h-[200px] w-full rounded-b-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-arm-blue-500 focus:outline-none focus:ring-1 focus:ring-arm-blue-500"
            ></div>

            @error('messageBody')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <x-slot name="buttons">
        <div class="flex items-center gap-2">
            <x-loading-icon wire:loading wire:target="send" />
            <x-armp.button type="button" wire:click="$emit('modal.close')" variant="outline" class="ml-auto">Cancel</x-armp.button>
            <x-armp.button type="submit" variant="primary">Send Message</x-armp.button>
        </div>
    </x-slot>
</x-wire-elements-pro::tailwind.modal>
