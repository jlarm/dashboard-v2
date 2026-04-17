<div>
    <x-slot name="header">
        <x-slot name="pageTitle">
            {{ __('OSHA Audits') }}
        </x-slot>
        <x-slot name="actions">
            @can('create-audits')
                @if($store)
                <a
                    class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    href="{{ route('dealer.audit.osha.create', $store) }}"
                >
                    Create Audit
                </a>
                @endif
            @endcan
        </x-slot>
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @if(!empty($chartLabels) && !empty($chartGradesNumeric))
                <div class="bg-white shadow-sm border rounded-lg p-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Grades Over Time</h3>
                        <p class="text-xs text-gray-500">Historical audit grades</p>
                    </div>
                    <div class="relative h-64">
                        <div id="oshaGradeChart-{{ $this->id }}"></div>
                    </div>
                </div>
            @endif

            @if(!empty($chartLabels) && !empty($chartViolations))
                <div class="bg-white shadow-sm border rounded-lg p-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Violations & Remediations</h3>
                        <p class="text-xs text-gray-500">Total violations and completed remediations per audit</p>
                    </div>
                    <div class="relative h-64">
                        <div id="oshaViolationsChart-{{ $this->id }}"></div>
                    </div>
                </div>
            @endif
        </div>

        <div class="w-full bg-white">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4">
                @foreach($audits as $oshaAudit)
                    <livewire:dealer.audit.osha.index-item :oshaAudit="$oshaAudit" :key="$oshaAudit->id"/>
                @endforeach
                @foreach($oshaAudits as $audit)
                    <livewire:dealer.audit.osha.old-audit-index :oshaAudit="$audit" :key="$audit->id"/>
                @endforeach
                @if(!$audits->count() && !$oshaAudits->count())
                    <!-- Empty State -->
                    <div class="col-span-full p-5 min-h-96 flex flex-col justify-center items-center text-center">
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
                                <rect x="20" y="14" width="24" height="24" rx="4" fill="currentColor" class="fill-gray-200 "/>
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
                                No audits
                            </p>
                            <p class="mb-5 text-sm text-gray-500">
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

@push('scripts')
<script>
    (function() {
        let chart = null;
        const componentId = '{{ $this->id }}';
        const chartElementId = 'oshaGradeChart-' + componentId;
        const gradeLetters = @json($chartGradesLetters);

        function initChart() {
            const chartElement = document.querySelector('#' + chartElementId);

            if (!chartElement || typeof ApexCharts === 'undefined') {
                return;
            }

            const options = {
                chart: {
                    type: 'area',
                    height: 256,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                series: [{
                    name: 'Grade',
                    data: @json($chartGradesNumeric)
                }],
                xaxis: {
                    categories: @json($chartLabels),
                    labels: {
                        style: {
                            colors: '#6b7280',
                            fontSize: '12px'
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#6b7280',
                        },
                        formatter: function(value) {
                            const gradeMap = {4: 'A', 3: 'B', 2: 'C', 1: 'D', 0: 'F'};
                            return gradeMap[Math.round(value)] || '';
                        }
                    },
                    min: 0,
                    max: 4,
                    tickAmount: 4,
                    forceNiceScale: false
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3,
                    colors: ['#3b82f6']
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.2,
                        stops: [0, 90, 100]
                    }
                },
                colors: ['#3b82f6'],
                grid: {
                    borderColor: '#e5e7eb',
                    strokeDashArray: 4,
                    xaxis: {
                        lines: {
                            show: false
                        }
                    },
                    yaxis: {
                        lines: {
                            show: true
                        }
                    },
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 10
                    }
                },
                tooltip: {
                    enabled: true,
                    y: {
                        formatter: function(value, { seriesIndex, dataPointIndex, w }) {
                            return gradeLetters[dataPointIndex] || '';
                        }
                    }
                },
                legend: {
                    show: false
                },
                markers: {
                    size: 4,
                    colors: ['#3b82f6'],
                    strokeColors: '#fff',
                    strokeWidth: 2,
                    hover: {
                        size: 6
                    }
                }
            };

            if (chart) {
                chart.updateOptions({
                    series: [{
                        name: 'Grade',
                        data: @json($chartGradesNumeric)
                    }],
                    xaxis: {
                        categories: @json($chartLabels)
                    }
                });
            } else {
                chart = new ApexCharts(chartElement, options);
                chart.render();
            }
        }

        document.addEventListener('livewire:init', initChart);

        Livewire.hook('message.processed', (message, component) => {
            if (component.id === componentId) {
                initChart();
            }
        });
    })();

    // Violations and Remediations Chart
    (function() {
        let violationsChart = null;
        const componentId = '{{ $this->id }}';
        const chartElementId = 'oshaViolationsChart-' + componentId;

        function initViolationsChart() {
            const chartElement = document.querySelector('#' + chartElementId);

            if (!chartElement || typeof ApexCharts === 'undefined') {
                return;
            }

            const options = {
                chart: {
                    type: 'area',
                    height: 256,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                series: [{
                    name: 'Violations',
                    data: @json($chartViolations)
                }, {
                    name: 'Remediations',
                    data: @json($chartRemediations)
                }],
                xaxis: {
                    categories: @json($chartLabels),
                    labels: {
                        style: {
                            colors: '#6b7280',
                            fontSize: '12px'
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#6b7280',
                            fontSize: '12px'
                        }
                    },
                    min: 0
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3,
                    colors: ['#ef4444', '#10b981']
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.2,
                        stops: [0, 90, 100]
                    }
                },
                colors: ['#ef4444', '#10b981'],
                grid: {
                    borderColor: '#e5e7eb',
                    strokeDashArray: 4,
                    xaxis: {
                        lines: {
                            show: false
                        }
                    },
                    yaxis: {
                        lines: {
                            show: true
                        }
                    },
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 10
                    }
                },
                tooltip: {
                    enabled: true,
                    shared: true,
                    intersect: false
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                    labels: {
                        colors: '#6b7280'
                    }
                },
                markers: {
                    size: 4,
                    colors: ['#ef4444', '#10b981'],
                    strokeColors: '#fff',
                    strokeWidth: 2,
                    hover: {
                        size: 6
                    }
                }
            };

            if (violationsChart) {
                violationsChart.updateOptions({
                    series: [{
                        name: 'Violations',
                        data: @json($chartViolations)
                    }, {
                        name: 'Remediations',
                        data: @json($chartRemediations)
                    }],
                    xaxis: {
                        categories: @json($chartLabels)
                    }
                });
            } else {
                violationsChart = new ApexCharts(chartElement, options);
                violationsChart.render();
            }
        }

        document.addEventListener('livewire:init', initViolationsChart);

        Livewire.hook('message.processed', (message, component) => {
            if (component.id === componentId) {
                initViolationsChart();
            }
        });
    })();
</script>
@endpush
