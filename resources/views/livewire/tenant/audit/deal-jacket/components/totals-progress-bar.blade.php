<div class="bg-white shadow-sm border rounded-lg p-6">
    <div>
        <h3 class="text-lg font-medium text-gray-900">Totals</h3>
    </div>
    <div id="gaugeChart-{{ $this->getId() }}"></div>
    <div class="flex justify-evenly items-center">
        <div class="flex items-center gap-2">
            <span class="shrink-0  size-2 inline-block bg-red-500 rounded-full"></span>
            <span class="block text-sm text-gray-800">{{ $totalHighRisk }} High Risk</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="shrink-0  size-2 inline-block bg-yellow-500 rounded-full"></span>
            <span class="block text-sm text-gray-800">{{ $totalFailed }} Failed</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="shrink-0  size-2 inline-block bg-green-500 rounded-full"></span>
            <span class="block text-sm text-gray-800">{{ $totalPassed }} Passed</span>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        (function() {
            let chart = null;
            const componentId = '{{ $this->getId() }}';
            const chartElementId = 'gaugeChart-' + componentId;

            function initChart() {
                const chartElement = document.querySelector('#' + chartElementId);

                if (!chartElement || typeof ApexCharts === 'undefined') {
                    return;
                }

                const options = {
                    chart: {
                        type: 'donut',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        pie: {
                            startAngle: -90,
                            endAngle: 90,
                            donut: {
                                size: "75%",
                            },
                            dataLabels: {
                                show: false
                            }
                        }
                    },
                    series: [{{ $totalHighRisk }}, {{ $totalFailed }}, {{ $totalPassed }}],
                    colors: ['#ef4444', '#fbbf24', '#a3e635'],
                    labels: ['High Risk', 'Failed', 'Passed'],
                    legend: {
                        show: false
                    },
                    stroke: {
                        lineCap: 'round',
                        width: 2,
                        colors: ['#fff']
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    states: {
                        hover: {
                            filter: {
                                type: "none"
                            },
                        },
                    },
                    grid: {
                        padding: {
                            top: 20,
                            bottom: -140,
                        }
                    },
                    tooltip: {
                        enabled: true,
                        fillSeriesColor: false,
                        theme: 'light',
                        y: {
                            formatter: function(value) {
                                return value;
                            }
                        }
                    }
                };

                if (chart) {
                    chart.updateSeries([{{ $totalHighRisk }}, {{ $totalFailed }}, {{ $totalPassed }}]);
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
    </script>
@endpush
