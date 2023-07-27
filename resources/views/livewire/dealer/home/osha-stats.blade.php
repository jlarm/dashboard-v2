<div>
    <a href="{{ route('dealer.audit.osha.index') }}"
       class="flex flex-col gap-y-4 bg-white rounded border hover:shadow-xl transition pt-10">
        <dt class="text-base leading-7 text-gray-600">OSHA Rating</dt>
        @if(count($audits) > 0)
            @if($rating >= 90)
                <dd class="order-first text-3xl font-semibold tracking-tight text-green-500 sm:text-5xl">A</dd>
            @elseif($rating >= 80)
                <dd class="order-first text-3xl font-semibold tracking-tight text-blue-500 sm:text-5xl">B</dd>
            @elseif($rating >= 70)
                <dd class="order-first text-3xl font-semibold tracking-tight text-yellow-500 sm:text-5xl">C</dd>
            @elseif($rating >= 60)
                <dd class="order-first text-3xl font-semibold tracking-tight text-orange-500 sm:text-5xl">D</dd>
            @else
                <dd class="order-first text-3xl font-semibold tracking-tight text-red-500 sm:text-5xl">F</dd>
            @endif
        @else
            <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">-
            </dd>
        @endif
        <span id="osha-chart"></span>
    </a>
    @if(count($audits) > 1)
        <script>
            var options = {
                chart: {
                    type: 'line',
                    height: 120,
                    sparkline: {
                        enabled: true
                    },
                    dropShadow: {
                        enabled: true,
                        top: 1,
                        left: 1,
                        blur: 2,
                        opacity: 0.2,
                    }
                },
                series: [{
                    name: 'Percentage',
                    data: {{ Js::from($audits) }}
                }],
                stroke: {
                    curve: 'smooth'
                },
                markers: {
                    size: 0
                },
                grid: {
                    padding: {
                        top: 20,
                        bottom: 10,
                    }
                },
                colors: ['#0083B0'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        gradientToColors: ['#00B4DB'],
                        shadeIntensity: 1,
                        type: 'horizontal',
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100, 100, 100]
                    },
                },
                xaxis: {
                    type: 'datetime',
                    categories: {{ Js::from($dates) }},
                    tickAmount: 10,
                    labels: {
                        formatter: function (value, timestamp, opts) {
                            return opts.dateFormatter(new Date(timestamp), 'MMM dd yyyy')
                        }
                    }
                },
                tooltip: {
                    x: {
                        type: 'datetime',
                    },
                },
            }

            var chart = new ApexCharts(document.querySelector("#osha-chart"), options);

            chart.render();
        </script>
    @endif
</div>
