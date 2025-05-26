@extends('admin.layouts.master')

@section('title', 'Aged Receivable')

@section('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            text-align: center;
        }

        .table-container {
            margin-top: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            background-color: #fff;
        }

        .form-control {
            width: 100%;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            background-color: #f9f9f9;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: black;
            font-weight: bold;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .filter-input {
            max-width: 400px;
            margin: 0 auto;
        }

        .table-report {
            padding: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="page-wrapper">
        <main class="main--container">
            <section class="main--content table-report">
                <div class="panel">
                    <div class="container alert alert-light">
                        <h2>Hotel Report</h2>

                        <div class="table-container">
                            <table class="table" id="example">
                                <thead>
                                    <tr>
                                        <th>Hotel Name</th>
                                        <th>Hotel Email</th>
                                        <th>Hotel Paid</th>
                                        <th>Date</th>
                                        <th>Contact</th>
                                    </tr>
                                </thead>
                                <tbody id="table">
                                    @foreach ($revenue as $revenu)
                                        <tr>
                                            <td>{{ $revenu->hotel->name }}</td>
                                            <td>{{ $revenu->hotel->email }}</td>
                                            <td>${{ number_format($revenu->total_amount, 2) }}</td>
                                            <td>{{ $revenu->updated_at->format('Y-m-d') }}</td>
                                            <td>{{ $revenu->hotel->contact }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection
