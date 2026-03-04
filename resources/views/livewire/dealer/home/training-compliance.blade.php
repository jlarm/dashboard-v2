<div>
    <div wire:init="loadStats">
        <x-dealer.card
            title="Training Compliance Snapshot"
            subtitle="Summary is scoped to the selected store, or all available stores in overview."
        >
            @if($readyToLoad)
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-5">
                    <div class="rounded-lg border border-red-200 bg-red-50 p-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-red-700">Overdue</p>
                        <p class="mt-1 text-xl font-semibold text-red-800">{{ $counts['overdue'] }}</p>
                        <p class="mt-1 text-[11px] text-red-700/80">Employees with at least one expired required course.</p>
                    </div>
                    <div class="rounded-lg border border-amber-200 bg-amber-50 p-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-amber-700">At Risk</p>
                        <p class="mt-1 text-xl font-semibold text-amber-800">{{ $counts['at_risk'] }}</p>
                        <p class="mt-1 text-[11px] text-amber-700/80">Employees missing required completions or expiring in 30 days.</p>
                    </div>
                    <div class="rounded-lg border border-green-200 bg-green-50 p-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-green-700">Compliant</p>
                        <p class="mt-1 text-xl font-semibold text-green-800">{{ $counts['compliant'] }}</p>
                        <p class="mt-1 text-[11px] text-green-700/80">Employees currently complete on all required courses.</p>
                    </div>
                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-700">Unassigned</p>
                        <p class="mt-1 text-xl font-semibold text-gray-800">{{ $counts['unassigned'] }}</p>
                        <p class="mt-1 text-[11px] text-gray-600">Employees with no required courses assigned.</p>
                    </div>
                    <div class="rounded-lg border border-gray-200 bg-white p-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Employees</p>
                        <p class="mt-1 text-xl font-semibold text-gray-900">{{ $counts['employees'] }}</p>
                        <p class="mt-1 text-[11px] text-gray-500">Total employees in your current store/filter scope.</p>
                    </div>
                </div>

                <div class="space-y-2 border-t border-gray-200 pt-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-800">Priority Alerts</h3>
                        <a href="{{ route('dealer.employees.index') }}" class="text-sm font-medium text-arm-blue-600 hover:text-arm-blue-500">
                            View Employees
                        </a>
                    </div>

                    @forelse($alerts as $alert)
                        <div class="flex flex-col gap-1 rounded-lg border border-gray-200 p-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $alert['user']->name }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $alert['valid_completed'] }} / {{ $alert['total_required'] }} current
                                    @if($alert['expired'] > 0)
                                        · {{ $alert['expired'] }} expired
                                    @endif
                                    @if($alert['expiring_soon'] > 0)
                                        · {{ $alert['expiring_soon'] }} expiring soon
                                    @endif
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $alert['status'] === 'overdue' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $alert['status_label'] }}
                                </span>
                                <a href="{{ route('dealer.employees.show', $alert['user']) }}" class="text-sm font-medium text-arm-blue-600 hover:text-arm-blue-500">
                                    View
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No training alerts right now.</p>
                    @endforelse
                </div>
            @else
                <div class="space-y-3">
                    @foreach(range(1, 4) as $skeleton)
                        <div class="h-14 animate-pulse rounded-lg bg-gray-100"></div>
                    @endforeach
                </div>
            @endif
        </x-dealer.card>
    </div>
</div>
