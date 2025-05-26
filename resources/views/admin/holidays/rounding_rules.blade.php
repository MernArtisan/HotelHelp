@extends('admin.layouts.master')
@section('title', 'Rounding Rules List')

@section('content')
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
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        .header {
            text-align: center;
        }

        .btn-primary {
            margin-bottom: 20px;
        }

    </style>

    <div class="page-wrapper">
        <main class="main--container">
            <section class="main--content table-report">
                <div class="panel">
                    <div class="container alert alert-light">
                        <br>
                        <h2 class="header">Rounding Rules</h2>
                        <!-- Button to trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addRoundingRuleModal">
                            Add Rounding Rule
                        </button>

                        <!-- Modal for adding new rounding rule -->
                        <div class="modal fade" id="addRoundingRuleModal" tabindex="-1" role="dialog"
                            aria-labelledby="addRoundingRuleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addRoundingRuleModalLabel">Add New Rounding Rule</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.roundingRulesStore') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="role">Role</label>
                                                <input type="text" class="form-control" id="role" name="role" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="working_hours_rounding">Working Hours Rounding (minutes)</label>
                                                <input type="number" class="form-control" id="working_hours_rounding"
                                                    name="working_hours_rounding" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="overtime_rounding">Overtime Rounding (minutes)</label>
                                                <input type="number" class="form-control" id="overtime_rounding"
                                                    name="overtime_rounding" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="break_time_rounding">Break Time Rounding (minutes)</label>
                                                <input type="number" class="form-control" id="break_time_rounding"
                                                    name="break_time_rounding" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="notes">Notes</label>
                                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" style="margin-top: 22px">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Rounding Rules Table -->
                        <table id="roundingRulesTable">
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>Working Hours Rounding</th>
                                    <th>Overtime Rounding</th>
                                    <th>Break Time Rounding</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rounding_rules as $item)
                                    <tr>
                                        <td>{{ $item->role }}</td>
                                        <td>{{ $item->working_hours_rounding }} mins</td>
                                        <td>{{ $item->overtime_rounding }} mins</td>
                                        <td>{{ $item->break_time_rounding }} mins</td>
                                        <td>{{ $item->notes }}</td>
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
@endsection

@section('scripts')
    <!-- Include Bootstrap JS for modal functionality -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
