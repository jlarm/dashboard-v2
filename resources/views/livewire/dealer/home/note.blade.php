<form wire:submit.prevent="update" class="relative">
    <textarea
        x-data
        x-autosize
        wire:model.defer="note"
        id="hs-textarea-ex-2"
        class="p-4 pb-12 block w-full bg-gray-100 border-gray-200 rounded-lg text-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
        placeholder="Notes...">
    </textarea>

    <!-- Toolbar -->
    <div class="absolute bottom-px inset-x-px p-2 rounded-b-md bg-gray-100 dark:bg-neutral-800">
        <div class="flex justify-between items-center">
            <!-- Button Group -->
            <div class="flex items-center"></div>
            <!-- End Button Group -->

            <!-- Button Group -->
            <div class="flex items-center gap-x-1">
                <!-- Send Button -->
                <button class="inline-flex flex-shrink-0 justify-center items-center size-8 rounded-lg text-white bg-arm-blue-600 hover:bg-arm-blue-500 focus:z-10 focus:outline-none focus:ring-2 focus:ring-arm-blue-500">
                    <svg class="flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.5303 3.46967C17.2375 3.17678 16.7626 3.17678 16.4697 3.46967L14.0005 5.93886L18.0612 9.99952L20.5303 7.53033C20.8232 7.23744 20.8232 6.76256 20.5303 6.46967L17.5303 3.46967ZM17.0005 11.0602L12.9398 6.99952L4.46969 15.4697C4.37357 15.5658 4.30538 15.6862 4.27241 15.8181L3.27241 19.8181C3.20851 20.0737 3.2834 20.344 3.46969 20.5303C3.65597 20.7166 3.92634 20.7915 4.18192 20.7276L8.18192 19.7276C8.31379 19.6946 8.43423 19.6264 8.53035 19.5303L17.0005 11.0602Z" fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18 20.75H11V18.75H18V20.75Z" fill="currentColor" />
                    </svg>
                </button>
                <!-- End Send Button -->
            </div>
            <!-- End Button Group -->
        </div>
    </div>
    <!-- End Toolbar -->
</form>
