<div class="space-y-5">
    <div class="grid grid-cols-2 gap-5">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Documents</h1>
        </div>
        <div class="flex justify-end space-x-5">
            @role('super-admin')
            <x-primary-link-button href="{{ route('docs.create') }}">Upload</x-primary-link-button>
            @endrole
            <div>
                <div>
                    <label for="search" class="sr-only">Search Documents</label>
                    <input type="search" name="search" id="search"
                           wire:model="search"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                           placeholder="Search Documents...">
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-x-5 gap-y-10 xl:gap-5">
        @forelse($docs as $doc)
            <livewire:central.docs.index-item :doc="$doc" :key="$doc->id" />
        @empty
            <!-- Empty State -->
            <div class="p-5 min-h-96 flex flex-col justify-center items-center text-center w-full col-span-4">
                <svg class="w-48 mx-auto mb-4" width="178" height="90" viewBox="0 0 178 90" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="27" y="50.5" width="124" height="39" rx="7.5" fill="currentColor" class="fill-white"/>
                    <rect x="27" y="50.5" width="124" height="39" rx="7.5" stroke="currentColor" class="stroke-gray-50"/>
                    <rect x="34.5" y="58" width="24" height="24" rx="4" fill="currentColor" class="fill-gray-50"/>
                    <rect x="66.5" y="61" width="60" height="6" rx="3" fill="currentColor" class="fill-gray-50"/>
                    <rect x="66.5" y="73" width="77" height="6" rx="3" fill="currentColor" class="fill-gray-50"/>
                    <rect x="19.5" y="28.5" width="139" height="39" rx="7.5" fill="currentColor" class="fill-white"/>
                    <rect x="19.5" y="28.5" width="139" height="39" rx="7.5" stroke="currentColor" class="stroke-gray-100"/>
                    <rect x="27" y="36" width="24" height="24" rx="4" fill="currentColor" class="fill-gray-100"/>
                    <rect x="59" y="39" width="60" height="6" rx="3" fill="currentColor" class="fill-gray-100"/>
                    <rect x="59" y="51" width="92" height="6" rx="3" fill="currentColor" class="fill-gray-100"/>
                    <g filter="url(#filter19)">
                        <rect x="12" y="6" width="154" height="40" rx="8" fill="currentColor" class="fill-white" shape-rendering="crispEdges"/>
                        <rect x="12.5" y="6.5" width="153" height="39" rx="7.5" stroke="currentColor" class="stroke-gray-100" shape-rendering="crispEdges"/>
                        <rect x="20" y="14" width="24" height="24" rx="4" fill="currentColor" class="fill-gray-200"/>
                        <rect x="52" y="17" width="60" height="6" rx="3" fill="currentColor" class="fill-gray-200"/>
                        <rect x="52" y="29" width="106" height="6" rx="3" fill="currentColor" class="fill-gray-200"/>
                    </g>
                    <defs>
                        <filter id="filter19" x="0" y="0" width="178" height="64" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                            <feOffset dy="6"/>
                            <feGaussianBlur stdDeviation="6"/>
                            <feComposite in2="hardAlpha" operator="out"/>
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0"/>
                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1187_14810"/>
                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1187_14810" result="shape"/>
                        </filter>
                    </defs>
                </svg>

                <div class="max-w-sm mx-auto">
                    <p class="mt-2 font-medium text-gray-800">
                        No documents
                    </p>
                </div>
            </div>
            <!-- End Empty State -->
        @endforelse
    </div>
    <div>
        {{ $docs->links() }}
    </div>
</div>
