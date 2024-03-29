<div class="w-full flex justify-end mt-3">
    <div class="flex justify-center">
        <div
            x-data="{
                open: false,
                toggle() {
                    if (this.open) {
                        return this.close()
                    }

                    this.$refs.button.focus()

                    this.open = true
                },
                close(focusAfter) {
                    if (! this.open) return

                    this.open = false

                    focusAfter && focusAfter.focus()
                }
            }"
            x-on:keydown.escape.prevent.stop="close($refs.button)"
            x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
            x-id="['dropdown-button']"
            class="relative"
        >
            <!-- Button -->
            <button
                x-ref="button"
                x-on:click="toggle()"
                :aria-expanded="open"
                :aria-controls="$id('dropdown-button')"
                type="button"
                class="rounded bg-red-50 px-2 py-1 text-xs font-semibold text-red-600 shadow-sm hover:bg-red-100"
            >
                Delete Campaign
            </button>

            <!-- Panel -->
            <div
                x-ref="panel"
                x-show="open"
                x-transition.origin.top.right
                x-on:click.outside="close($refs.button)"
                :id="$id('dropdown-button')"
                style="display: none;"
                class="absolute right-0 mt-2 w-96 rounded-md border bg-white shadow-md text-center"
            >
                <p class="text-sm py-2">Are you sure you want to delete this campaign?</p>

                <div class="flex flex-row-reverse">
                    <button x-on:click="toggle()" class="flex justify-center items-center gap-2 w-full first-of-type:rounded-t-md last-of-type:rounded-b-md px-4 py-2.5 text-left text-sm hover:bg-gray-50 disabled:text-gray-500">
                        Cancel
                    </button>

                    <button wire:click="deleteCampaign" class="flex justify-center items-center gap-2 w-full first-of-type:rounded-t-md last-of-type:rounded-b-md px-4 py-2.5 text-left text-sm hover:bg-gray-50 disabled:text-gray-500">
                        <span class="text-red-600">Delete</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
