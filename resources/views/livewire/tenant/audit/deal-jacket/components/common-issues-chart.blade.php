<div class="bg-white shadow-sm border rounded-lg p-6">
    <div class="mb-4">
        <h3 class="text-lg font-medium text-gray-900">Most Common Issues</h3>
        <p class="text-xs text-gray-500">Based on the last year</p>
    </div>
    <div class="relative h-64">
        <div id="commonIssuesChart-{{ $this->id }}"></div>
    </div>
</div>

@push('scripts')
<script>
    (function() {
        let chart = null;
        const componentId = '{{ $this->id }}';
        const chartElementId = 'commonIssuesChart-' + componentId;

        function initChart() {
            const chartElement = document.querySelector('#' + chartElementId);

            if (!chartElement || typeof ApexCharts === 'undefined') {
                return;
            }

            const options = {
                chart: {
                    type: 'bar',
                    height: 256,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: 'Occurrences',
                    data: @json($data)
                }],
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 6,
                        distributed: true,
                        dataLabels: {
                            position: 'top'
                        }
                    }
                },
                colors: ['#ef4444', '#fb923c', '#fbbf24', '#eab308', '#a3e635'],
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val;
                    },
                    offsetX: -12,
                    style: {
                        fontSize: '12px',
                        colors: ['#ffffff'],
                        fontWeight: 600
                    }
                },
                xaxis: {
                    categories: @json($labels),
                    labels: {
                        style: {
                            colors: '#6b7280',
                            fontSize: '11px'
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
                            fontSize: '11px'
                        }
                    }
                },
                grid: {
                    borderColor: '#e5e7eb',
                    strokeDashArray: 4,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    },
                    yaxis: {
                        lines: {
                            show: false
                        }
                    },
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0
                    }
                },
                tooltip: {
                    enabled: true,
                    y: {
                        formatter: function(value) {
                            return value + ' occurrences';
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
                        name: 'Occurrences',
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
