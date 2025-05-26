@extends('admin.layouts.master')
@section('title', 'Meal and Break Rules List')

@section('content')
    <div class="page-wrapper">
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
        </style>

        <main class="main--container">
            <section class="main--content table-report">
                <div class="panel">
                    <div class="container alert alert-light">
                        <br>
                        <h2 class="header">Meal and Break Rules</h2>

                        <!-- Create Rule Button to trigger the modal -->
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createRuleModal">
                            Create Rule
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="createRuleModal" tabindex="-1" role="dialog"
                            aria-labelledby="createRuleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createRuleModalLabel">Create Meal and Break Rule</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.mealAndBreakRulesStore') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="role">Role:</label>
                                                <input type="text" name="role" class="form-control" placeholder="Enter role" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="meal_break">Meal Break:</label>
                                                <select name="meal_break" class="form-control" required>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="break_duration">Break Duration (in minutes):</label>
                                                <input type="number" name="break_duration" class="form-control" placeholder="Enter duration" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="break_frequency">Break Frequency (in hours):</label>
                                                <input type="number" name="break_frequency" class="form-control" placeholder="Enter frequency" required>
                                            </div>
                                            <button type="submit" class="btn btn-success">Save Rule</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table to display the existing rules -->
                        <table id="mealBreakTable">
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>Meal Break</th>
                                    <th>Break Duration</th>
                                    <th>Break Frequency</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mealAndBreakRules as $item)
                                    <tr>
                                        <td>{{ $item->role }}</td>
                                        <td>{{ $item->meal_break ? 'Yes' : 'No' }}</td>
                                        <td>{{ $item->break_duration }} minutes</td>
                                        <td>{{ $item->break_frequency }} hours</td>
                                        <td>
                                            <a href="{{route('admin.MealBreakRulesDelete', $item->id)}}" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br><br>
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection

@section('scripts')
    <!-- Add the necessary Bootstrap scripts if not already included -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
