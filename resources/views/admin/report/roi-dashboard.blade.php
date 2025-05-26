@extends('admin.layouts.master')

@section('title', 'ROI Dashboard')

@section('content')
    <div class="page-wrapper">
        <main class="main--container">
            <section class="main--content">
                <div class="panel">
                    <div class="col-xl-12 col-md-6">
                        <div class="panel-heading">
                            <h3 class="panel-title">ROI Dashboard</h3>
                        </div>

                        <form method="GET" action="{{ route('admin.RoiDashboard') }}">
                            <label for="year">Select Year:</label>
                            <select id="year" name="year" onchange="this.form.submit()" class="form-control col-2">
                                @for ($i = date('Y'); $i >= 2024; $i--)
                                    <option value="{{ $i }}" {{ $selectedYear == $i ? 'selected' : '' }}>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </form>

                        <div class="panel-chart">
                            <div id="morrisAreaChart01" class="chart--body area--chart style--1"></div>

                            <div class="chart--stats style--1">
                                <ul class="nav">
                                    <li data-overlay="1 orange">
                                        <p class="amount">${{ number_format($employeePayable, 2) }}</p>
                                        <p>
                                            <span class="label">Employee Payable</span>
                                            <span class="text-red"><i class="fa fa-long-arrow-alt-down"></i></span>
                                        </p>
                                    </li>
                                    <li data-overlay="1 green">
                                        <p class="amount">${{ number_format($totalRevenue, 2) }}</p>
                                        <p>
                                            <span class="label">Total Revenue</span>
                                            <span class="text-green"><i class="fa fa-long-arrow-alt-up"></i></span>
                                        </p>
                                    </li>
                                    <li data-overlay="1 blue">
                                        <p class="amount">${{ number_format($profit, 2) }}</p>
                                        <p>
                                            <span class="label">Profit</span>
                                            <span class="text-green"><i class="fa fa-long-arrow-alt-up"></i></span>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection

@section('scripts')
    <script>
        var chartData = {!! $chartData !!};

        var $morrisAreaChart01 = document.getElementById('morrisAreaChart01');

        if ($morrisAreaChart01) {
            new Morris.Area({
                element: $morrisAreaChart01.id,
                data: chartData,
                xkey: 'month',
                ykeys: ['a', 'b', 'c'],
                labels: ['Total Revenue', 'Employee Payable', 'Profit'],
                lineColors: ['#2bb3c0', '#FF0000', '#009378'], // Distinct colors
                preUnits: '$',
                parseTime: false,
                pointSize: 2,
                lineWidth: 2,
                fillOpacity: 0.6, // Adjust fill opacity to make areas more visible
                gridLineColor: '#eee',
                resize: true,
                hideHover: true,
                behaveLikeLine: true
            });

        }
    </script>
@endsection
