<div>
    <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-base font-semibold text-gray-900">Upcoming Quarterly Audits</h2>
        <span @class([
            'inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium',
            'bg-red-50 text-red-700 ring-1 ring-red-200' => $daysRemaining <= 14,
            'bg-amber-50 text-amber-700 ring-1 ring-amber-200' => $daysRemaining > 14 && $daysRemaining <= 30,
            'bg-gray-50 text-gray-600 ring-1 ring-gray-200' => $daysRemaining > 30,
        ])>
            <svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            Q{{ now()->quarter }} ends {{ $quarterEnd->format('M j') }} &middot; {{ $daysRemaining }} {{ Str::plural('day', $daysRemaining) }} left
        </span>
    </div>

    @if($dealershipGroups->isEmpty())
        <div class="flex items-center gap-2 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
            All stores have completed their audits for this quarter.
        </div>
    @else
        <div class="overflow-x-auto -mx-4 px-4">
        <table class="w-full min-w-[520px] text-sm">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="pb-2 text-left text-xs font-medium text-gray-400"></th>
                    <th class="pb-2 w-24 text-center text-xs font-medium text-gray-400">OSHA</th>
                    <th class="pb-2 w-24 text-center text-xs font-medium text-gray-400">Body Shop</th>
                    <th class="pb-2 w-24 text-center text-xs font-medium text-gray-400">Finance</th>
                    <th class="pb-2 w-24 text-center text-xs font-medium text-gray-400">Deal Jacket</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dealershipGroups as $group)
                    @if(count($group['stores']) > 1)
                        <tr class="border-t-2 border-gray-200 bg-gray-50">
                            <td colspan="5" class="px-2 py-2">
                                @if($group['domain'])
                                    <a href="https://{{ $group['domain'] }}/dashboard" target="_blank" rel="noopener noreferrer"
                                       class="text-xs font-semibold text-arm-blue-700 hover:underline">
                                        {{ $group['name'] }}
                                    </a>
                                @else
                                    <span class="text-xs font-semibold text-gray-500">{{ $group['name'] }}</span>
                                @endif
                            </td>
                        </tr>
                        @foreach($group['stores'] as $store)
                            <tr class="border-t border-gray-100 hover:bg-gray-50/50">
                                <td class="py-2.5 pl-4">
                                    <span class="text-gray-700">{{ Str::title($store['name']) }}</span>
                                </td>
                                <td class="py-2.5 text-center">@include('livewire.central.upcoming-audits._status', ['missing' => $store['missing_osha']])</td>
                                <td class="py-2.5 text-center">@include('livewire.central.upcoming-audits._status', ['missing' => $store['missing_body_shop']])</td>
                                <td class="py-2.5 text-center">@include('livewire.central.upcoming-audits._status', ['missing' => $store['missing_finance']])</td>
                                <td class="py-2.5 text-center">@include('livewire.central.upcoming-audits._status', ['missing' => $store['missing_deal_jacket']])</td>
                            </tr>
                        @endforeach
                    @else
                        {{-- Single-store: render at group header level, no indent --}}
                        @foreach($group['stores'] as $store)
                            <tr class="border-t-2 border-gray-200 hover:bg-gray-50/50">
                                <td class="py-2.5">
                                    @if($group['domain'])
                                        <a href="https://{{ $group['domain'] }}/dashboard" target="_blank" rel="noopener noreferrer"
                                           class="text-sm font-medium text-gray-800 hover:text-arm-blue-700 hover:underline">{{ Str::title($store['name']) }}</a>
                                    @else
                                        <span class="text-sm font-medium text-gray-800">{{ Str::title($store['name']) }}</span>
                                    @endif
                                </td>
                                <td class="py-2.5 text-center">@include('livewire.central.upcoming-audits._status', ['missing' => $store['missing_osha']])</td>
                                <td class="py-2.5 text-center">@include('livewire.central.upcoming-audits._status', ['missing' => $store['missing_body_shop']])</td>
                                <td class="py-2.5 text-center">@include('livewire.central.upcoming-audits._status', ['missing' => $store['missing_finance']])</td>
                                <td class="py-2.5 text-center">@include('livewire.central.upcoming-audits._status', ['missing' => $store['missing_deal_jacket']])</td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            </tbody>
        </table>
        </div>
    @endif
</div>
