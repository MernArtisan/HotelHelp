@extends('admin.layouts.master')
@section('title', 'Create Invoice')

@section('content')
    <div class="page-wrapper">
        <main class="main--container">
            <section class="main--content table-report">
                <div class="panel">
                    <h2 class="text-dark text-bold textContent">Create Hotel Invoice</h2>
                </div>
                <div class="panel">
                    <div class="container alert alert-light">
                        <form action="{{ route('admin.InvoiceStore') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="due_date" class="col-2 col-form-label font-weight-bold">Due Date Range:</label>
                                <input type="text" name="due_date" id="due_date" class="form-control"
                                    value="{{ request('due_date') }}" placeholder="Select date range" autocomplete="off"
                                    required>
                            </div>

                            <br>
                            <div class="form-group row">
                                <label for="hotel_id" class="col-2 col-form-label font-weight-bold">Select Hotel:</label>
                                <div class="col-10">
                                    <select class="form-control" name="hotel_id" id="hotel_id" required>
                                        <option value="">Select Hotel</option>
                                        @foreach ($hotels as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="employee-timecards"></div>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $('#hotel_id').on('change', function () {
            const hotelId = $(this).val();
            if (hotelId) {
                $.ajax({
                    url: "{{ route('admin.getHotelEmployees') }}",
                    type: "GET",
                    data: { hotel_id: hotelId },
                    success: function (response) {
                        $('#employee-timecards').html(response.html);
                    }
                });
            } else {
                $('#employee-timecards').empty();
            }
        });
        $(function () {
            $('#due_date').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('#due_date').on('apply.daterangepicker', function (ev, picker) {
                let selectedDateRange = picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD');
                $(this).val(selectedDateRange);

                // Bulk Invoice hidden field update
                $('#bulk_due_date').val(selectedDateRange);

                // Single Invoice hidden fields update
                $('input[name="due_date"][type="hidden"]').val(selectedDateRange);
            });

            $('#due_date').on('cancel.daterangepicker', function () {
                $(this).val('');

                // Bulk Invoice hidden field clear
                $('#bulk_due_date').val('');

                // Single Invoice hidden fields clear
                $('input[name="due_date"][type="hidden"]').val('');
            });
        });

    </script>
@endsection