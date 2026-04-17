<div class="bg-white shadow-sm border rounded-lg p-6">
    <div class="mb-4">
        <h3 class="text-lg font-medium text-gray-900">Pass Rate Trend</h3>
        <p class="text-xs text-gray-500">Based on the previous 2 years</p>
    </div>
    <div class="relative h-64">
        <div id="passRateChart-{{ $this->id }}"></div>
    </div>
</div>

@push('scripts')
<script>
    (function() {
        let chart = null;
        const componentId = '{{ $this->id }}';
        const chartElementId = 'passRateChart-' + componentId;

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
                    name: 'Pass Rate',
                    data: @json($data)
                }],
                xaxis: {
                    categories: @json($labels),
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
                        },
                        formatter: function(value) {
                            return value.toFixed(0) + '%';
                        }
                    },
                    min: 0,
                    max: 100
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2,
                    colors: ['#3b82f6']
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.1,
                        stops: [0, 100]
                    },
                    colors: ['#3b82f6']
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
                        formatter: function(value) {
                            return value.toFixed(1) + '%';
                        }
                    }
                },
                legend: {
                    show: false
                }
            };

            if (chart) {
                chart.updateOptions({
                    series: [{
                        name: 'Pass Rate',
                        data: @json($data)
                    }],
                    xaxis: {
                        categories: @json($labels)
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
</script>
@endpush
