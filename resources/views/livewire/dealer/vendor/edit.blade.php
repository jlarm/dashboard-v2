<x-wire-elements-pro::tailwind.slide-over on-submit="send" :content-padding="false">
    <x-slot name="title">
        {{ ucwords(strtolower($vendor->name)) }}
        @if(tenant('locations'))
            <p class="text-sm text-gray-500 font-normal"> {{ $vendor->store->name ?? 'All Stores' }}</p>
        @endif
    </x-slot>

    <div class="flex flex-col h-full">
        <div class="border-t border-gray-200 p-3 flex-1 overflow-y-auto">
            <div class="mb-10 bg-gray-100 p-4 rounded-xl">
                <p class="text-sm font-bold text-gray-700 mb-2">Send new request</p>
                <form>
                    <div class="flex flex-col gap-2">
                        <div>
                            <input wire:model.defer="name" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-arm-blue-500 focus:ring-arm-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Name">
                            @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="flex gap-2">
                            <div class="w-full">
                                <input wire:model.defer="email" type="email" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-arm-blue-500 focus:ring-arm-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Email Address">
                                @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <button type="submit" class="self-start py-2 px-3 inline-flex justify-center items-center gap-x-2 text-start bg-arm-blue-600 border border-arm-blue-600 text-white text-xs font-medium rounded-lg shadow-sm align-middle hover:bg-arm-blue-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:ring-1 focus:ring-arm-blue-300">
                                Send
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="flex items-center justify-between text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">
                <span>Contact Details</span>
                <span>Latest Activity</span>
            </div>

            <div class="divide-y divide-gray-200" x-data="{ openForm: null }">
                @foreach($forms as $form)
                    <div class="relative py-4 first:pt-0 last:pb-0">
                        <div
                            x-on:click="openForm = openForm === {{ $form->id }} ? null : {{ $form->id }}"
                            class="flex items-center justify-between cursor-pointer group hover:bg-gray-50 -mx-2 px-2 py-2 rounded-lg transition"
                        >
                            <div class="flex items-start gap-3">
                                <div class="mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :class="{ 'rotate-90': openForm === {{ $form->id }} }" class="lucide lucide-chevron-right h-4 w-4 text-gray-400 group-hover:text-arm-blue-600" aria-hidden="true"><path d="m9 18 6-6-6-6"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900 leading-none">{{ $form->name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $form->email }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end">
                                <p class="text-xs font-bold text-gray-900">{{ $form->created_at->format('M d, Y') }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded uppercase {{ $form->signature || $form->document_path ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">{{ $form->signature || $form->document_path ? 'Completed' : 'Pending' }}</span>
                                </div>
                            </div>
                        </div>
                        <div
                            x-show="openForm === {{ $form->id }}"
                            x-cloak
                            class="max-h-[250px] overflow-y-auto mt-4 ml-7 pl-4 border-l-2 border-arm-blue-100 space-y-4 pb-2"
                        >
                                <div class="flex items-center gap-2 px-1"><div class="h-[1px] flex-1 bg-gray-100"></div><span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Communication History</span><div class="h-[1px] flex-1 bg-gray-100"></div></div>
                            <div class="divide-y divide-gray-200">
                                @forelse($form->emailLogs as $log)
                                    <div class="py-3 first:pt-0 last:pb-0">
                                    <div class="bg-gray-50 border border-gray-100 rounded-lg p-3 relative hover:border-gray-200 transition">
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock h-3.5 w-3.5 text-blue-500" aria-hidden="true"><path d="M12 6v6l4 2"></path><circle cx="12" cy="12" r="10"></circle></svg>
                                                <span class="text-[10px] font-bold text-gray-500 tracking-tight">Reminder Sent</span>
                                            </div>
                                            <span class="text-[10px] tabular-nums font-medium text-gray-400">{{ $log->sent_at->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex items-center justify-between mt-1">
                                        <span class="text-[9px] px-1.5 py-0.5 rounded border font-bold uppercase" :class="{
                                            'bg-green-100 text-green-700 border-green-200': '{{ $log->event_type }}' === 'accepted',
                                            'bg-blue-100 text-blue-700 border-blue-200': '{{ $log->event_type }}' === 'delivered',
                                            'bg-indigo-100 text-indigo-700 border-indigo-200': '{{ $log->event_type }}' === 'opened',
                                            'bg-purple-100 text-purple-700 border-purple-200': '{{ $log->event_type }}' === 'clicked',
                                            'bg-red-100 text-red-700 border-red-200': '{{ $log->event_type }}' === 'complained' || '{{ $log->event_type }}' === 'permanent_fail',
                                            'bg-gray-100 text-gray-700 border-gray-200': !['accepted', 'delivered', 'opened', 'clicked', 'complained', 'permanent_fail'].includes('{{ $log->event_type }}')
                                        }">{{ $log->event_type }}</span>
                                            <div class="flex items-center gap-1 text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info h-3 w-3" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                                                <span class="text-[11px] italic leading-tight max-w-[180px] text-right">{{ $log->delivery_message }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                @empty
                                    <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl p-6 text-center animate-in fade-in duration-500">
                                        <p class="text-xs font-bold text-gray-600 mb-1">No history</p>
                                        <p class="text-[10px] text-gray-400 leading-relaxed mb-4 px-2">No automated reminders have been sent to this contact yet. The system will send a reminder every 30 days until the user has completed the form.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        @if($form->signature || $form->document_path)
                            <div class="mt-3">
                                <livewire:dealer.vendor.download :vendorForm="$form" :key="$form->id" />
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            @if($vendor->created_at < \Carbon\Carbon::create(2024, 06, 23, 0, 0, 0))
                <div class="relative p-2 hover:bg-gray-50 rounded-lg transition">
                    <div class="flex items-start justify-between cursor-pointer group">
                        <div class="flex items-start gap-3">
                            <div>
                                <p class="text-sm font-bold text-gray-900 leading-none">{{ $vendor->contact_name }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ Str::lower($vendor->contact_email) }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <p class="text-xs font-bold text-gray-900">{{ $vendor->created_at->format('M d, Y') }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded uppercase {{ $vendor->signature ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">{{ $vendor->signature ? 'Completed' : 'Pending' }}</span>
                            </div>
                        </div>
                    </div>
                    @if($vendor->signature)
                    <div class="mt-3">
                        <livewire:dealer.vendor.old-download :vendor="$vendor" />
                    </div>
                    @endif
                </div>
            @endif
        </div>
        <!-- End List Group -->

        <div class="border-t border-gray-200 p-3 mt-auto">
            <button
                type="button"
                wire:click="$emit('modal.open', 'dealer.vendor.delete', {{ json_encode(['vendor' => $vendor->id]) }})"
                class="w-full py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-red-600 text-red-600 hover:bg-red-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:ring-1 focus:ring-red-300"
            >
                Delete
            </button>
        </div>
    </div>
</x-wire-elements-pro::tailwind.slide-over>
