@extends('admin.layouts.master')

@section('title', 'Aged Receivable')

@section('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .chart-container {
            width: 45%;
            margin: 20px auto;
            display: inline-block;
        }

        h1,
        h2 {
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="page-wrapper">
        <main class="main--container">
            <section class="main--content table-report">
                <div class="panel">
                    <br><br>

                    <h1>Organizational Charts</h1>

                    <div class="chart-container">
                        <h2>Active Employees vs Total Employees</h2>
                        <canvas id="employeeChart"></canvas>
                    </div>

                    <div class="chart-container">
                        <h2>Active Hotels vs Total Hotels</h2>
                        <canvas id="hotelsChart"></canvas>
                    </div>

                    <div class="chart-container">
                        <h2>ROI</h2>
                        <canvas id="roiChart"></canvas>
                    </div>

                    <div class="chart-container">
                        <h2>Receivables</h2>
                        <canvas id="receivablesChart"></canvas>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Chart 1: Active Employees vs Total Employees
        const employeeData = {
            labels: ['Active Employees', 'Terminated Employees'],
            datasets: [{
                label: 'Employees',
                data: [{{ $activeEmployees }}, {{ $inactiveEmployees }}], // Dynamic data
                backgroundColor: ['#4CAF50', '#F44336'],
                hoverOffset: 4
            }]
        };
        new Chart(document.getElementById('employeeChart'), {
            type: 'doughnut',
            data: employeeData
        });

        // Chart 2: Active Hotels vs Total Hotels
        const hotelsData = {
            labels: ['Active Hotels', 'Block Hotels'],
            datasets: [{
                label: 'Hotels',
                data: [{{ $activeHotels }}, {{ $inactiveHotels }}], // Dynamic data
                backgroundColor: ['#2196F3', '#FFC107'],
                hoverOffset: 4
            }]
        };
        new Chart(document.getElementById('hotelsChart'), {
            type: 'doughnut',
            data: hotelsData
        });

        // Chart 3: ROI (Bar Chart)
        const roiData = {
            labels: ['Q1', 'Q2', 'Q3', 'Q4'],
            datasets: [{
                label: 'ROI (in $)',
                data: [{{ $roiData['Q1'] }}, {{ $roiData['Q2'] }}, {{ $roiData['Q3'] }},
                    {{ $roiData['Q4'] }}
                ], // Dynamic data
                backgroundColor: '#673AB7',
                borderColor: '#512DA8',
                borderWidth: 1
            }]
        };
        new Chart(document.getElementById('roiChart'), {
            type: 'bar',
            data: roiData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Chart 4: Receivables (Line Chart)
        const receivablesData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
                'November', 'December'
            ],
            datasets: [{
                label: 'Receivables (in $)',
                data: [
                    {{ $receivablesData['January'] }},
                    {{ $receivablesData['February'] }},
                    {{ $receivablesData['March'] }},
                    {{ $receivablesData['April'] }},
                    {{ $receivablesData['May'] }},
                    {{ $receivablesData['June'] }},
                    {{ $receivablesData['July'] }},
                    {{ $receivablesData['August'] }},
                    {{ $receivablesData['September'] }},
                    {{ $receivablesData['October'] }},
                    {{ $receivablesData['November'] }},
                    {{ $receivablesData['December'] }}
                ], // Dynamic data
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                tension: 0.4
            }]
        };
        new Chart(document.getElementById('receivablesChart'), {
            type: 'line',
            data: receivablesData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
