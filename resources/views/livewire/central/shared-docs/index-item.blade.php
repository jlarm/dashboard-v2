<div class="flex flex-col bg-white border border-gray-200 rounded-xl">
    <div class="relative group">

        <!-- More Dropdown -->
        <div class="absolute top-3 end-3">
            <div class="p-0.5 sm:p-1 inline-flex items-center bg-white border border-gray-200 rounded-lg">
                @if($sharedDocument->file_name)
{{--                    <livewire:central.docs.download :document="$sharedDocument"/>--}}
                    <div class="w-px h-5 mx-1 bg-gray-200"></div>
                @endif

                <!-- Button Icon -->
                @role('super-admin')
                <div class="hs-tooltip inline-block">
                    <button wire:click="$emit('modal.open', 'central.shared-docs.delete',  @js(['sharedDocument' => $sharedDocument->id]))" type="button" class="hs-tooltip-toggle size-[30px] inline-flex justify-center items-center gap-x-2 rounded-lg border border-transparent text-red-600 hover:bg-red-100  disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-red-100" data-hs-overlay="#hs-pro-dupfmdl">
                        <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>
                    </button>

                    <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 inline-block absolute invisible z-20 py-1.5 px-2.5 bg-gray-900 text-xs text-white rounded-lg" role="tooltip" data-popper-placement="bottom" style="position: fixed; inset: 0 auto auto 0; margin: 0; transform: translate3d(772px, 53px, 0px);">
                        Delete
                    </span>
                </div>
                @endrole
                <!-- End Button Icon -->
            </div>
        </div>
        <!-- End More Dropdown -->
    </div>

    <!-- Body -->
    <div class="p-3 flex items-center gap-x-3">
        <div class="grow truncate">
            <p class="block truncate text-sm font-semibold text-gray-800">
                {{ $sharedDocument->title }}
            </p>
            <p class="block truncate text-xs text-gray-500 font-mono">
                {{ Str::limit($this->fileName(), 55) }}
            </p>
        </div>
    </div>
</div>
