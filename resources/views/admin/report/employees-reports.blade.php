@extends('admin.layouts.master')

@section('title', 'Employee Report')
@section('content')

    <!-- ✅ Load jQuery first -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- ✅ Then load Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <div class="page-wrapper">
        <main class="main--container">
            <section class="main--content table-report">
                <div class="panel">
                    <div class="container alert alert-light">
                        <h2>Employees Report</h2>
                        <table class="table" id="example">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Employee Paid</th>
                                    <th>Date</th>
                                    <th>Hotel Name</th>
                                    <th class="not-sortable">Status</th>
                                    <th>Action</th> <!-- Added for the Mark as Paid button -->
                                </tr>
                            </thead>
                            <tbody id="table">
                                @foreach ($employeeTimecardsTotal as $report)
                                    <tr>
                                        <td>
                                            {{ $report['first_name'] ?? '' }}
                                            {{ $report['middle_name'] ?? '' }}
                                            {{ $report['last_name'] ?? '' }}
                                        </td>

                                        <td>{{ $report['email'] ?? 'N/A' }}</td>
                                        <td>${{ number_format($report['total_amount'], 2) }}</td>
                                        <td>{{ date('d-m-Y') }}</td>
                                        <td>{{ $report['hotel'] ?? 'N/A' }}</td>
                                        <td><span class="label label-warning">{{ $report['status'] }}</span></td>

                                        <td>
                                            <button type="button" class="btn btn-primary employee-mark-as-paid"
                                                data-employee="{{ $report['first_name'] }} {{ $report['middle_name'] }} {{ $report['last_name'] }}"
                                                data-employeeid="{{ $report['employee_id'] }}">
                                                MARK AS PAID
                                            </button>


                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
            </section>
        </main>

        <div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="payForm" action="{{ route('admin.markAsPaid') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">MARK AS PAID FOR <span id="employeeName" class="text-primary"></span>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="employee_id" id="employeeId">

                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Total Amount</label>
                                <input type="text" name="total_amount" id="total_amount" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary close" style="background-color: grey;padding: 10px;" data-dismiss="modal">CLOSE</button>
                            <button type="submit" class="btn btn-success">CONFIRM PAYMENT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>



@endsection
@section('scripts')
    <script>

        $(document).ready(function () {
            $('.employee-mark-as-paid').on('click', function () {
                const employeeName = $(this).data('employee');
                const employeeId = $(this).data('employeeid');

                $('#employeeName').text(employeeName);
                $('#employeeId').val(employeeId);

                $('#payModal').modal('show');
            });

            $('.close').on('click', function () {
                $('#payModal').modal('hide');
            })

        });



        $(document).ready(function () {

            $('#end_date').on('change', function () {
                var employeeId = $('#employeeId').val();
                var startDate = $('#start_date').val();
                var endDate = $(this).val();

                if (startDate && endDate && employeeId) {
                    $.ajax({
                        url: "{{ route('admin.calculateAmount') }}",
                        method: "POST",
                        data: {
                            employee_id: employeeId,
                            start_date: startDate,
                            end_date: endDate,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            $('#total_amount').val(response.total_amount);
                        }
                    });
                }
            });
        });
    </script>

@endsection