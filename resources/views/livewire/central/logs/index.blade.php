<div class="space-y-5">
    <div>
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Logs</h1>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div>
                <div class="p-5 border border-gray-200 shadow-sm rounded-xl">
                    <x-table>
                        <x-slot name="head">
                            <x-table.heading></x-table.heading>
                            <x-table.heading>Type</x-table.heading>
                            <x-table.heading>Time</x-table.heading>
                            <x-table.heading>Model</x-table.heading>
                            <x-table.heading>User</x-table.heading>
                            <x-table.heading></x-table.heading>
                        </x-slot>
                        <x-slot name="body">
                            @forelse ($logs as $log)
                                <x-table.row>
                                    <x-table.cell>
                                        {{ $log->id }}
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span
                                            @if($log->event == 'created')
                                                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20"
                                            @elseif($log->event == 'updated')
                                                class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20"
                                            @elseif($log->event == 'deleted')
                                                class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10"
                                            @elseif($log->event == 'login')
                                                class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10"
                                            @endif
                                        >
                                            {{ $log->description }}
                                        </span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        {{ $log->created_at->diffForHumans() }}
                                    </x-table.cell>
                                    <x-table.cell>
                                        {{ $log->subject_type }}
                                    </x-table.cell>
                                    <x-table.cell>
                                        {{ $log->causer_id ?? '-' }}
                                    </x-table.cell>
                                    <x-table.cell>
{{--                                        <a href="{{ route('dealer.logs.show', $log) }}">View</a>--}}
                                    </x-table.cell>
                                </x-table.row>
                            @empty
                                <x-table.row>
                                    <x-table.cell colspan="2">
                                        No logs found.
                                    </x-table.cell>
                                </x-table.row>
                            @endforelse
                        </x-slot>
                    </x-table>
                </div>
                <div class="mt-5">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
