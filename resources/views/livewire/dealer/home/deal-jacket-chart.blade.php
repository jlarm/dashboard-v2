<div class="z-40">
    <span id="chart"></span>
    <script>
        var options = {
            chart: {
                id: 'spark1',
                group: 'sparks',
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
                data: [25, 66, 41, 59, 25, 44, 12, 36, 9, 21]
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
            tooltip: {
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function formatter(val) {
                            return '';
                        }
                    }
                }
            }
        }

        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();
    </script>
</div>
