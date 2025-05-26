@extends('admin.layouts.master')

@section('title', 'Tasks')
@section('content')
    <div class="page-wrapper">
        <main class="main--container text-dark">
            <div class="container-fluid">
                <!-- Card for Heading and Create Button -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header text-dark d-flex justify-content-between align-items-center">
                                <h2 class="page-title mb-0">Tasks List</h2>
                                <!-- Create Permission Button with Icon -->
                                <a href="{{ route('admin.task') }}" class="btn btn-dark btn-sm">
                                    <i class="fas fa-key"></i> + Create New Tasks
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permission Table -->
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <div style="overflow-x: auto; width: 100%;">
                                    <table id="example" class="table table-striped table-hover table-bordered table-sm" style="min-width: 1800px;">
                                        <thead class="bg-light">
                                            <tr>
                                                <th width="0%">Task No</th>
                                                <th width="14%">Hotel Name</th>
                                                <th>Service</th>
                                                <th>Employee</th>
                                                <th>Hours</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Unit Price</th>
                                                <th>Platform Fee</th>
                                                <th>Total</th>
                                                <th>task Date</th>
                                                <th>Revenue</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                {{-- <th class="text-center">Actions</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tasks as $task)
                                                <tr>
                                                    <td>{{ $task->task_number }}</td>
                                                    <td>{{ $task->hotel->name ?? '' }}</td>
                                                    <td>{!! $task->items->pluck('service')->map(fn($s) => "<div>$s</div>")->implode('') !!}</td>
                                                    <td>
                                                        @foreach ($task->items as $item)
                                                            <div>{{ optional($item->employee?->user)->first_name }} {{ optional($item->employee?->user)->middle_name }} {{ optional($item->employee?->user)->last_name }}</div>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        {!! $task->items->pluck('time')->map(function($t) {
                                                            return '<div>(' . (fmod($t, 1) == 0.0 ? (int)$t : $t) . ')</div>';
                                                        })->implode('') !!}
                                                    </td>

                                                    <td>{!! $task->items->pluck('start_date')->map(fn($t) => "<div>($t)</div>")->implode('') !!}</td>
                                                    <td>{!! $task->items->pluck('end_date')->map(fn($t) => "<div>($t)</div>")->implode('') !!}</td>
                                                    <td class="text-center">
                                                        {!! $task->items->pluck('price_per_unit')->map(function($p) {
                                                            $formatted = fmod($p, 1) == 0.0 ? (int)$p : number_format($p, 2);
                                                            return "<div>\$$formatted</div>";
                                                        })->implode('') !!}
                                                    </td>
                                                     <td class="text-center">
                                                        {!! $task->items->pluck('platform_fee')->map(function($p) {
                                                            $formatted = fmod($p, 1) == 0.0 ? (int)$p : number_format($p, 2);
                                                            return "<div>\$$formatted</div>";
                                                        })->implode('') !!}
                                                    </td>
                                                    <td>{!! $task->items->pluck('total')->map(fn($t) => "<div>$$t</div>")->implode('') !!}</td>
                                                    <td>{{ $task->task_date ?? '' }}</td>
                                                    <td>${{ $task->total_amount ?? '' }}</td>
                                                    <td>{{ $task->due_date ?? '' }}</td>
                                                    <td>
                                                        @php $dueDate = \Carbon\Carbon::parse($task->due_date); @endphp
                                                        @if ($task->status == 'unpaid' && $dueDate->isPast())
                                                            <button class="btn btn-danger btn-sm">Unpaid - Overdue</button>
                                                        @elseif ($task->status == 'unpaid')
                                                            <button class="btn btn-warning btn-sm">Unpaid</button>
                                                        @elseif ($task->status == 'paid')
                                                            <button class="btn btn-success btn-sm">Paid</button>
                                                        @else
                                                            <button class="btn btn-secondary btn-sm">N/A</button>
                                                        @endif
                                                    </td>
                                                    {{-- <td class="text-center">
                                                        <a href="{{ route('admin.invoices.download', $task->id) }}" class="btn btn-dark btn-sm">
                                                            <i class="bi bi-printer"></i>
                                                        </a>
                                                    </td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="modal fade" id="viewInvoiceModal" tabindex="-1" aria-labelledby="viewInvoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewInvoiceModalLabel">Invoice Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Invoice Details Form -->
                    <form>
                        <div class="mb-3">
                            <label for="invoice_number" class="form-label">Invoice Number</label>
                            <input type="text" class="form-control" id="invoice_number" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="invoice_date" class="form-label">Invoice Date</label>
                            <input type="text" class="form-control" id="invoice_date" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="text" class="form-control" id="due_date" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="total_amount" class="form-label">Total Amount</label>
                            <input type="text" class="form-control" id="total_amount" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" class="form-control" id="status" readonly>
                        </div>

                        <!-- Invoice Items Table -->
                        <h5>Invoice Items</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Quantity</th>
                                    <th>Time</th>
                                    <th>Price Per Unit</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="invoice_items_body">
                                <!-- Invoice items will be appended here by JS -->
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showInvoiceDetails(invoice_number, invoiceDate, dueDate, totalAmount, status, invoiceItems) {
            console.log(invoiceItems); // Check if items are passed correctly

            document.getElementById('invoice_number').value = invoice_number;
            document.getElementById('invoice_date').value = invoiceDate;
            document.getElementById('due_date').value = dueDate;
            document.getElementById('total_amount').value = totalAmount;
            document.getElementById('status').value = status;

            const invoiceItemsBody = document.getElementById('invoice_items_body');
            invoiceItemsBody.innerHTML = ''; // Clear previous items

            // Loop through invoice items and append to table
            invoiceItems.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${item.service}</td>
                <td>${item.quantity}</td>
                <td>${item.time}</td>
                <td>${item.price_per_unit}</td>
                <td>${item.total}</td>
            `;
                invoiceItemsBody.appendChild(row);
            });

            // Show the modal
            var myModal = new bootstrap.Modal(document.getElementById('viewInvoiceModal'));
            myModal.show();
        }
    </script>
@endsection