<div>
    <div class="px-6 py-5 sm:flex sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">Osha Audits</h1>
        </div>
        <div class="mt-4 flex sm:mt-0 sm:ml-4">
            @can('create-audits')
                <a
                    class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    href="{{ route('dealer.audit.osha.create', $store) }}"
                >
                    Create Audit
                </a>
            @endcan
        </div>
    </div>

    <div class="p-6">
        <div class="w-full bg-white">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4">
                @foreach($audits as $oshaAudit)
                    <livewire:dealer.audit.osha.index-item :store="$store" :oshaAudit="$oshaAudit" :key="$oshaAudit->id"/>
                @endforeach
                @foreach($oshaAudits as $audit)
                    <livewire:dealer.audit.osha.old-audit-index :oshaAudit="$audit" :key="$audit->id"/>
                @endforeach
                @if(!$audits->count() && !$oshaAudits->count())
                    <!-- Empty State -->
                    <div class="col-span-full p-5 min-h-96 flex flex-col justify-center items-center text-center">
                        <svg class="w-48 mx-auto mb-4" width="178" height="90" viewBox="0 0 178 90" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="27" y="50.5" width="124" height="39" rx="7.5" fill="currentColor" class="fill-white dark:fill-neutral-800"/>
                            <rect x="27" y="50.5" width="124" height="39" rx="7.5" stroke="currentColor" class="stroke-gray-50 dark:stroke-neutral-700/10"/>
                            <rect x="34.5" y="58" width="24" height="24" rx="4" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30"/>
                            <rect x="66.5" y="61" width="60" height="6" rx="3" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30"/>
                            <rect x="66.5" y="73" width="77" height="6" rx="3" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30"/>
                            <rect x="19.5" y="28.5" width="139" height="39" rx="7.5" fill="currentColor" class="fill-white dark:fill-neutral-800"/>
                            <rect x="19.5" y="28.5" width="139" height="39" rx="7.5" stroke="currentColor" class="stroke-gray-100 dark:stroke-neutral-700/30"/>
                            <rect x="27" y="36" width="24" height="24" rx="4" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70"/>
                            <rect x="59" y="39" width="60" height="6" rx="3" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70"/>
                            <rect x="59" y="51" width="92" height="6" rx="3" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70"/>
                            <g filter="url(#filter19)">
                                <rect x="12" y="6" width="154" height="40" rx="8" fill="currentColor" class="fill-white dark:fill-neutral-800" shape-rendering="crispEdges"/>
                                <rect x="12.5" y="6.5" width="153" height="39" rx="7.5" stroke="currentColor" class="stroke-gray-100 dark:stroke-neutral-700/60" shape-rendering="crispEdges"/>
                                <rect x="20" y="14" width="24" height="24" rx="4" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700 "/>
                                <rect x="52" y="17" width="60" height="6" rx="3" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700"/>
                                <rect x="52" y="29" width="106" height="6" rx="3" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700"/>
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
                            <p class="mt-2 font-medium text-gray-800 dark:text-neutral-200">
                                No audits
                            </p>
                            <p class="mb-5 text-sm text-gray-500 dark:text-neutral-500">
                                Check back later for new audits
                            </p>
                        </div>
                    </div>
                    <!-- End Empty State -->
                @endif
            </div>
        </div>
    </div>
</div>
