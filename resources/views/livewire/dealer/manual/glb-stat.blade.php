<div
    class="bg-gray-50 border border-gray-300 overflow-hidden sm:rounded-lg @if($manual && \Carbon\Carbon::now() > $manual->assessment_date->addYear() ) border-b-4 border-b-amber-400 @endif">
    <div class="p-6 text-gray-900">
        <h2 class="text-2xl font-bold mb-5">GLB ISP</h2>
        <div class="flow-root">
            <ul role="list" class="-my-5 divide-y divide-gray-200">
                @if($manual)
                    <livewire:dealer.manual.glb-stat-single :manual="$manual" :key="$manual->id"/>
                @else
                    <li class="py-4">
                        <a href="{{ route('dealer.manual.glbform') }}"
                           class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">
                            Start
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
