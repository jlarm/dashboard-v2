@php use Carbon\Carbon; @endphp
<div x-data="{ loading: true }" class="mb-10">
    <div class="w-full max-w-3xl mx-auto px-6">
        <div class="space-y-3 flex flex-col bg-white my-10">

            <!-- Progress -->
            <div>
                <!-- Header -->
                <div class="mb-3 flex flex-col md:flex-row justify-between items-center gap-3">
                    <span class="block text-xl font-semibold text-gray-800">
                       Remediating the GLBA Audit for {{ $glbaViolationAudit->date->format('F d, Y') }}
                    </span>
                </div>
                <!-- End Header -->
            </div>
            <!-- End Progress -->
        </div>
        <form class="space-y-2">
            @forelse($violations as $violation)
                <div class="space-y-5 border rounded-xl p-5 relative">
                    <div>
                        <p class="col-span-3 text-sm text-gray-600">{{ $violation->statement }}</p>
                        <div class="flex gap-2 mt-1">
                            @if($violation->violation_date)
                                <span class="flex-shrink-0 inline-flex items-center gap-x-1.5 rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-700">
                                    <svg  class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
                                  {{ $violation->violation_date->format('F d, Y') }}
                                </span>
                            @endif
                            @if($violation->risk)
                                <span class="flex-shrink-0 inline-flex items-center gap-x-1.5 rounded-md bg-red-100 px-2 py-1 text-xs font-medium text-red-700">
                                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                                  High Risk
                                </span>
                            @endif
                        </div>
                    </div>
                    <p class="italic text-sm">{{ $violation->comment }}</p>
                    <div class="flex gap-5">
                        @if($violation->getMedia('violation_files_0')->first())
                            <div x-show="loading" class="w-20 h-20 rounded-md bg-gray-400 animate-pulse"></div>
                            <img
                                wire:click="$emit('modal.open', 'dealer.audit.image-modal', @js(['filesId' => 0, 'violation' => $violation]))"
                                class="h-20 w-20 rounded-md hover:cursor-pointer"
                                src="{{ $violation->getMedia('violation_files_0')->first()->getTemporaryUrl(\Carbon\Carbon::now()->addMinutes(45), 'thumb') }}"
                                alt=""
                                x-on:load="loading = false"
                                x-show="!loading"
                            />
                        @endif
                        @if($violation->getMedia('violation_files_1')->first())
                            <div x-show="loading" class="w-20 h-20 rounded-md bg-gray-400 animate-pulse"></div>
                            <img
                                wire:click="$emit('modal.open', 'dealer.audit.image-modal', @js(['filesId' => 1, 'violation' => $violation]))"
                                class="h-20 w-20 rounded-md hover:cursor-pointer"
                                src="{{ $violation->getMedia('violation_files_1')->first()->getTemporaryUrl(\Carbon\Carbon::now()->addMinutes(45), 'thumb') }}"
                                alt=""
                                x-on:load="loading = false"
                                x-show="!loading"
                            />
                        @endif
                        @if($violation->getMedia('violation_files_2')->first())
                            <div x-show="loading" class="w-20 h-20 rounded-md bg-gray-400 animate-pulse"></div>
                            <img
                                wire:click="$emit('modal.open', 'dealer.audit.image-modal', @js(['filesId' => 2, 'violation' => $violation]))"
                                class="h-20 w-20 rounded-md hover:cursor-pointer"
                                src="{{ $violation->getMedia('violation_files_2')->first()->getTemporaryUrl(\Carbon\Carbon::now()->addMinutes(45), 'thumb') }}"
                                alt=""
                                x-on:load="loading = false"
                                x-show="!loading"
                            />
                        @endif
                    </div>
                    <div class="bg-gray-100 p-5 rounded-xl space-y-3">
                        <div>
                            <label for="violationRemediations.{{ $violation->id }}.comment" class="block text-sm leading-6 text-gray-500">Describe how the violation has been remediated</label>
                            <textarea wire:model.defer="violationRemediations.{{ $violation->id }}.comment" rows="4" name="violations.0" id="violations.0" class="block w-full rounded-lg border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
                        </div>
                        <div>
                            @if($violation->remediation && !$violation->remediation->getMedia('remediations')->isEmpty())
                                <div class="relative w-24 h-24">
                                    <div>
                                        <div x-show="loading" class="w-24 h-24 rounded-md bg-gray-400 animate-pulse"></div>
                                        <img
                                            src="{{ $violation->remediation->getFirstMedia('remediations')->getTemporaryUrl(Carbon::now()->addMinutes(45), 'thumb') }}"
                                            class="w-full h-24 object-cover rounded-md"
                                            alt=""
                                            x-on:load="loading = false"
                                            x-show="!loading"
                                        >
                                        <button x-show="!loading" wire:click="removeUploadedPhoto({{ $violation->id }})" type="button" class="absolute top-0.5 right-0.5 p-1 rounded-md bg-slate-200 bg-opacity-75 text-slate-600 hover:text-red-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @else
                                @if(isset($violationRemediations[$violation->id]['photo']) && $violationRemediations[$violation->id]['photo'])
                                    <div class="relative w-24 h-24">
                                        <img src="{{ $violationRemediations[$violation->id]['photo']->temporaryUrl() }}" alt="Temporary Image" class="w-full h-full object-cover rounded-md">
                                        <button wire:click="removeTemporaryPhoto({{ $violation->id }})" type="button" class="absolute top-0.5 right-0.5 p-1 rounded-md bg-slate-200 bg-opacity-75 text-slate-600 hover:text-red-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @else
                                    <label for="violationRemediations.{{ $violation->id }}.photo" class="w-full block bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 hover:border-gray-400 p-6 text-center hover:cursor-pointer">
                                        <span wire:loading.remove class="text-sm text-gray-600">Upload Image</span>
                                        <x-loading-icon wire:loading wire:target="violationRemediations.{{ $violation->id }}.photo" />
                                        <input type="file" accept="image/jpeg" class="hidden" id="violationRemediations.{{ $violation->id }}.photo" wire:model="violationRemediations.{{ $violation->id }}.photo">
                                    </label>
                                @endif
                            @endif
                        </div>
                        @if($violation->remediation)
                            <p class="text-xs text-gray-400">Last Edited: {{ $violation->remediation->updated_at?->format('m-d-Y') }} 
                                @if ($violation->remediation->user)
                                    by {{ $violation->remediation->user->name }}
                                @endif
                            </p>
                        @endif
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="p-5 min-h-96 flex flex-col justify-center items-center text-center border rounded-md">
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
                            No Violations
                        </p>
                        <p class="mb-5 text-sm text-gray-500">
                            This audit is still in progress.
                        </p>
                    </div>
                </div>
                <!-- End Empty State -->
            @endforelse
        </form>
        <div class="flex gap-2 items-center mt-5">
            <x-primary-button wire:click.prevent="editRemediations" wire:loading.attr="disabled" wire:loading.class="opacity-50">Update</x-primary-button>
            <x-loading-icon wire:loading wire:target="editRemediations, removeUploadedPhoto"/>
            <div class="ml-auto flex gap-2">
                @can('create-stores')
                    <button
                        class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        wire:click="$emit('modal.open', 'dealer.audit.finance.complete-remediation-modal',  @js(['glbaViolationAudit' => $glbaViolationAudit->id]))"
                    >
                        Generate PDF
                    </button>
                @endcan
                <x-button.secondary href="{{ tenant('locations') ? route('dealer.stores.audits.finance.index', $store) : route('dealer.audit.finance.index') }}">Cancel</x-button.secondary>
            </div>
        </div>
    </div>
</div>
