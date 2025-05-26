@extends('admin.layouts.master')
@section('title', 'Hotels List')

@section('content')
    <style>
        /* Styles for the page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        /* Form styling */
        form {
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
        }

        form input,
        form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Button styling */
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Table styling */
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

        /* Delete Button styling */
        .deleteBtn {
            background-color: #FF6347;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .deleteBtn:hover {
            background-color: #FF0000;
        }
    </style>
    <div class="page-wrapper">
        <main class="main--container">
            <section class="main--content table-report">
                <div class="panel">
                    <div class="container alert alert-light">
                        <br>
                        <h2>Occurrence Rules</h2>

                        <!-- Add New Occurrence Rule Form -->
                        <form id="occurrenceRuleForm" action="{{ route('admin.occurrenceRulesStore') }}" method="POST">
                            @csrf
                            <label for="ruleName">Rule Name:</label>
                            <input type="text" id="ruleName" name="rule_name" required>

                            <label for="ruleDescription">Description:</label>
                            <textarea id="description" name="description" required></textarea>

                            <label for="ruleTime">Time of Occurrence:</label>
                            <input type="time" id="time_of_occurrence" name="time_of_occurrence" required>
                            {{-- <input type="range" name="range"> --}}
                            <button type="submit">Add Rule</button>
                        </form>

                        <h3>List of Occurrence Rules</h3>

                        <!-- Occurrence Rules Table -->
                        <table id="example">
                            <thead>
                                <tr>
                                    <th>Rule Name</th>
                                    <th>Description</th>
                                    <th>Time of Occurrence</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($occurenceRules as $rule)
                                    <tr>
                                        <td>{{ $rule->rule_name }}</td>
                                        <td>{{ $rule->description }}</td>
                                        <td>{{ $rule->time_of_occurrence }}</td>
                                        <td>
                                            <a href="{{ route('admin.deleteOccurrenceRules', $rule->id) }}"
                                                class="btn btn-danger btn-sm text-white"
                                                data-id="{{ $rule->id }}">Delete</a>
                                        </td>
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
@endsection
