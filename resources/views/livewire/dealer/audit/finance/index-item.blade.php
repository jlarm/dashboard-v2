<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="p-4">
        <div class="flex justify-between items-start mb-4">
            <h3 class="text-lg font-semibold text-slate-800">
                {{ $this->quarter() }}
            </h3>
            <div x-data="{ openModal: false }" class="relative flex-none">
                <button
                    x-on:click="openModal = true"
                    type="button"
                    class="inline-flex items-center gap-x-1 rounded-md px-2 py-1 text-xs text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1"
                    aria-label="More options"
                >
                    <span>More</span>
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
                    </svg>
                </button>

                {{-- MODAL --}}
                <div
                    x-show="openModal"
                    style="display: none;" {{-- Ensure hidden initially to prevent flash of unstyled content --}}
                    x-on:keydown.escape.prevent.stop="openModal = false"
                    role="dialog"
                    aria-modal="true"
                    x-id="['modal-title']"
                    :aria-labelledby="$id('modal-title')"
                    class="fixed inset-0 z-50 overflow-y-auto"
                >
                    {{-- OVERLAY --}}
                    <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/30 backdrop-blur-sm"></div>

                    {{-- PANEL --}}
                    <div
                        x-show="openModal"
                        x-transition:enter="transition ease-out duration-200 transform"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150 transform"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        x-on:click.outside="openModal = false"
                        class="relative mx-auto mt-8 mb-8 flex w-full max-w-xl flex-col rounded-xl bg-white p-0 shadow-xl"
                    >
                        {{-- HEADER --}}
                        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                            <h2 class="text-lg font-semibold text-gray-900" :id="$id('modal-title')">
                                Audit Details & Actions
                            </h2>
                            <button type="button" x-on:click="openModal = false" class="-m-2 p-2 text-gray-400 hover:text-gray-500">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>

                        {{-- CONTENT --}}
                        <div class="space-y-4 p-6">
                            {{-- PROGRESS BAR & STATS --}}
                            <div class="space-y-3 rounded-lg border border-gray-200 p-4">
                                <h3 class="text-base font-medium text-gray-800">Summary</h3>
                                @if($this->remediationsActive())
                                <div>
                                    <div class="flex justify-between text-sm font-medium text-gray-700">
                                        <span>Remediation Progress</span>
                                        <span>{{ $this->remediationProgress() }}%</span>
                                    </div>
                                    <div class="mt-1 h-2.5 w-full rounded-full bg-gray-200">
                                        <div class="h-2.5 rounded-full bg-blue-600" style="width: {{ $this->remediationProgress() }}%"></div>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">{{ $this->glbaViolationAudit->remediation_count }} of {{ $this->glbaViolationAudit->violation_count }} remediated</p>
                                </div>
                                @endif
                                <div class="grid grid-cols-2 gap-x-4 gap-y-2 pt-2 text-sm">
                                    <div>
                                        <dt class="text-gray-500">Grade:</dt>
                                        <dd class="font-medium text-gray-800">{{ $glbaViolationAudit->grade ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-gray-500">Status:</dt>
                                        <dd @class(['font-medium', 'text-teal-600' => $glbaViolationAudit->completed_date, 'text-sky-600' => $glbaViolationAudit->completed_date === null])>
                                            {{ $glbaViolationAudit->completed_date ? 'Complete' : 'In Progress' }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-gray-500">Violations:</dt>
                                        <dd class="font-medium text-gray-800">{{ $glbaViolationAudit->violation_count }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-gray-500">Remediations:</dt>
                                        <dd class="font-medium text-gray-800">{{ $glbaViolationAudit->completed_date ? $glbaViolationAudit->remediation_count : '-' }}</dd>
                                    </div>
                                </div>
                            </div>

                            {{-- ACTION LINKS --}}
                            <div class="space-y-1 pt-2">
                                <h3 class="px-1 pt-2.5 pb-1.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</h3>
                                @can('create-audits')
                                    <a href="{{ tenant('locations') ? route('dealer.stores.audits.finance.edit', [$store, $glbaViolationAudit->uuid]) : route('dealer.audit.finance.edit', $glbaViolationAudit->uuid) }}" class="group flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" class="text-gray-400 group-hover:text-gray-500" fill="none">
                                            <path d="M15.5 5.5L18 3L21 6L18.5 8.5M15.5 5.5L9 12L8 16L12 15L18.5 8.5M15.5 5.5L18.5 8.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                            <path d="M11 5H3V21H19V13" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                        </svg>
                                        <span>Edit Audit</span>
                                    </a>
                                    <livewire:dealer.audit.finance.generate-button :glbaViolationAudit="$glbaViolationAudit" />
                                @endcan
                                @if($this->remediationsActive() && $glbaViolationAudit->completed_date)
                                    @can('view-audits')
                                        <a href="{{ tenant('locations') ? route('dealer.stores.audits.finance.remediation', [$store, $glbaViolationAudit->uuid]) : route('dealer.audit.finance.remediation', $glbaViolationAudit->uuid) }}" class="group flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" class="text-gray-400 group-hover:text-gray-500" fill="none">
                                                <path d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2Z" stroke="currentColor" stroke-width="1.5" />
                                                <path d="M13.7647 15.2353L16.5 12.5M16.5 12.5L13.7647 9.76471M16.5 12.5H7.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <span>Remediate Violations</span>
                                        </a>
                                    @endcan
                                @endif

                                @if($glbaViolationAudit->pdf_path)
                                <h3 class="px-1 pt-4 pb-1.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Downloads</h3>
                                @endif
                                @can('view-audits')
                                    @if($glbaViolationAudit->violation_pdf_path)
                                        <div class="px-1 py-1.5"><livewire:dealer.audit.finance.generate-button :glbaViolationAudit="$glbaViolationAudit" /></div>
                                    @endif
                                @endcan
                                @if($glbaViolationAudit->pdf_path)
                                    <button wire:click="download" class="group w-full flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" class="text-gray-400 group-hover:text-gray-500" fill="none">
                                            <path d="M4 15L4 18C4 19.1046 4.89543 20 6 20L18 20C19.1046 20 20 19.1046 20 18V15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M11 5H3V21H19V13" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                            <path d="M12 3L12 14M12 14L15.5 10.5M12 14L8.5 10.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>Download Audit PDF</span>
                                        <svg wire:loading wire:target="download" class="animate-spin ml-auto h-4 w-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </button>
                                @endif
                                @if($glbaViolationAudit->remediation_pdf_path)
                                    <livewire:dealer.audit.finance.generate-remediation-button :glbaViolationAudit="$glbaViolationAudit" />
                                @endif

                                @can('delete-audits')
                                    <div class="!my-3 border-t border-gray-200"></div>
                                    <div x-data="{ showConfirmation: false }">
                                        <!-- Initial Delete Button -->
                                        <button 
                                            x-show="!showConfirmation" 
                                            x-on:click="showConfirmation = true" 
                                            class="group w-full flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 hover:text-red-700"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" class="text-red-500 group-hover:text-red-600" fill="none">
                                                <path d="M19.5 5.5L18.5 22H5.5L4.5 5.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                                <path d="M2 5.5H8M22 5.5H16M16 5.5L14.5 2H9.5L8 5.5M16 5.5H8" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                                <path d="M9.5 16.5L9.5 10.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                                <path d="M14.5 16.5L14.5 10.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                            </svg>
                                            <span>Delete Audit</span>
                                        </button>
                                        
                                        <!-- Confirmation UI -->
                                        <div x-show="showConfirmation" class="p-2 bg-red-50 rounded-md">
                                            <p class="text-sm text-red-700 font-medium mb-3">Are you sure you want to delete this audit?</p>
                                            <div class="flex justify-end space-x-2">
                                                <button 
                                                    x-on:click="showConfirmation = false" 
                                                    class="px-3 py-1.5 text-xs font-medium rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50"
                                                >
                                                    Cancel
                                                </button>
                                                <button 
                                                    wire:click="delete" 
                                                    class="px-3 py-1.5 text-xs font-medium rounded-md bg-red-600 text-white hover:bg-red-700"
                                                >
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                            </div>
                        </div>

                        {{-- FOOTER --}}
                        <div class="flex flex-shrink-0 justify-end space-x-2 border-t border-gray-200 px-6 py-4">
                            <button
                                type="button"
                                x-on:click="openModal = false"
                                class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-1"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Section --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
            {{-- Grade --}}
            <div>
                <dt class="text-xs font-medium text-slate-500">Grade</dt>
                <dd class="mt-0.5 font-semibold text-slate-700 tracking-tight">{{ $glbaViolationAudit->grade ?? '-' }}</dd>
            </div>

            {{-- Status --}}
            <div>
                <dt class="text-xs font-medium text-slate-500">Status</dt>
                <dd class="mt-0.5">
                    <span @class([
                        'inline-flex items-center gap-x-1.5 py-0.5 px-2 rounded-md text-xs font-semibold',
                        'bg-emerald-100 text-emerald-700' => $glbaViolationAudit->completed_date,
                        'bg-sky-100 text-sky-700' => !$glbaViolationAudit->completed_date
                    ])>
                        {{ $glbaViolationAudit->completed_date ? 'Complete' : 'In Progress' }}
                    </span>
                </dd>
            </div>

            {{-- Total Violations --}}
            <div>
                <dt class="text-xs font-medium text-slate-500">Total Violations</dt>
                <dd class="mt-0.5 font-semibold text-slate-700 tracking-tight">{{ $glbaViolationAudit->violation_count }}</dd>
            </div>

            {{-- Total Remediations --}}
            @if($this->remediationsActive())
            <div>
                <dt class="text-xs font-medium text-slate-500">Total Remediations</dt>
                <dd class="mt-0.5 font-semibold text-slate-700 tracking-tight">{{ $glbaViolationAudit->completed_date ? $glbaViolationAudit->remediation_count : '-' }}</dd>
            </div>
            @endif
        </div>
    </div>
</div>
