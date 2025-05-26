@extends('admin.layouts.master')

@section('title', 'Announcements')
@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #218838;
        }

        .deleteBtn {
            background-color: #dc3545;
        }

        .deleteBtn:hover {
            background-color: #c82333;
        }

        .form-group {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .inputField {
            width: 150px;
            padding: 5px;
        }

        .descriptionField {
            width: 100%;
            margin-bottom: 15px;
        }

        .actionBtns {
            display: flex;
            gap: 5px;
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
                                    <h2>Additional Checks</h2>
                                    <form id="payrollForm" method="POST" action="{{ route('admin.AdditionalChecksStore') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="employeeName">Employee Name:</label>
                                            <select name="employee_id" id="employee_id" class="form-control">
                                                @foreach ($employees as $employe)
                                                    <option value="{{ $employe->id }}">{{ $employe->user->first_name }} {{ $employe->user->middle_name }} {{ $employe->user->last_name }}</option>
                                                @endforeach
                                            </select>

                                            <label for="checkDate">Check Date:</label>
                                            <input type="date" id="check_date" name="check_date" class="form-control"
                                                required>

                                            <label for="checkAmount">Amount:</label>
                                            <input type="number" id="amount" name="amount" class="form-control"
                                                step="0.01" required>
                                        </div>
                                        <label for="description">Description:</label>
                                        <input type="text" id="description" name="description" class="form-control"
                                            required>
                                        <br>
                                        <button type="submit">Add Check</button>
                                    </form>
                                    <br>
                                    <!-- Payroll Table -->
                                    <h3>Payroll Records</h3>
                                    <table id="payrollTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Employee Name</th>
                                                <th>Check Date</th>
                                                <th>Amount</th>
                                                <th>Description</th>
                                                {{-- <th>Actions</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($checks as $check)
                                                <tr>
                                                    <td>{{ $check->employee->employee_id }}</td>
                                                    <td>{{ $check->employee->user->first_name }} {{ $check->employee->user->middle_name }} {{ $check->employee->user->last_name }}</td>
                                                    <td>{{ $check->check_date }}</td>
                                                    <td>{{ $check->amount }}</td>
                                                    <td>{{ $check->description }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br>
                                    <br>
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
