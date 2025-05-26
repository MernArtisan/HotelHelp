@extends('admin.layouts.master')

@section('title', 'Employees Report')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    h1 {
        text-align: center;
    }

    .search-bar {
        margin-bottom: 20px;
        text-align: center;
    }

    .search-bar input {
        width: 50%;
        padding: 10px;
        font-size: 16px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
    }

    th {
        background-color: #f4f4f4;
    }

    .chart-container {
        width: 45%;
        margin: 20px auto;
        display: inline-block;
    }
</style>
<div class="page-wrapper">
    <main class="main--container">
        <section class="main--content table-report">
            <div class="panel">
                <div class="container alert alert-light">

                    <h1>Employee Demographics</h1>

                    <!-- Search Bar -->
                    <div class="search-bar">
                        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for employees...">
                    </div>

                    <!-- Employee Table -->
                    <table id="employeeTable">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Hotel Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $key => $employee)
                            <tr>
                                <td>{{ $employee->employee_id }}</td>
                                <td>{{ $employee->user->first_name }} {{ $employee->user->middle_name }} {{ $employee->user->last_name }}</td>
                                <td>{{ $employee->gender }}</td>
                                <td>{{ $employee->hotel->name }}</td>
                            </tr>
                            @empty
                                <tr><td colspan="4">No employees found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="chart-container">
                        <h2>Gender Distribution</h2>
                        <canvas id="genderChart"></canvas>
                    </div>

                    <div class="chart-container">
                        <h2>Employee Distribution by Hotel</h2>
                        <canvas id="hotelChart"></canvas>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function searchTable() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const table = document.getElementById('employeeTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let match = false;

            for (let j = 0; j < cells.length; j++) {
                if (cells[j].textContent.toLowerCase().includes(input)) {
                    match = true;
                    break;
                }
            }

            rows[i].style.display = match ? '' : 'none';
        }
    }

    // Gender Distribution Data from Controller
    const genderData = {
        labels: ['Male', 'Female','Other'],
        datasets: [{
            data: [{{ $genderCounts['male'] }}, {{ $genderCounts['female'] }}, {{ $genderCounts['other'] }}], // Dynamic data from controller
            backgroundColor: ['#4CAF50', '#FFC107', 'black'],
            hoverOffset: 4
        }]
    };

    // Hotel Distribution Data from Controller
    const hotelData = {
        labels: @json(array_keys($hotelCounts->toArray())), // Hotel names
        datasets: [{
            data: @json(array_values($hotelCounts->toArray())), // Employee count per hotel
            backgroundColor: ['#2196F3', '#FF5722', '#9C27B0', '#8BC34A'],
            hoverOffset: 4
        }]
    };

    // Gender Distribution Chart
    new Chart(document.getElementById('genderChart'), {
        type: 'doughnut',
        data: genderData
    });

    // Hotel Distribution Chart
    new Chart(document.getElementById('hotelChart'), {
        type: 'pie',
        data: hotelData
    });
</script>
@endsection
