<div
    x-data="{ search: '', users: [], selectedUser: @entangle('selectedUser'), file: null }"
    @search-updated.window="users = $event.detail.users"
>
    <form wire:submit.prevent="save" class="space-y-5">
        <div
            x-data="{
                open: false,
                search: @entangle('search').defer,
                users: [],
                searching: false,
                userSelected: false
            }"
            @search-updated.window="
                users = $event.detail.users;
                searching = search.length >= 2;
                open = searching && users.length > 0;
            "
            class="relative w-full"
        >
            <div class="relative">
                <x-text-input
                    type="text"
                    x-model="search"
                    @input.debounce.300ms="
                        userSelected = false;
                        searching = search.length >= 2;
                        $wire.searchUsers();
                    "
                    @focus="
                        if (searching && users.length > 0) open = true;
                    "
                    @click.away="open = false"
                    placeholder="Search Employees"
                    class="w-full px-3 py-2 pr-10 mt-1 text-sm"
                />
                <button
                    type="button"
                    x-cloak
                    x-show="search.length > 0"
                    @click="
                        search = '';
                        users = [];
                        open = false;
                        searching = false;
                        userSelected = false;
                        $wire.searchUsers();
                    "
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mt-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            @error('selectedUser')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror

            <div
                x-cloak
                x-show="open || (searching && users.length === 0 && !userSelected)"
                class="absolute w-full bg-white border rounded-md mt-1 shadow-md max-h-40 overflow-y-auto"
            >

                <!-- Show list of users if they exist -->
                <template x-if="users.length > 0">
                    <div>
                        <template x-for="user in users" :key="user.id">
                            <div @click="
                                $wire.selectUser(user.id);
                                search = user.name;
                                open = false;
                                searching = false;
                                userSelected = true; // Prevent dropdown from appearing again
                            "
                                 class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm">
                                <span x-text="user.name"></span>
                            </div>
                        </template>
                    </div>
                </template>

                <!-- Show 'No results found' only if searching, no users exist, and no user was previously selected -->
                <template x-if="searching && users.length === 0 && !userSelected">
                    <div class="px-4 py-2 text-gray-500">
                        No results found
                    </div>
                </template>
            </div>
        </div>

        <div>
            <x-text-input wire:model="date" type="date" class="w-full px-3 py-2 mt-1 text-sm text-gray-500" required />
            @error('date')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block">
                <span class="sr-only">Choose file</span>
                <input
                    wire:model="file"
                    x-ref="fileInput"
                    accept="application/pdf"
                    @change="let file = $event.target.files[0];
                        if (file) {
                            if (file.type !== 'application/pdf') {
                                alert('Please select a PDF file');
                                $event.target.value = '';
                                return;
                            }
                            if (file.size > 2048 * 1024) {
                                alert('File size must be less than 2MB');
                                $event.target.value = '';
                                return;
                            }
                        }
                    "
                    @reset-file-input.window="$refs.fileInput.value = ''"
                    type="file"
                    class="block w-full text-sm text-gray-500
                        file:me-4 file:py-2 file:px-4
                        file:rounded-lg file:border-0
                        file:text-sm
                        file:bg-arm-gray-600 file:text-gray-600
                        hover:file:bg-arm-gray-700
                        file:disabled:opacity-50 file:disabled:pointer-events-none
                    ">
            </label>

            @error('file')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex items-center gap-x-3">
            <x-primary-button>
                Save
            </x-primary-button>
            <x-loading-icon wire:loading wire:target="save" class="text-arm-blue-500" />
        </div>
    </form>
</div>
