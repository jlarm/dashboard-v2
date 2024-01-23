<div>
    <div id="{{ $formattedName}}"></div>
    <p>{{ $name }}</p>
    <script>
        var options = {
            series: [{{ $percentage }}],
            chart: {
                type: 'radialBar',
                offsetY: -20,
                sparkline: {
                    enabled: true
                }
            },
            plotOptions: {
                radialBar: {
                    startAngle: -90,
                    endAngle: 90,
                    track: {
                        background: "#e7e7e7",
                        strokeWidth: '97%',
                        margin: 5, // margin is in pixels
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
                            offsetY: -2,
                            fontSize: '22px'
                        }
                    }
                }
            },
            grid: {
                padding: {
                    top: -10
                }
            },
            fill: {
                type: 'solid',
                colors: ['#34a7b1'],
            },
            labels: ['{{ $name }}'],
        };

        var chart = new ApexCharts(document.querySelector("#{{ $formattedName }}"), options);
        chart.render();
    </script>
</div>
