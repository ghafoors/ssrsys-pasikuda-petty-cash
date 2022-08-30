@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">

            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Monthly Spending</h6>
                                <h3>LKR</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <canvas id="chart-orders" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Monthly Spending</h6>
                                <h3>USD</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <canvas id="chart-orders2" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script>
        var OrdersChart = (function() {

            //
            // Variables
            //

            var $chart = $('#chart-orders');
            var $chart2 = $('#chart-orders2');
            var $ordersSelect = $('[name="ordersSelect"]');


            //
            // Methods
            //

            // Init chart
            function initChart($chart) {

                // Create chart
                var ordersChart = new Chart($chart, {
                    type: 'bar',
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    callback: function(value) {
                                        if (!(value % 10)) {
                                            return '$' + value + 'k'
                                            // return value
                                        }
                                    }
                                }
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function(item, data) {
                                    var label = data.datasets[item.datasetIndex].label || '';
                                    var yLabel = item.yLabel;
                                    var content = '';

                                    if (data.datasets.length > 1) {
                                        content += '<span class="popover-body-label mr-auto">' + label + '</span>';
                                    }

                                    content += '<span class="popover-body-value">' + yLabel + '</span>';

                                    return content;
                                }
                            }
                        }
                    },
                    data: {
                        labels: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'Totals',
                            data: [25, 20, 30, 22, 17, 29]
                        }]
                    }
                });

                // Save to jQuery object
                $chart.data('chart', ordersChart);
            }


            // Init chart
            if ($chart.length) {
                initChart($chart);
                initChart($chart2);
            }

        })();
    </script>

@endpush
