@extends('admin.layouts.master')

@section('title', 'Aged Receivable')

@section('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
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
            cursor: pointer;
            background-color: #94f7f2;
        }

        .filter-section {
            margin-bottom: 20px;
        }

        .filter-section input,
        .filter-section select {
            margin-right: 10px;
            padding: 5px;
        }

        .search-section {
            margin-bottom: 20px;
        }

        .all-label {
            margin-right: 10px;
            margin-left: 18px;
        }

        td,
        th {
            font-weight: bold;
            color: #333;
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
                        <h1 class="text-dark">Aged Receivables</h1>
                        <div class="filter-section">
                            <div class="row">
                                <div class="all-label">
                                    <label for="dateFilter">Date:</label>
                                </div>
                                <input type="date" id="dateFilter" class="" name="invoice_date"
                                    onchange="filterTable()">
                                <div class="all-label">
                                    <label for="hotelFilter">Hotel:</label>
                                </div>
                                <select id="hotelFilter" onchange="filterTable()">
                                    <option value="">All</option>
                                    @foreach ($hotels as $hotel)
                                        <option value="{{ $hotel->name }}">{{ $hotel->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <table id="example">
                            <thead>
                                <tr>
                                    <th>Invoice Date</th>
                                    <th>Hotel</th>
                                    <th>Invoice No</th>
                                    <th>Invoice Due Date</th>
                                    <th>Revenue</th>
                                    <th>Due Duration</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($envoice as $env)
                                    @php
                                        $today = \Carbon\Carbon::now();
                                        $dueDate = \Carbon\Carbon::parse($env->due_date);
                                        $daysDifference = $today->diffInDays($dueDate, false); // negative if overdue
                                        $status = $env->status; // status should be 'paid' or 'unpaid'
                                    @endphp
                                    <tr>
                                        <td>{{ $env->invoice_date }}</td>
                                        <td>{{ $env->hotel->name }}</td>
                                        <td>{{ $env->invoice_number }}</td>
                                        <td>{{ $env->due_date }}</td>
                                        <td>${{ $env->total_amount }}</td>
                                        <td
                                            style="background-color: 
                                    @if ($status == 'unpaid') @if ($daysDifference < 0)
                                            red
                                        @else
                                            blue @endif
@else
green
                                    @endif; color: white;">
                                            @if ($status == 'unpaid')
                                                @if ($daysDifference < 0)
                                                    {{ abs($daysDifference) }} days overdue
                                                @else
                                                    {{ $daysDifference }} days remaining
                                                @endif
                                            @else
                                                (Paid)
                                            @endif
                                        </td>
                                        <td>
                                            @if ($status == 'unpaid')
                                                <button class="btn btn-danger btn-sm">Unpaid</button>
                                            @else
                                                <button class="btn btn-success btn-sm" disabled>Paid</button>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($status == 'unpaid')
                                                <form action="{{ route('admin.PaidAgedReceivables', $env->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button class="btn btn-dark btn-sm">Mark as Paid</button>
                                                </form>
                                            @else
                                                <button class="btn btn-success btn-sm" disabled>Paid</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </section>
        </main>
    </div>

    <script>
        function searchTable() {
            const searchInput = document.getElementById('searchBar').value.toLowerCase();
            const table = document.getElementById('example');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                let cells = rows[i].getElementsByTagName('td');
                let rowContainsSearchTerm = false;

                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].textContent.toLowerCase().includes(searchInput)) {
                        rowContainsSearchTerm = true;
                        break;
                    }
                }

                rows[i].style.display = rowContainsSearchTerm ? '' : 'none';
            }
        }

        function filterTable() {
            const dateFilter = document.getElementById('dateFilter').value;
            const hotelFilter = document.getElementById('hotelFilter').value.toLowerCase();
            const table = document.getElementById('example');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                let dateCell = rows[i].getElementsByTagName('td')[0].textContent;
                let hotelCell = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();

                let dateMatch = !dateFilter || dateCell.includes(dateFilter);
                let hotelMatch = !hotelFilter || hotelCell.includes(hotelFilter);

                rows[i].style.display = dateMatch && hotelMatch ? '' : 'none';
            }
        }
    </script>
@endsection
