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
    </style>
@endsection

@section('content')
    <div class="page-wrapper">
        <main class="main--container">
            <section class="main--content table-report">
                <div class="panel">
                    <div class="container alert alert-light">
                        <br>
                        <h1>Termination Reasons</h1>

                        <div class="filter-container">
                            <label for="hotelFilter">Select Hotel</label>
                            <select id="hotelFilter">
                                <option value="all">All Hotels</option>
                                @foreach ($hotels as $hotel)
                                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                @endforeach
                            </select>

                            <label for="reasonFilter">Select Termination Reason</label>
                            <select id="reasonFilter">
                                <option value="all">All Reasons</option>
                                <option value="Performance Issues">Performance Issues</option>
                                <option value="Resigned">Resigned</option>
                                <option value="Retirement">Retirement</option>
                                <option value="Policy Violation">Policy Violation</option>
                                <option value="Company Restructuring">Company Restructuring</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <table id="terminationTable">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Hotel</th>
                                    <th>Termination Reason</th>
                                    <th>Termination Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $termination)
                                    <tr data-hotel="{{ $termination->hotel_id }}"
                                        data-reason="{{ $termination->termination->termination_reason }}">
                                        <td>{{ $termination->employee_id }}</td>
                                        <td>{{ $termination->user->first_name }} {{ $termination->user->middle_name }} {{ $termination->user->last_name }}</td>
                                        <td>{{ $termination->hotel->name }}</td>
                                        <td>{{ $termination->termination->termination_reason }}</td>
                                        <td>{{ $termination->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br><br>
                    </div>
            </section>
        </main>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hotelFilter = document.getElementById('hotelFilter');
            const reasonFilter = document.getElementById('reasonFilter');
            const tableRows = document.querySelectorAll('#terminationTable tbody tr');

            hotelFilter.addEventListener('change', applyFilters);
            reasonFilter.addEventListener('change', applyFilters);

            function applyFilters() {
                const selectedHotel = hotelFilter.value;
                const selectedReason = reasonFilter.value;

                tableRows.forEach(row => {
                    const hotelId = row.getAttribute('data-hotel');
                    const reason = row.getAttribute('data-reason');

                    const matchesHotel = (selectedHotel === 'all' || hotelId === selectedHotel);
                    const matchesReason = (selectedReason === 'all' || reason === selectedReason);

                    if (matchesHotel && matchesReason) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endsection
