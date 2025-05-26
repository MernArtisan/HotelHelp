@extends('admin.layouts.master')

@section('title', 'Add Task')
@section('content')
    <style>
        label, thead, .total-row { font-size: 17px; color: #333 }
    </style>

    <div class="page-wrapper">
        <main class="main--container">
            <section class="table-responsive"> 
                <div class="panel">
                    <h2 class="text-dark text-bold text-center">Add Task</h2>
                    <div class="container alert alert-light">
                        <form action="{{ route('admin.InvoiceStore') }}" method="POST">
                            @csrf

                            <div class="form-group row">
                                <label for="hotel_id" class="col-12 col-form-label font-weight-bold">Select Hotel:</label>
                                <div class="col-12">
                                    <select class="form-control" name="hotel_id" id="hotel-select" required>
                                        <option value="">Select Hotel</option>
                                        @foreach ($hotels as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="due_date" class="col-12 col-form-label font-weight-bold">Due Date:</label>
                                <div class="col-12">
                                    <input type="date" class="form-control" name="due_date" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-form-label font-weight-bold">Invoice Number:</label>
                                <div class="col-10">
                                    <span>{{ $lastInvoiceId }}</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-form-label font-weight-bold">Invoice Date:</label>
                                <div class="col-10">
                                    <span>{{ now()->format('Y-m-d') }}</span>
                                </div>
                            </div>


                            <!-- Invoice Items Table -->
                            <table id="invoiceItemsTable" class="table table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th width="30%">Service</th>
                                        <th width="30%">Employee</th>
                                        <th width="10%">Time (hrs)</th>
                                        <th width="10%">Start Date</th>
                                        <th width="10%">End Date</th>
                                        <th width="10%">Price/Hour</th>
                                        <th width="10%">Total</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="items[0][service]" class="form-control" required>
                                                <option value="">Select Service</option>
                                                @foreach ($jobs as $job)
                                                    <option value="{{ $job->name }}">{{ $job->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="items[0][employee_id]" class="form-control employee-select" required>
                                                <option value="">Select Employee</option>
                                            </select>
                                        </td>
                                        <td><input type="number" name="items[0][time]" class="form-control" min="0" required></td>
                                        <td><input type="date" name="items[0][start_date]" class="form-control" required></td>
                                        <td><input type="date" name="items[0][end_date]" class="form-control" required></td>
                                        <td><input type="number" name="items[0][price_per_unit]" class="form-control" required></td>
                                        <td><input type="number" name="items[0][total]" class="form-control" readonly></td>
                                        <td><button type="button" class="btn btn-danger" onclick="removeInvoiceItem(this)">X</button></td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="button" class="btn btn-primary" onclick="addInvoiceItem()">+</button>

                            <div class="total-row text-right mt-2">
                                <strong>Subtotal: $</strong><span id="subtotal">0.00</span>
                            </div>

                            <div class="button-container text-right mt-3">
                                <button type="submit" class="btn btn-success">Send | Save Invoice</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection

@section('scripts')
<script>
    let itemIndex = 1;

    function addInvoiceItem() {
        const tbody = document.querySelector('#invoiceItemsTable tbody');
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>
                <select name="items[${itemIndex}][service]" class="form-control" required>
                    <option value="">Select Service</option>
                    @foreach ($jobs as $job)
                        <option value="{{ $job->name }}">{{ $job->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="items[${itemIndex}][employee_id]" class="form-control employee-select" required>
                    <option value="">Select Employee</option>
                </select>
            </td>
            <td><input type="number" name="items[${itemIndex}][time]" class="form-control" required></td>
            <td><input type="date" name="items[${itemIndex}][start_date]" class="form-control" required></td>
            <td><input type="date" name="items[${itemIndex}][end_date]" class="form-control" required></td>
            <td><input type="number" name="items[${itemIndex}][price_per_unit]" class="form-control" required></td>
            <td><input type="number" name="items[${itemIndex}][total]" class="form-control" readonly></td>
            <td><button type="button" class="btn btn-danger" onclick="removeInvoiceItem(this)">X</button></td>
        `;

        tbody.appendChild(row);
        itemIndex++;
        updateSubtotal();
        populateEmployees();
    }

    function removeInvoiceItem(button) {
        const row = button.closest('tr');
        if (document.querySelectorAll('#invoiceItemsTable tbody tr').length > 1) {
            row.remove();
            updateSubtotal();
        } else {
            alert("At least one row is required.");
        }
    }

    function updateSubtotal() {
        let subtotal = 0;
        document.querySelectorAll('input[name*="[total]"]').forEach(field => {
            subtotal += parseFloat(field.value) || 0;
        });
        document.getElementById('subtotal').innerText = subtotal.toFixed(2);
    }

    document.addEventListener('input', function (event) {
        const row = event.target.closest('tr');
        if (row) {
            const time = parseFloat(row.querySelector('input[name*="[time]"]').value) || 0;
            const rate = parseFloat(row.querySelector('input[name*="[price_per_unit]"]').value) || 0;
            const total = (time * rate).toFixed(2);
            row.querySelector('input[name*="[total]"]').value = total;
            updateSubtotal();
        }
    });

    // AJAX Load Employees when hotel is selected
    document.getElementById('hotel-select').addEventListener('change', function () {
        populateEmployees();
    });

    function populateEmployees() {
        const hotelId = document.getElementById('hotel-select').value;
        if (!hotelId) return;

        fetch(`/get-employees/${hotelId}`)
            .then(res => res.json())
            .then(data => {
                document.querySelectorAll('.employee-select').forEach(select => {
                    select.innerHTML = `<option value="">Select Employee</option>`;
                    data.forEach(emp => {
                        const fullName = `${emp.user?.first_name ?? ''} ${emp.user?.last_name ?? ''}`;
                        select.innerHTML += `<option value="${emp.id}">${fullName}</option>`;
                    });
                });
            });
    }
</script>
@endsection
