@extends('admin.layouts.master')

@section('title', 'Quarterly Revenue List')

@section('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .filter-section {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        select,
        input,
        button {
            padding: 10px;
            font-size: 14px;
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
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .delete-btn {
            color: red;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="page-wrapper">
        <main class="main--container">
            <section class="main--content table-report">
                <div class="panel">
                    <div class="container alert alert-light">
        
                        <h1>Quarterly Revenue Reports</h1>
                        <br> <br>

                        <!-- Filter Section -->
                        <div class="filter-section">
                            <!-- Year filter -->
                            <input type="number" id="yearInput" name="year" placeholder="Enter Year" value="{{ $year }}">

                            <!-- Quarter filter -->
                            <select id="quarterDropdown" name="quarter">
                                <option value="">Select Quarter</option>
                                <option value="Q1">Quarter 1</option>
                                <option value="Q2">Quarter 2</option>
                                <option value="Q3">Quarter 3</option>
                                <option value="Q4">Quarter 4</option>
                            </select>

                            <!-- Hotel filter -->
                            <select id="hotelDropdown" name="hotel_id">
                                <option value="">Select Hotel</option>
                                @foreach($hotels as $hotel)
                                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                @endforeach
                            </select>
                            <button onclick="applyFilters()">Apply Filters</button>
                        </div>

                        <!-- Revenue Table -->
                        <table id="revenueTable">
                            <thead>
                                <tr>
                                    <th>Hotel Name</th>
                                    <th>Quarter</th>
                                    <th>Total Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Due Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($revenues as $revenue)
                                    <tr>
                                        <td>{{ $revenue->hotel_name }}</td>
                                        <td>{{ $revenue->created_at->format('Q') }}</td> <!-- Helper function to get quarter -->
                                        <td>{{ $revenue->total_amount }}</td>
                                        <td>{{ $revenue->paid_amount }}</td>
                                        <td>{{ $revenue->due_amount }}</td>
                                        <td>{{ $revenue->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </section>
        </main>
    </div>

    <!-- JS for Filtering -->
    <script>
        function applyFilters() {
            const year = document.getElementById('yearInput').value;
            const quarter = document.getElementById('quarterDropdown').value;
            const hotelId = document.getElementById('hotelDropdown').value;
            // const status = document.getElementById('statusDropdown').value;

            let query = `?year=${year}&quarter=${quarter}&hotel_id=${hotelId}`;
            window.location.href = query;
        }
    </script>
@endsection
