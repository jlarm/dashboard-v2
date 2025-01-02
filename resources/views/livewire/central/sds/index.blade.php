<div class="bg-white rounded-md p-6 flex flex-col space-y-5">
    <div>
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">SDS Sheets</h1>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none flex gap-3">
                @can('delete-users')
                    <a href="{{ route('sds.create') }}" class="block rounded-md bg-arm-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">Add SDS Sheet</a>
                @endcan
            </div>
        </div>
        <div class="flex justify-start mt-3">
            <div>
                <!-- Search Input -->
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-3.5">
                        <svg class="flex-shrink-0 size-4 text-stone-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                    </div>
                    <input wire:model="search" type="search" class="py-[7px] px-3 ps-10 block w-full min-w-[300px] bg-stone-100 border-transparent rounded-lg text-sm placeholder:text-stone-500 focus:border-arm-blue-500 focus:ring-arm-blue-600 disabled:opacity-50 disabled:pointer-events-none" placeholder="Search">
                </div>
                <!-- End Search Input -->
            </div>
        </div>
        <div class="mt-8">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 col-span-2">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <x-table>
                        <x-slot name="head">
                            <x-table.heading class="w-2/12">Name</x-table.heading>
                            <x-table.heading class="w-2/12"></x-table.heading>
                        </x-slot>
                        <x-slot name="body">
                            @forelse ($sheets as $sheet)
                                <livewire:central.sds.index-item :sheet="$sheet" :key="$sheet->id" />
                            @empty
                                <x-table.row>
                                    <x-table.cell colspan="4">
                                        <!-- Empty State -->
                                        <div class="p-5 min-h-96 flex flex-col justify-center items-center text-center">
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
                                                    No SDS Sheets
                                                </p>
                                            </div>
                                        </div>
                                        <!-- End Empty State -->
                                    </x-table.cell>
                                </x-table.row>
                            @endforelse
                        </x-slot>
                    </x-table>
                    <div class="py-5">
                        {{ $sheets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
