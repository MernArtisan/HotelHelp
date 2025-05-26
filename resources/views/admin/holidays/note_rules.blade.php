@extends('admin.layouts.master')
@section('title', 'Hotels List')

@section('content')
    <div class="page-wrapper">
        <main class="main--container">
            <section class="main--content table-report">
                <div class="panel">
                    <div class="container alert alert-light">
                        <br>
                        <h2 class="header">Note Rules</h2>
                        <form id="noteRulesForm" action="{{ route('admin.noteRulesAdd') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ruleName">Rule Name:</label>
                                        <input type="text" class="form-control" id="rule_name" name="rule_name"
                                            placeholder="Enter rule name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ruleDescription">Rule Description:</label>
                                        <input type="text" class="form-control" id="rule_description"
                                            name="rule_description" placeholder="Enter rule description" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="startDate">Effective Start Date:</label>
                                        <input type="date" class="form-control" id="effective_start_date"
                                            name="effective_start_date" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="endDate">Effective End Date:</label>
                                        <input type="date" name="effective_end_date" class="form-control" id="endDate"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="department">Associated Department:</label>
                                        <input type="text" class="form-control" id="associated_department" name="associated_department"
                                            placeholder="Enter department" required>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="notes">Notes (optional):</label>
                                        <textarea class="form-control" id="notes" name="notes" placeholder="Enter any additional notes" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary" onclick="addNoteRule()">Save Note Rule</button>
                        </form>
                        <br>
                        <table class="table table-striped mt-4" id="example">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Rule Name</th>
                                    <th>Rule Description</th>
                                    <th>Effective Start Date</th>
                                    <th>Effective End Date</th>
                                    {{-- <th>Associated Department</th> --}}
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($noteRules as $item)
                                    <tr>
                                        <td>{{ $item->rule_name }}</td>
                                        <td>{{ $item->rule_description }}</td>
                                        <td>{{ $item->effective_start_date }}</td>
                                        <td>{{ $item->effective_end_date }}</td>
                                        {{-- <td>{{ $item->associated_department }}</td> --}}
                                        <td>{{ $item->notes }}</td>
                                        <td>
                                            <a href="{{ route('admin.noteRulesDelete', $item->id) }}"
                                                class="btn btn-danger btn-sm">Delete</a>
                                        </td>
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
@endsection
