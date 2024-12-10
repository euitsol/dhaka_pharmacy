@extends('admin.layouts.master', ['pageSlug' => 'dashboard'])
@section('title', 'Admin Dashboard')
@push('css')
    <style>
        .card-stats.card-round {
            border-radius: 10px;
        }

        .card-stats.card,
        .card-stats.card-light {
            border-radius: 10px;
            background-color: #fff;
            margin-bottom: 30px;
            -webkit-box-shadow: 2px 6px 15px 0 rgba(69, 65, 78, .1);
            -moz-box-shadow: 2px 6px 15px 0 rgba(69, 65, 78, .1);
            box-shadow: 2px 6px 15px 0 rgba(69, 65, 78, .1);
            border: 0;
        }

        .card-stats .card-body {
            padding: 15px !important;
        }

        .card-stats .col-icon {
            width: 65px;
            height: 65px;
            padding-left: 0;
            padding-right: 0;
            margin-left: 15px;
        }

        .card-stats .icon-big.icon-primary {
            background: #1572e8;
        }

        .card-stats .icon-big.icon-info {
            background: #48abf7;
        }

        .card-stats .icon-big.icon-success {
            background: #31ce36;
        }

        .card-stats .icon-big.icon-secondary {
            background: #6861ce;
        }

        .card-stats .icon-big.icon-black,
        .card-stats .icon-big.icon-danger,
        .card-stats .icon-big.icon-info,
        .card-stats .icon-big.icon-primary,
        .card-stats .icon-big.icon-secondary,
        .card-stats .icon-big.icon-success,
        .card-stats .icon-big.icon-warning {
            border-radius: 5px;
        }

        .card-stats .icon-big {
            width: 100%;
            height: 100%;
            font-size: 2.2em;
            min-height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-stats .icon-big i.fa,
        .card-stats .icon-big i.fab,
        .card-stats .icon-big i.fal,
        .card-stats .icon-big i.far,
        .card-stats .icon-big i.fas {
            font-size: .8em;
        }

        .card-stats .icon-big.icon-black i,
        .card-stats .icon-big.icon-danger i,
        .card-stats .icon-big.icon-info i,
        .card-stats .icon-big.icon-primary i,
        .card-stats .icon-big.icon-secondary i,
        .card-stats .icon-big.icon-success i,
        .card-stats .icon-big.icon-warning i {
            color: #fff !important;
        }

        .card-stats .col-stats {
            align-items: center;
            display: flex;
            padding-left: 15px;
        }

        .card-stats .card-category {
            margin-top: 0;
            font-size: 1rem;
            color: #8d9498;
            margin-bottom: 0;
            word-break: normal;
        }

        .card-stats p {
            line-height: 1.82;
        }

        .card-stats .card-title {
            margin: 0;
            color: #2a2f5b;
            font-size: 20px;
            font-weight: 600;
            line-height: 1.6;
        }


        .btn-primary.btn-simple.active {
            border-color: #344675 !important;
            background: #344675 !important;
        }

        .btn-primary.btn-simple.active:hover {
            background: #344675 !important;
        }

        .btn-primary.btn-simple {
            color: #344675;
            border-color: #344675 !important;
            background: transparent !important;
            transition: .4s;
        }

        .btn-primary.btn-simple:hover {
            color: #fff !important;
            border-color: #344675 !important;
            background: #344675 !important;
        }





        .select2-container {
            width: 200px !important;
        }

        .select2-container .select2-results .select2-results__options::-scrollbar-track {
            box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.9);
            border-radius: 10px;
            background-color: #344675;
        }

        .select2-container .select2-results .select2-results__options::-scrollbar {
            width: 6px;
            background-color: #F5F5F5;
        }

        .select2-container .select2-results .select2-results__options::-scrollbar-thumb {
            border-radius: 10px;
            background-color: #0093E9;
            background-image: linear-gradient(90deg,
                    transparent,
                    #0093E9 50%,
                    transparent,
                    transparent);
        }

        .select2-container .select2-results .select2-results__options::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.9);
            border-radius: 10px;
            background-color: #344675;
        }

        .select2-container .select2-results .select2-results__options::-webkit-scrollbar {
            width: 6px;
            background-color: #F5F5F5;
        }

        .select2-container .select2-results .select2-results__options::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-color: #0093E9;
            background-image: -webkit-linear-gradient(90deg,
                    transparent,
                    #0093E9 50%,
                    transparent,
                    transparent)
        }

        .select2-container .select2-selection--single,
        .select2-container .select2-selection--multiple {
            height: 30px !important;
            border-color: #344675 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            margin-top: -4px !important;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">{{ __('Visitors') }}</p>
                                <h4 class="card-title">1,294</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">{{ __('Customers') }}</p>
                                <h4 class="card-title">{{ number_format($customers) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fa-solid fa-kit-medical"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">{{ __('Pharmacies') }}</p>
                                <h4 class="card-title">{{ number_format($pharmacies) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                <i class="fa-solid fa-people-roof"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">{{ __('District Managers') }}</p>
                                <h4 class="card-title">{{ number_format($dms) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fa-solid fa-people-group"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">{{ __('Local Area Managers') }}</p>
                                <h4 class="card-title">{{ number_format($lams) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                <i class="fa-solid fa-person-biking"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">{{ __('Riders') }}</p>
                                <h4 class="card-title">{{ number_format($riders) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fa-solid fa-earth-americas"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">{{ __('Operational Areas') }}</p>
                                <h4 class="card-title">{{ number_format($opas) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                <i class="fa-solid fa-map-location-dot"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">{{ __('Operational Sub Areas') }}</p>
                                <h4 class="card-title">{{ number_format($opsas) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-chart">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-md-6 text-left col-12">
                            <h5 class="card-category">{{ __('Orders in ') }}</h5>
                            <select class="form-select month-select w-100" id="monthSelect" aria-label="Select Month">
                                <option value="1" {{ date('m') == 1 ? 'selected' : '' }}>{{ __('January') }}
                                </option>
                                <option value="2" {{ date('m') == 2 ? 'selected' : '' }}>{{ __('February') }}
                                </option>
                                <option value="3" {{ date('m') == 3 ? 'selected' : '' }}>{{ __('March') }}
                                </option>
                                <option value="4" {{ date('m') == 4 ? 'selected' : '' }}>{{ __('April') }}
                                </option>
                                <option value="5" {{ date('m') == 5 ? 'selected' : '' }}>{{ __('May') }}
                                </option>
                                <option value="6" {{ date('m') == 6 ? 'selected' : '' }}>{{ __('June') }}
                                </option>
                                <option value="7" {{ date('m') == 7 ? 'selected' : '' }}>{{ __('July') }}
                                </option>
                                <option value="8" {{ date('m') == 8 ? 'selected' : '' }}>{{ __('August') }}
                                </option>
                                <option value="9" {{ date('m') == 9 ? 'selected' : '' }}>{{ __('September') }}
                                </option>
                                <option value="10" {{ date('m') == 10 ? 'selected' : '' }}>{{ __('October') }}
                                </option>
                                <option value="11" {{ date('m') == 11 ? 'selected' : '' }}>{{ __('November') }}
                                </option>
                                <option value="12" {{ date('m') == 12 ? 'selected' : '' }}>{{ __('December') }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="btn-group btn-group-toggle float-md-right" data-toggle="buttons">
                                <label class="btn btn-sm btn-primary btn-simple chart_status active" data-status="1">
                                    <input type="radio" name="options" checked>
                                    <span
                                        class="d-none d-sm-block d-md-block d-lg-block d-xl-block">{{ __('Submitted') }}</span>
                                    <span class="d-block d-sm-none">
                                        <i class="fa-solid fa-arrow-down"></i>
                                    </span>
                                </label>
                                <label class="btn btn-sm btn-primary btn-simple chart_status" data-status="2">
                                    <input type="radio" class="d-none d-sm-none" name="options">
                                    <span
                                        class="d-none d-sm-block d-md-block d-lg-block d-xl-block">{{ __('Processing') }}</span>
                                    <span class="d-block d-sm-none">
                                        <i class="fa-solid fa-spinner"></i>
                                    </span>
                                </label>
                                <label class="btn btn-sm btn-primary btn-simple chart_status" data-status="4">
                                    <input type="radio" class="d-none" name="options">
                                    <span
                                        class="d-none d-sm-block d-md-block d-lg-block d-xl-block">{{ __('Assigned') }}</span>
                                    <span class="d-block d-sm-none">
                                        <i class="fa-solid fa-user-check"></i>
                                    </span>
                                </label>
                                <label class="btn btn-sm btn-primary btn-simple chart_status" data-status="5">
                                    <input type="radio" class="d-none" name="options">
                                    <span
                                        class="d-none d-sm-block d-md-block d-lg-block d-xl-block">{{ __('Shiped') }}</span>
                                    <span class="d-block d-sm-none">
                                        <i class="fa-solid fa-truck-fast"></i>
                                    </span>
                                </label>
                                <label class="btn btn-sm btn-primary btn-simple chart_status" data-status="6">
                                    <input type="radio" class="d-none" name="options">
                                    <span
                                        class="d-none d-sm-block d-md-block d-lg-block d-xl-block">{{ __('Delivered') }}</span>
                                    <span class="d-block d-sm-none">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartBig1"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('white/js/plugins/chartjs.min.js') }}"></script>
    {{-- <script>
        gradientChartOptionsConfigurationWithTooltipPurple = {
            maintainAspectRatio: false,
            legend: {
                display: false
            },

            tooltips: {
                backgroundColor: '#f5f5f5',
                titleFontColor: '#333',
                bodyFontColor: '#666',
                bodySpacing: 4,
                xPadding: 12,
                mode: "nearest",
                intersect: 0,
                position: "nearest"
            },
            responsive: true,
            scales: {
                yAxes: [{
                    barPercentage: 1.6,
                    gridLines: {
                        drawBorder: false,
                        color: 'rgba(29,140,248,0.0)',
                        zeroLineColor: "transparent",
                    },
                    ticks: {
                        suggestedMin: 60,
                        suggestedMax: 125,
                        padding: 20,
                        fontColor: "#9a9a9a"
                    }
                }],

                xAxes: [{
                    barPercentage: 1.6,
                    gridLines: {
                        drawBorder: false,
                        color: 'rgba(225,78,202,0.1)',
                        zeroLineColor: "transparent",
                    },
                    ticks: {
                        padding: 20,
                        fontColor: "#9a9a9a"
                    }
                }]
            }
        };
        var chart_labels = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
        var chart_data = [100, 70, 90, 70, 85, 60, 75, 60, 90, 80, 110, 100];


        var ctx = document.getElementById("chartBig1").getContext('2d');

        var gradientStroke = ctx.createLinearGradient(0, 230, 0, 50);

        gradientStroke.addColorStop(1, 'rgba(72,72,176,0.1)');
        gradientStroke.addColorStop(0.4, 'rgba(72,72,176,0.0)');
        gradientStroke.addColorStop(0, 'rgba(119,52,169,0)'); //purple colors
        var config = {
            type: 'line',
            data: {
                labels: chart_labels,
                datasets: [{
                    label: "My First dataset",
                    fill: true,
                    backgroundColor: gradientStroke,
                    borderColor: '#d346b1',
                    borderWidth: 2,
                    borderDash: [],
                    borderDashOffset: 0.0,
                    pointBackgroundColor: '#d346b1',
                    pointBorderColor: 'rgba(255,255,255,0)',
                    pointHoverBackgroundColor: '#d346b1',
                    pointBorderWidth: 20,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 15,
                    pointRadius: 4,
                    data: chart_data,
                }]
            },
            options: gradientChartOptionsConfigurationWithTooltipPurple
        };
        var myChartData = new Chart(ctx, config);
        $("#0").click(function() {
            var data = myChartData.config.data;
            data.datasets[0].data = chart_data;
            data.labels = chart_labels;
            myChartData.update();
        });
        $("#1").click(function() {
            var chart_data = [80, 120, 105, 110, 95, 105, 90, 100, 80, 95, 70, 120];
            var data = myChartData.config.data;
            data.datasets[0].data = chart_data;
            data.labels = chart_labels;
            myChartData.update();
        });

        $("#2").click(function() {
            var chart_data = [60, 80, 65, 130, 80, 105, 90, 130, 70, 115, 60, 130];
            var data = myChartData.config.data;
            data.datasets[0].data = chart_data;
            data.labels = chart_labels;
            myChartData.update();
        });
    </script> --}}
    {{-- <script>
        gradientChartOptionsConfigurationWithTooltipPurple = {
            maintainAspectRatio: false,
            legend: {
                display: false
            },

            tooltips: {
                backgroundColor: '#f5f5f5',
                titleFontColor: '#333',
                bodyFontColor: '#666',
                bodySpacing: 4,
                xPadding: 12,
                mode: "nearest",
                intersect: 0,
                position: "nearest"
            },
            responsive: true,
            scales: {
                yAxes: [{
                    barPercentage: 1.6,
                    gridLines: {
                        drawBorder: false,
                        color: 'rgba(29,140,248,0.0)',
                        zeroLineColor: "transparent",
                    },
                    ticks: {
                        suggestedMin: 0,
                        suggestedMax: 150,
                        padding: 20,
                        fontColor: "#2a2f5b"
                    }
                }],

                xAxes: [{
                    barPercentage: 1.6,
                    gridLines: {
                        drawBorder: false,
                        color: 'rgba(225,78,202,0.1)',
                        zeroLineColor: "transparent",
                    },
                    ticks: {
                        padding: 20,
                        fontColor: "#2a2f5b"
                    }
                }]
            }
        };

        // Days of the month labels
        var chart_labels = Array.from({
            length: 31
        }, (_, i) => i + 1);
        var chart_data = [10, 20, 15, 30, 45, 25, 40, 35, 50, 55, 45, 30, 60, 65, 70, 75, 80, 85, 70, 55, 60, 65, 75, 80,
            90, 100, 95, 85, 70, 65, 60
        ];

        var ctx = document.getElementById("chartBig1").getContext('2d');

        var gradientStroke = ctx.createLinearGradient(0, 230, 0, 50);

        gradientStroke.addColorStop(1, 'rgba(72,72,176,0.1)');
        gradientStroke.addColorStop(0.4, 'rgba(72,72,176,0.0)');
        gradientStroke.addColorStop(0, 'rgba(119,52,169,0)'); // purple colors

        var config = {
            type: 'line',
            data: {
                labels: chart_labels,
                datasets: [{
                    label: "Daily Data",
                    fill: true,
                    backgroundColor: gradientStroke,
                    borderColor: '#0093E9',
                    borderWidth: 2,
                    borderDash: [],
                    borderDashOffset: 0.0,
                    pointBackgroundColor: '#0093E9',
                    pointBorderColor: 'rgba(255,255,255,0)',
                    pointHoverBackgroundColor: '#0093E9',
                    pointBorderWidth: 20,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 15,
                    pointRadius: 4,
                    data: chart_data,
                }]
            },
            options: gradientChartOptionsConfigurationWithTooltipPurple
        };

        var myChartData = new Chart(ctx, config);

        // Example button interactions to switch datasets
        $("#submitted").click(function() {
            var data = myChartData.config.data;
            data.datasets[0].data = chart_data; // Reset to original data
            data.labels = chart_labels;
            myChartData.update();
        });

        $("#processing").click(function() {
            var new_data = Array.from({
                length: 31
            }, () => Math.floor(Math.random() * 100)); // Random daily data
            var data = myChartData.config.data;
            data.datasets[0].data = new_data;
            data.labels = chart_labels;
            myChartData.update();
        });
        $("#assigned").click(function() {
            var new_data = Array.from({
                length: 31
            }, () => Math.floor(Math.random() * 50)); // Random daily data
            var data = myChartData.config.data;
            data.datasets[0].data = new_data;
            data.labels = chart_labels;
            myChartData.update();
        });
        $("#shiped").click(function() {
            var new_data = Array.from({
                length: 31
            }, () => Math.floor(Math.random() * 100)); // Random daily data
            var data = myChartData.config.data;
            data.datasets[0].data = new_data;
            data.labels = chart_labels;
            myChartData.update();
        });
        $("#delivered").click(function() {
            var new_data = Array.from({
                length: 31
            }, () => Math.floor(Math.random() * 50)); // Random daily data
            var data = myChartData.config.data;
            data.datasets[0].data = new_data;
            data.labels = chart_labels;
            myChartData.update();
        });
    </script> --}}

    <script>
        gradientChartOptionsConfigurationWithTooltipPurple = {
            maintainAspectRatio: false,
            legend: {
                display: false
            },

            tooltips: {
                backgroundColor: '#f5f5f5',
                titleFontColor: '#333',
                bodyFontColor: '#666',
                bodySpacing: 4,
                xPadding: 12,
                mode: "nearest",
                intersect: 0,
                position: "nearest"
            },
            responsive: true,
            scales: {
                yAxes: [{
                    barPercentage: 1.6,
                    gridLines: {
                        drawBorder: false,
                        color: 'rgba(29,140,248,0.0)',
                        zeroLineColor: "transparent",
                    },
                    ticks: {
                        suggestedMin: 0,
                        suggestedMax: 100,
                        padding: 20,
                        fontColor: "#2a2f5b"
                    }
                }],

                xAxes: [{
                    barPercentage: 1.6,
                    gridLines: {
                        drawBorder: false,
                        color: 'rgba(225,78,202,0.1)',
                        zeroLineColor: "transparent",
                    },
                    ticks: {
                        padding: 20,
                        fontColor: "#2a2f5b"
                    }
                }]
            }
        };

        // Function to get the number of days in a month
        function getDaysInMonth(month, year) {
            return new Date(year, month, 0).getDate();
        }

        // Initialize variables
        var currentYear = new Date().getFullYear();
        var currentMonth = new Date().getMonth() + 1; // JavaScript months are 0-based
        var chart_labels = Array.from({
            length: getDaysInMonth(currentMonth, currentYear)
        }, (_, i) => i + 1);
        var chart_data = Array.from({
            length: chart_labels.length
        }, () => Math.floor(Math.random() * 100)); // Example data

        // Chart configuration
        var ctx = document.getElementById("chartBig1").getContext('2d');
        var gradientStroke = ctx.createLinearGradient(0, 230, 0, 50);

        gradientStroke.addColorStop(1, 'rgba(72,72,176,0.1)');
        gradientStroke.addColorStop(0.4, 'rgba(72,72,176,0.0)');
        gradientStroke.addColorStop(0, 'rgba(119,52,169,0)');

        var config = {
            type: 'line',
            data: {
                labels: chart_labels,
                datasets: [{
                    label: "Total Order",
                    fill: true,
                    backgroundColor: gradientStroke,
                    borderColor: '#0093E9',
                    borderWidth: 2,
                    pointBackgroundColor: '#0093E9',
                    pointBorderWidth: 2,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 4,
                    pointRadius: 4,
                    data: chart_data,
                }]
            },
            options: gradientChartOptionsConfigurationWithTooltipPurple
        };

        var myChartData = new Chart(ctx, config);

        // Function to update chart
        // function updateChart(month, year, dataFunction) {
        //     var daysInMonth = getDaysInMonth(month, year);
        //     chart_labels = Array.from({
        //         length: daysInMonth
        //     }, (_, i) => i + 1);
        //     var new_data = Array.from({
        //         length: daysInMonth
        //     }, dataFunction);

        //     var data = myChartData.config.data;
        //     data.labels = chart_labels;
        //     data.datasets[0].data = new_data;
        //     myChartData.update();
        // }
        var chart_labels = {!! json_encode($chart_labels) !!};
        var chart_data = {!! json_encode($chart_data) !!};

        function updateChart(chart_labels, chart_data) {
            var data = myChartData.config.data;
            data.labels = chart_labels;
            console.log(chart_data);

            data.datasets[0].data = chart_data;
            myChartData.update();
        }

        updateChart(chart_labels, chart_data);

        // Button interactions
        function fetchChartData(status, month, year) {
            $.ajax({
                url: "{{ route('admin.chart.update') }}",
                method: "GET",
                data: {
                    status: status, // Pass the status to the server
                    month: month, // Pass the selected month
                    year: year // Pass the selected year
                },
                success: function(response) {
                    if (response.success) {
                        // Update the chart with new data from the server
                        updateChart(response.chart_labels, response.chart_data);
                    } else {
                        console.error('Error: Failed to fetch chart data');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed: ' + error);
                }
            });
        }

        // Button click event for changing the status
        $(".chart_status").click(function() {
            var status = $(this).data("status");
            // Call fetchChartData with the current status, month, and year
            fetchChartData(status, currentMonth, currentYear);
        });

        // Dropdown change event for selecting month
        $("#monthSelect").change(function() {
            currentMonth = parseInt(this.value);
            // Call fetchChartData with the selected month and current year
            fetchChartData($(".chart_status.active").data("status"), currentMonth, currentYear);
        });

        // Handle year change (if you want to add a year dropdown)
        $("#yearSelect").change(function() {
            currentYear = parseInt(this.value);
            // Call fetchChartData with the selected year and current month
            fetchChartData($(".chart_status.active").data("status"), currentMonth, currentYear);
        });
    </script>
@endpush
