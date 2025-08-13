<div x-data="{ showModal: false }" @open-log-modal.window="showModal = true" @close-log-modal.window="showModal = false">
    <x-slot name="header">
        <x-slot name="pageTitle">{{ __('Activity Logs') }}</x-slot>
    </x-slot>

    <div class="space-y-6">
        <x-table>
            <x-slot name="head">
                <x-table.heading>{{ __('ID') }}</x-table.heading>
                <x-table.heading>{{ __('Activity') }}</x-table.heading>
                <x-table.heading>{{ __('Date') }}</x-table.heading>
                <x-table.heading>{{ __('Model') }}</x-table.heading>
                <x-table.heading>{{ __('User') }}</x-table.heading>
                <x-table.heading></x-table.heading>
            </x-slot>
            <x-slot name="body">
                @forelse($logs as $log)
                    <x-table.row>
                        <x-table.cell class="font-mono text-sm">
                            #{{ $log->id }}
                        </x-table.cell>

                        <x-table.cell>
                            @php
                                $badgeClass = match($log->event) {
                                    'created' => 'bg-green-50 text-green-700 ring-green-600/20',
                                    'updated' => 'bg-yellow-50 text-yellow-800 ring-yellow-600/20',
                                    'deleted' => 'bg-red-50 text-red-700 ring-red-600/10',
                                    'login' => 'bg-blue-50 text-blue-700 ring-blue-700/10',
                                    default => 'bg-gray-50 text-gray-700 ring-gray-600/20'
                                };
                            @endphp
                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $badgeClass }}">
                                {{ $log->description }}
                            </span>
                        </x-table.cell>

                        <x-table.cell class="text-sm text-gray-600">
                            <time datetime="{{ $log->created_at->toISOString() }}" title="{{ $log->created_at->format('F j, Y \\a\\t g:i A') }}">
                                {{ $log->created_at->diffForHumans() }}
                            </time>
                        </x-table.cell>

                        <x-table.cell>
                            <code class="text-xs bg-gray-100 px-2 py-1 rounded">
                                {{ $log->subject_type ? class_basename($log->subject_type) : __('N/A') }}
                            </code>
                        </x-table.cell>

                        <x-table.cell>
                            @if($log->causer)
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center text-xs font-medium text-gray-700">
                                        {{ substr($log->causer->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm">{{ $log->causer->name }}</span>
                                </div>
                            @else
                                <span class="text-sm text-gray-500 italic">{{ __('System') }}</span>
                            @endif
                        </x-table.cell>

                        <x-table.cell class="flex justify-end">
                            <button
                                type="button"
                                wire:click="viewLogDetails({{ $log->id }})"
                                class="text-sm text-blue-600 hover:text-blue-900 hover:underline"
                            >
                                {{ __('View') }}
                            </button>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="6" class="text-center py-12">
                            <div class="text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('No activity logs') }}</h3>
                                <p class="mt-1 text-sm text-gray-500">{{ __('No activity has been recorded yet.') }}</p>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-table>

        @if($logs->hasPages())
            <div class="mt-6">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    {{-- Log Details Modal --}}
    <div x-show="showModal"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         x-cloak>
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            {{-- Background overlay --}}
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 transition-opacity"
                 @click="$wire.closeModal()">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            {{-- Modal content --}}
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">

                @if($selectedLog)
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ __('Log Details') }} #{{ $selectedLog->id }}
                            </h3>
                            <button @click="$wire.closeModal()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-4">
                            {{-- Activity Description --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ __('Activity') }}</label>
                                <div class="mt-1">
                                    @php
                                        $badgeClass = match($selectedLog->event) {
                                            'created' => 'bg-green-50 text-green-700 ring-green-600/20',
                                            'updated' => 'bg-yellow-50 text-yellow-800 ring-yellow-600/20',
                                            'deleted' => 'bg-red-50 text-red-700 ring-red-600/10',
                                            'login' => 'bg-blue-50 text-blue-700 ring-blue-700/10',
                                            default => 'bg-gray-50 text-gray-700 ring-gray-600/20'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-md px-2 py-1 text-sm font-medium ring-1 ring-inset {{ $badgeClass }}">
                                        {{ $selectedLog->description }}
                                    </span>
                                </div>
                            </div>

                            {{-- User --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ __('User') }}</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $selectedLog->causer?->name ?? __('System') }}
                                </p>
                            </div>

                            {{-- Date --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ __('Date & Time') }}</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $selectedLog->created_at->format('F j, Y \a\t g:i A') }}
                                    <span class="text-gray-500">({{ $selectedLog->created_at->diffForHumans() }})</span>
                                </p>
                            </div>

                            {{-- Model --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ __('Model') }}</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <code class="bg-gray-100 px-2 py-1 rounded text-xs">
                                        {{ $selectedLog->subject_type ? class_basename($selectedLog->subject_type) : __('N/A') }}
                                    </code>
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button @click="$wire.closeModal()"
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                {{ __('Close') }}
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

