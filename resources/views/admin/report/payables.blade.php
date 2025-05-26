@extends('admin.layouts.master')

@section('title', 'Employee Report')
@section('content')
    <div class="page-wrapper">
        <main class="main--container">
            <section class="main--content table-report">
                <div class="panel">
                    <div class="container alert alert-light">
                        <h2>Payable</h2>
                        <br>
                        <input id="search" type="text" class="form-control" placeholder="Search for name and email......">
                        <br>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Employe Paid</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="table">
                                @foreach ($employees as $item)
                                    @foreach ($item->timecards as $timecard)
                                        <tr>
                                            <td>{{ $item->user->first_name }} {{ $item->user->middle_name }} {{ $item->user->last_name }}</td> <!-- Employee Name -->
                                            <td>{{ $item->user->email }}</td> <!-- Employee Email -->
                                            <td>${{ $timecard->total_amount }}</td> <!-- Total Amount -->
                                            <td>{{ $timecard->date }}</td> <!-- Timecard Date -->
                                        </tr>
                                    @endforeach
                                @endforeach

                            </tbody>
                        </table>
                    </div>
            </section>
        </main>
    </div>



@endsection
@section('scripts')
    <script>
        $("#search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#table tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    </script>
@endsection
