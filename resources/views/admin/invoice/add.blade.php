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
                            <label for="due_date" class="col-2 col-form-label font-weight-bold">Due Date:</label>
                            <div class="col-10">
                                <input type="date" class="form-control" name="due_date" required>
                            </div>
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
</script>
@endsection
