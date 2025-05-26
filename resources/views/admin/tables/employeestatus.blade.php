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
            margin-bottom: 20px;
        }

        .filters {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        select {
            padding: 8px;
            font-size: 14px;
            width: 45%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .btn {
            padding: 8px 12px;
            margin-top: 10px;
            font-size: 14px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
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
                        <h1>Employment Statuses</h1>

                        <div class="filters">
                            <select id="filterHotel">
                                <option value="all">Filter by Hotel</option>
                                @forelse ($hotels as $hotel)
                                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                @empty
                                    <option value="all">No hotels available</option>
                                @endforelse
                            </select>
                            <select id="filterStatus">
                                <option value="all">Filter by Employment Status</option>
                                <option value="active">Active</option>
                                <option value="terminated">Terminated</option>
                                <option value="left">Left</option>
                                <option value="hold">Hold</option>
                            </select>
                        </div>

                        <table id="employmentTable">
                            <thead>
                                <tr>
                                    <th>Hotel</th>
                                    <th>Employee Name</th>
                                    <th>Employment Status</th>
                                    <th>Hire Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $item)
                                    <tr data-hotel="{{ $item->hotel->id }}" data-status="{{ $item->status }}">
                                        <td>{{ $item->hotel->name }}</td>
                                        <td>{{ $item->user->first_name }} {{ $item->user->middle_name }} {{ $item->user->last_name }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->hire_date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <br>
                        <br>
                        <br>
                    </div>
            </section>
        </main>
    </div>
@endsection

@section('scripts')
    <script>
        // Get the dropdown elements and the table
        const filterHotel = document.getElementById('filterHotel');
        const filterStatus = document.getElementById('filterStatus');
        const table = document.getElementById('employmentTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        // Add event listeners to filter dropdowns
        filterHotel.addEventListener('change', filterTable);
        filterStatus.addEventListener('change', filterTable);

        // Filter function
        function filterTable() {
            const selectedHotel = filterHotel.value;
            const selectedStatus = filterStatus.value;

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const hotel = row.getAttribute('data-hotel');
                const status = row.getAttribute('data-status');

                // Check if the row matches both filters
                const hotelMatches = selectedHotel === 'all' || hotel === selectedHotel;
                const statusMatches = selectedStatus === 'all' || status === selectedStatus;

                // Show or hide the row based on filter match
                if (hotelMatches && statusMatches) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }

        // Example function to handle 'Save Changes' button (add your functionality here)
        function saveChanges() {
            alert('Changes saved!');
        }
    </script>
@endsection
