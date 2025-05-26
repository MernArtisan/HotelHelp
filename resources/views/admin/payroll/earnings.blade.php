@extends('admin.layouts.master')

@section('title', 'Announcements')
@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button-container {
            text-align: center;
            margin: 20px 0;
        }
    </style>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="offset-1 col-10 offset-1">
                    <main class="main--container">
                        <section class="main--content table-report">
                            <div class="panel">
                                <div class="container alert alert-light">
                                    <br>
                                    <h2>Earnings</h2>

                                    <!-- Earnings Table -->
                                    <table id="earningsTable">
                                        <thead>
                                            <tr>
                                                <th>Hotel Name</th>
                                                <th>Location</th>
                                                <th>Total Earnings ($)</th>
                                                {{-- <th>Employee Payments ($)</th> --}}
                                                <th>Due Amount ($)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($revenues as $revenu)
                                                <tr>
                                                    <td>{{ $revenu->hotel->name }}</td>
                                                    <td>{{ $revenu->hotel->location }}</td>
                                                    <td>${{ $revenu->total_amount }}</td>
                                                    <td>${{ $revenu->due_amount }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <!-- Refresh Button -->
                                    <div class="button-container">
                                        <button class="button" onclick="loadEarnings()">Refresh Data</button>
                                    </div>

                                </div>
                        </section>
                    </main>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
