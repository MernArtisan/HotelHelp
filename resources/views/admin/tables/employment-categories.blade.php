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
                        <h1>Employment Categories</h1>

                        <div class="filter-container">
                            <label for="hotelFilter">Select Hotel</label>
                            <select id="hotelFilter">
                                <option value="all">All Hotels</option>
                                @foreach ($hotels as $hotel)
                                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                @endforeach
                            </select>

                            <label for="categoryFilter">Select Employment Category</label>
                            <select id="categoryFilter">
                                <option value="all">All Categories</option>
                                <option value="w2">W2</option>
                                <option value="1099">1099</option>
                            </select>
                        </div>

                        <table id="employeeTable">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Hotel</th>
                                    <th>Position</th>
                                    <th>Employment Category</th>
                                    <th>Hire Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr data-hotel="{{ $employee->hotel_id }}" data-category="{{ $employee->employee_type }}">
                                        <td>{{ $employee->employee_id }}</td>
                                        <td>{{ $employee->user->first_name }} {{ $employee->user->middle_name }} {{ $employee->user->last_name }}</td>
                                        <td>{{ $employee->hotel->name }}</td>
                                        <td>{{ $employee->designation }}</td>
                                        <td>{{ $employee->employee_type }}</td>
                                        <td>{{ $employee->hire_date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <br>
                    </div>
                </div>
            </section>
        </main>
    </div>

@endsection

@section('scripts')
    <script>
        // Filtering logic
        document.getElementById('hotelFilter').addEventListener('change', filterTable);
        document.getElementById('categoryFilter').addEventListener('change', filterTable);

        function filterTable() {
            var hotelFilterValue = document.getElementById('hotelFilter').value;
            var categoryFilterValue = document.getElementById('categoryFilter').value;

            // Get all rows in the employee table
            var rows = document.querySelectorAll('#employeeTable tbody tr');

            rows.forEach(function(row) {
                var hotelValue = row.getAttribute('data-hotel');
                var categoryValue = row.getAttribute('data-category');

                // Apply filters
                var hotelMatch = (hotelFilterValue === 'all' || hotelValue === hotelFilterValue);
                var categoryMatch = (categoryFilterValue === 'all' || categoryValue === categoryFilterValue);

                // Show or hide the row based on the filters
                if (hotelMatch && categoryMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
@endsection
