<div x-data="{
    removeViolation: function(index) {
        @this.call('deleteViolation', index)
    },
    listenForDeletion: function() {
        @this.on('violationsUpdated', violations => {
            violations.forEach((violation, index) => {
                if (!violation) {
                    this.$refs['violation' + index].remove();
                }
            });
        })
    }
}" x-init="listenForDeletion" class="max-w-2xl mx-auto my-6">
    <div>
        <p class="text-sm mb-5 px-5 md:px-0">
            <span class="inline-flex h-4 w-4 items-center justify-center rounded-full bg-red-500">
              <span class="text-sm font-bold leading-none text-white">!</span>
            </span>
            <span class="italic">Indicates a missing comment. All violations require a comment.</span>
        </p>
        <form wire:submit.prevent="edit" class="space-y-5 px-5 md:px-0 text-sm">
            {{-- Audit Date --}}
            <div>
                <label for="date" class="sr-only">Audit Date</label>
                <x-date-picker
                    wire:model.defer="date"
                    type="date"
                    name="date"
                    id="date"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                />
            </div>
            <div class="space-y-5" >
                @forelse($this->violations as $index => $s)
                    <div
                        wire:key="violation-{{ $s->id }}"
                        x-data="{ open: false }"
                        role="region"
                        class="relative rounded-md border bg-white"
                        id="{{ $index }}"
                    >
                        @if ($s->comment === null)
                            <div class="absolute -top-3 -left-3">
                                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-red-500">
                                  <span class="text-sm font-bold leading-none text-white">!</span>
                                </span>
                            </div>
                        @endif
                        <div
                            wire:key="header-{{ $s->id }}"
                            @click="open = !open"
                            class="bg-slate-50 border-b border-slate-200 px-3 md:px-4 py-5 flex items-center justify-between cursor-pointer"
                        >
                            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                {{ $s['statement'] }}
                            </h3>
                            <span x-cloak x-show="open" aria-hidden="true" class="ml-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                  <path d="M3.75 7.25a.75.75 0 0 0 0 1.5h8.5a.75.75 0 0 0 0-1.5h-8.5Z" />
                                </svg>
                            </span>
                            <span
                                x-show="!open"
                                aria-hidden="true"
                                class="ml-4"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                  <path d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
                                </svg>
                            </span>
                        </div>

                        <div
                            wire:key="content-{{ $s->id }}"
                            x-show="open"
                            x-cloak
                        >
                            <div class="mt-2 space-y-6 p-3">
                                {{-- Comment --}}
                                <div class="space-y-1">
                                    <label class="text-sm font-bold text-slate-700 uppercase tracking-tight">Comment <span class="text-red-500">*</span></label>
                                <textarea
                                    wire:model="violations.{{ $index }}.comment"
                                    rows="4"
                                    name="violations.{{ $index }}"
                                    id="violations.{{ $index }}"
                                    placeholder="Add comment"
                                    class="w-full h-32 px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none resize-none placeholder:text-slate-400"></textarea>
                                    @error('violations.' . $index . '.comment') <span class="text-sm text-red-500 mt-3">* A comment is required</span> @enderror
                                </div>

                                {{-- Date of Violation --}}
                                <div class="space-y-1">
                                    <label class="text-sm font-bold text-slate-700 uppercase tracking-tight">Date of Violation</label>
                                    <x-date-picker wire:model.defer="violations.{{ $index }}.violation_date" />
                                </div>

                                {{-- Impact Severity --}}
                                <div
                                    x-data="{ severity: $wire.violations[{{ $index }}]?.severity || null }"
                                    x-init="$watch('severity', value => $wire.set('violations.{{ $index }}.severity', value))"
                                    class="space-y-1"
                                >
                                    <div class="flex justify-between items-center">
                                        <label class="text-sm font-bold text-slate-700 uppercase tracking-tight">Impact Severity</label>
                                        <span
                                            x-show="severity"
                                            x-text="'LEVEL ' + severity"
                                            :class="{
                                                'bg-emerald-500': severity <= 3,
                                                'bg-amber-500': severity >= 4 && severity <= 5,
                                                'bg-orange-500': severity >= 6 && severity <= 7,
                                                'bg-red-500': severity >= 8
                                            }"
                                            class="px-2 py-0.5 rounded text-white text-xs font-black transition-colors"
                                        ></span>
                                    </div>
                                    <div class="grid grid-cols-10 gap-1 md:gap-2">
                                        @for ($level = 1; $level <= 10; $level++)
                                            <button
                                                type="button"
                                                @click="severity = {{ $level }}"
                                                :class="severity === {{ $level }}
                                                    ? '{{ $level <= 3 ? 'bg-emerald-500' : ($level <= 5 ? 'bg-amber-500' : ($level <= 7 ? 'bg-orange-500' : 'bg-red-500')) }} text-white shadow-lg scale-105 ring-2 ring-offset-2 ring-slate-400'
                                                    : 'bg-slate-100 text-slate-400 hover:bg-slate-200'"
                                                class="h-10 md:h-12 rounded-lg flex items-center justify-center text-xs md:text-sm font-bold transition-all"
                                            >{{ $level }}</button>
                                        @endfor
                                    </div>
                                    <div class="flex justify-between text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">
                                        <span>Negligible</span>
                                        <span>Critical</span>
                                    </div>
                                </div>

                                {{-- High Risk --}}
                                <div
                                    x-data="{ isRisk: @entangle('violations.' . $index . '.risk').defer }"
                                    @click="isRisk = !isRisk"
                                    :class="isRisk ? 'bg-red-50 border-red-200 shadow-[0_0_15px_-5px_rgba(239,68,68,0.3)]' : 'bg-gray-50 border-gray-200'"
                                    class="p-4 rounded-2xl border transition-all cursor-pointer flex items-center justify-between"
                                >
                                    <div class="flex items-center gap-4">
                                        <div
                                            :class="isRisk ? 'bg-red-500 text-white' : 'bg-gray-300 text-gray-500'"
                                            class="p-2 rounded-xl transition-colors"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert" aria-hidden="true"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"></path><path d="M12 9v4"></path><path d="M12 17h.01"></path></svg>
                                        </div>
                                        <div>
                                            <p :class="isRisk ? 'text-red-700' : 'text-gray-500'" class="font-bold text-sm transition-colors">Flag as High Risk</p>
                                        </div>
                                    </div>
                                    <div
                                        :class="isRisk ? 'bg-red-500' : 'bg-gray-300'"
                                        class="w-12 h-6 rounded-full relative transition-colors"
                                    >
                                        <div
                                            :class="isRisk ? 'translate-x-6' : 'translate-x-0'"
                                            class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full transition-transform"
                                        ></div>
                                    </div>
                                </div>

                                {{-- Images --}}
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                                    <div wire:key="violation-{{ $s->id }}-file-0">
                                        <label for="violationFiles.{{ $s['id'] }}.0" class="relative bg-white overflow-hidden cursor-pointer w-full h-[150px] text-gray-900/25 hover:text-gray-900/50 rounded-lg border border-dashed border-gray-900/25 flex justify-center items-center">
                                            @if(isset($violationFiles[$s['id']][0]))
                                                <img class="w-full h-[200px] object-cover" src="{{ $violationFiles[$s['id']][0]->temporaryUrl() }}" alt="Violation Image">
                                            @elseif($s->getMedia('violation_files_0')->first() !== null)
                                                <img class="w-full h-[200px] object-cover" src="{{ $s->getMedia('violation_files_0')->first()->getTemporaryUrl(\Carbon\Carbon::now()->addMinutes(45), 'thumb') }}" alt="Violation Image">
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16">--}}
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                                                </svg>
                                            @endif
                                            <input type="file" accept="image/jpeg,image/jpg" capture="environment" wire:model="violationFiles.{{ $s['id'] }}.0" id="violationFiles.{{ $s['id'] }}.0" class="sr-only">
                                        </label>
                                        @if($s->getMedia('violation_files_0')->first() !== null)
                                            <button wire:click="deletePhoto({{ $s['id'] }}, 0)">Clear</button>
                                        @endif
                                        @error("violationFiles.{$s['id']}.0") <p class="text-xs text-red-500 mt-1">Image needs to be a JPG and less than 5MB</p> @enderror
                                    </div>
                                       <div wire:key="violation-{{ $s->id }}-file-1">
                                           <label for="violationFiles.{{ $s['id'] }}.1" class="relative bg-white overflow-hidden cursor-pointer w-full h-[150px] text-gray-900/25 hover:text-gray-900/50 rounded-lg border border-dashed border-gray-900/25 flex justify-center items-center">
                                               @if(isset($violationFiles[$s['id']][1]))
                                                   <img class="w-full h-[200px] object-cover" src="{{ $violationFiles[$s['id']][1]->temporaryUrl() }}" alt="Violation Image">
                                               @elseif($s->getMedia('violation_files_1')->first() !== null)
                                                   <img class="w-full h-[200px] object-cover" src="{{ $s->getMedia('violation_files_1')->first()->getTemporaryUrl(\Carbon\Carbon::now()->addMinutes(45), 'thumb') }}" alt="Violation Image">
                                               @else
                                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16">--}}
                                                       <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                                       <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                                                   </svg>
                                               @endif
                                               <input type="file" accept="image/jpeg,image/jpg" capture="environment" wire:model="violationFiles.{{ $s['id'] }}.1" id="violationFiles.{{ $s['id'] }}.1" class="sr-only">
                                           </label>
                                           @if($s->getMedia('violation_files_1')->first() !== null)
                                               <button wire:click="deletePhoto({{ $s['id'] }}, 1)">Clear</button>
                                           @endif
                                           @error("violationFiles.{$s['id']}.1") <p class="text-xs text-red-500 mt-1">Image needs to be a JPG and less than 5MB</p> @enderror
                                       </div>
                                        <div wire:key="violation-{{ $s->id }}-file-2">
                                            <label for="violationFiles.{{ $s['id'] }}.2" class="relative bg-white overflow-hidden cursor-pointer w-full h-[150px] text-gray-900/25 hover:text-gray-900/50 rounded-lg border border-dashed border-gray-900/25 flex justify-center items-center">
                                                @if(isset($violationFiles[$s['id']][2]))
                                                    <img class="w-full h-[200px] object-cover" src="{{ $violationFiles[$s['id']][2]->temporaryUrl() }}" alt="Violation Image">
                                                @elseif($s->getMedia('violation_files_2')->first() !== null)
                                                    <img class="w-full h-[200px] object-cover" src="{{ $s->getMedia('violation_files_2')->first()->getTemporaryUrl(\Carbon\Carbon::now()->addMinutes(45), 'thumb') }}" alt="Violation Image">
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16">--}}
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                                                    </svg>
                                                @endif
                                                <input type="file" accept="image/jpeg,image/jpg" capture="environment" wire:model="violationFiles.{{ $s['id'] }}.2" id="violationFiles.{{ $s['id'] }}.2" class="sr-only">
                                            </label>
                                            @if($s->getMedia('violation_files_2')->first() !== null)
                                                <button wire:click="deletePhoto({{ $s['id'] }}, 2)">Clear</button>
                                            @endif
                                            @error("violationFiles.{$s['id']}.2") <p class="text-xs text-red-500 mt-1">Image needs to be a JPG and less than 5MB</p> @enderror
                                        </div>
                                </div>

                                {{-- Delete --}}
                                <div class="w-full flex justify-end">
                                    <x-danger-button wire:click.prevent="deleteViolation({{ $s['id'] }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none">
                                            <path d="M17 12H7" stroke="#ffffff" stroke-width="2" stroke-linejoin="round"/>
                                            <path d="M22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12Z" stroke="#ffffff" stroke-width="2" stroke-linejoin="round"/>
                                        </svg>
                                    </x-danger-button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <button
                        onclick="Livewire.emit('modal.open', 'dealer.audit.finance.modal', @js(['auditId' => $glbaViolationAudit->id, 'auditType' => get_class($glbaViolationAudit)]))"
                        type="button"
                        class="relative block w-full rounded-md border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2"
                    >
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="#9b9b9b" fill="none">
                            <path d="M9.14426 2.5H2.5V9.14426M14.8557 2.5H21.5V9.14426M14.8557 21.5H21.5V14.8557M9.14426 21.5H2.5V14.8557" stroke="currentColor" stroke-width="1.5" />
                            <path d="M15 15L17 17M16 11.5C16 9.01472 13.9853 7 11.5 7C9.01472 7 7 9.01472 7 11.5C7 13.9853 9.01472 16 11.5 16C13.9853 16 16 13.9853 16 11.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                        </svg>
                        <span class="mt-2 block text-sm font-semibold text-gray-900">Add a new violation</span>
                    </button>
                @endforelse
            </div>
            @if ($comments->count() > 0)
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                        Comments ({{ $comments->count() }})
                    </h3>

                    <div class="space-y-4">
                        @foreach($comments as $comment)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <!-- Comment Header -->
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-2">
                                        <div class="flex-shrink-0">
                                            <div class="h-8 w-8 bg-arm-blue-500 rounded-full flex items-center justify-center">
                                      <span class="text-sm font-medium text-white">
                                          {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                                      </span>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $comment->user->name ?? 'Unknown User' }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $comment->created_at->format('M d, Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    <livewire:dealer.audit.components.delete-comment-confirmation-modal :comment="$comment" :key="'delete-modal-' . $comment->id" />
                                </div>

                                <div class="flex justify-between items-center">
                                    <!-- Comment Content -->
                                    <div class="mb-3">
                                        <p class="text-sm text-gray-700 leading-relaxed">
                                            {{ $comment->comment }}
                                        </p>
                                    </div>

                                    <!-- Comment Image -->
                                    @if($comment->getFirstMedia('comments'))
                                        <div class="mt-3">
                                            <div class="inline-block">
                                                <img
                                                    src="{{ $comment->getFirstMedia('comments')->getTemporaryUrl(\Carbon\Carbon::now()->addHour(), 'thumb') }}"
                                                    alt="Comment attachment"
                                                    class="h-20 w-20 rounded-md object-cover cursor-pointer hover:opacity-75 transition-opacity border border-gray-300 shadow-sm"
                                                />
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="flex space-x-2 items-center justify-between">
                <div>
                    @if($hasInvalidViolations)
                        <x-primary-button
                            type="button"
                            class="inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest cursor-not-allowed opacity-75"
                            disabled
                        >Update</x-primary-button>
                    @else
                        <x-primary-button>Update</x-primary-button>
                    @endif
                    <x-button.secondary href="{{ tenant('locations') ? route('dealer.stores.audits.finance.index', $store) : route('dealer.audit.finance.index') }}">Exit</x-button.secondary>
                </div>
                <div>
                    <svg wire:loading.delay class="animate-spin -ml-1 mr-3 h-5 w-5 text-arm-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
            @if($errors->has('violations.*.comment'))
                <p class="text-sm text-red-500">All violations require a comment. Any violation with a red exclamation indicates a missing comment.</p>
            @endif
        </form>
    </div>
    <div class="fixed bottom-5 right-5">
        <button class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-arm-blue-500" onclick="Livewire.emit('modal.open', 'dealer.audit.finance.modal', @js(['auditId' => $glbaViolationAudit->id, 'auditType' => get_class($glbaViolationAudit)]))">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </button>
    </div>
</div>
