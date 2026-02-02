@extends('layouts.main')

@section('title', 'Панель управления')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Панель управления</h3>
                    </div>
                    <div class="col-6">
                        <div class="d-flex justify-content-end align-items-center gap-3">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item active">Панель управления</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Statistics Cards -->
            <div class="row">
                <!-- Card 1: Total Tours -->
                <div class="col-xl-3 col-md-6 mb-4 box-col-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small mb-1">Всего туров</div>
                                    <h4 class="mb-0 fw-bold">{{ number_format($cards['total_tours']) }}</h4>
                                </div>
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-suitcase fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Total Reviews -->
                <div class="col-xl-3 col-md-6 mb-4 box-col-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small mb-1">Всего отзывов</div>
                                    <h4 class="mb-0 fw-bold">{{ number_format($cards['total_reviews']) }}</h4>
                                </div>
                                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-comments fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Total Bookings -->
                <div class="col-xl-3 col-md-6 mb-4 box-col-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small mb-1">Всего бронирований</div>
                                    <h4 class="mb-0 fw-bold">{{ number_format($cards['total_bookings']) }}</h4>
                                </div>
                                <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-ticket-alt fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Total Questions -->
                <div class="col-xl-3 col-md-6 mb-4 box-col-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small mb-1">Всего вопросов</div>
                                    <h4 class="mb-0 fw-bold">{{ number_format($cards['total_questions']) }}</h4>
                                </div>
                                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-question-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 5: Most Expensive Tour -->
                <div class="col-xl-3 col-md-6 mb-4 box-col-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small mb-1">Самый дорогой тур</div>
                                    <h4 class="mb-0 fw-bold">${{ number_format($cards['most_expensive_price'], 2) }}</h4>
                                </div>
                                <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-money-bill fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 6: Highest Rated Tour -->
                <div class="col-xl-3 col-md-6 mb-4 box-col-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div style="max-width: 70%;">
                                    <div class="text-muted small mb-1">Топ рейтинг</div>
                                    @if($cards['highest_rated_tour'])
                                    <h6 class="mb-1 fw-bold text-truncate" title="{{ $cards['highest_rated_tour']['name'] }}">
                                        {{ $cards['highest_rated_tour']['name'] }}
                                    </h6>
                                    <div class="text-warning small">
                                        <i class="fa fa-star"></i>
                                        <strong>{{ $cards['highest_rated_tour']['rating'] }}</strong>
                                        <span class="text-muted">({{ $cards['highest_rated_tour']['reviews_count'] }})</span>
                                    </div>
                                    @else
                                    <h4 class="mb-0 fw-bold">-</h4>
                                    @endif
                                </div>
                                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                    <i class="fa fa-trophy fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 7: Total Categories -->
                <div class="col-xl-3 col-md-6 mb-4 box-col-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small mb-1">Всего категорий</div>
                                    <h4 class="mb-0 fw-bold">{{ number_format($cards['total_categories']) }}</h4>
                                </div>
                                <div class="bg-secondary bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-folder fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 8: Total Features -->
                <div class="col-xl-3 col-md-6 mb-4 box-col-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small mb-1">Всего функций</div>
                                    <h4 class="mb-0 fw-bold">{{ number_format($cards['total_features']) }}</h4>
                                </div>
                                <div class="bg-dark bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-star fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row clearfix">
                <!-- Chart 1: Tours by Category (Pie Chart) -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Туры по категориям</h4>
                        </div>
                        <div class="card-body">
                            <div class="recent-report__chart">
                                <div id="chart7"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart 2: Bookings by Month (Area Chart) -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Бронирования по месяцам</h4>
                        </div>
                        <div class="card-body">
                            <div class="recent-report__chart">
                                <div id="chart6"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
<script>
    $(document).ready(function() {
        // Chart 1: Tours by Category (Pie Chart)
        function chart7() {
            var options = {
                chart: {
                    width: 360,
                    type: 'pie',
                },
                labels: @json($charts['tours_by_category']['labels']),
                series: @json($charts['tours_by_category']['data']),
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                colors: ['#7366ff', '#f73164', '#51bb25', '#ffc107', '#a927f9', '#f8d62b']
            }

            var chart = new ApexCharts(
                document.querySelector("#chart7"),
                options
            );

            chart.render();
        }

        // Chart 2: Bookings by Month (Area Chart)
        function chart6() {
            var options = {
                chart: {
                    height: 350,
                    type: 'area',
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                series: [{
                    name: 'Бронирования',
                    data: @json($charts['bookings_by_month']['data'])
                }],
                xaxis: {
                    categories: @json($charts['bookings_by_month']['labels']),
                    labels: {
                        style: {
                            colors: '#9aa0ac',
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            color: '#9aa0ac',
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " бронирований"
                        }
                    }
                },
                colors: ['#7366ff']
            }

            var chart = new ApexCharts(
                document.querySelector("#chart6"),
                options
            );

            chart.render();
        }

        // Initialize charts
        chart7();
        chart6();
    });
</script>
@endpush