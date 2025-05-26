@extends('admin.layouts.master')
@section('title', 'Pay Group')
@section('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        .filter-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        select,
        table {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        table {
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
@endsection
@section('content')
    <div class="page-wrapper">
        <main class="main--container">
            <section class="main--content table-report">
                <div class="panel">
                    <div class="container alert alert-light">
                        <br>
                        <h1>Organization Table</h1>

                        <div class="filter-container">
                            <label for="hotelFilter">Select Hotel</label>
                            <select id="hotelFilter">
                                <option value="all">All Hotels</option>
                                @foreach ($hotels as $hotel)
                                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <table id="employeeTable">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Hotel</th>
                                    <th>Designation</th>
                                    <th>Hire Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr data-hotel="{{ $employee->hotel->id }}">
                                        <td>{{ $employee->id }}</td>
                                        <td>{{ $employee->user->name }}</td>
                                        <td>{{ $employee->hotel->name }}</td>
                                        <td>{{ $employee->designation }}</td>
                                        <td>{{ $employee->hire_date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br> <br>
                    </div>
            </section>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hotelFilter = document.getElementById('hotelFilter');
            const employeeTable = document.getElementById('employeeTable').getElementsByTagName('tbody')[0];
            const rows = employeeTable.getElementsByTagName('tr');

            hotelFilter.addEventListener('change', function () {
                const selectedHotel = this.value;

                for (let i = 0; i < rows.length; i++) {
                    const hotelId = rows[i].getAttribute('data-hotel');

                    // Show all rows if "all" is selected, else filter by hotel ID
                    if (selectedHotel === 'all' || selectedHotel === hotelId) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });
        });
    </script>
@endsection
