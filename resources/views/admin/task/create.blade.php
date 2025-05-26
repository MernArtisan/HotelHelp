@extends('admin.layouts.master')

@section('title', 'Add Task')

@section('content')
<main class="main--container">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }} 
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }} 
                    </div>
                @endif

                <div class="card shadow">
                    <div class="card-header bg-white">
                        <h3 class="mb-0 fw-bold">Add Task</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.TaskStore') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="hotel_id" class="form-label fw-bold">Select Hotel</label>
                                <select class="form-control" name="hotel_id" id="hotel-select" required>
                                    <option value="">Select Hotel</option>
                                    @foreach ($hotels as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Due Date</label>
                                <input type="date" class="form-control" name="due_date" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Task Number</label>
                                <div>{{ $lastTaskId }}</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Task Date</label>
                                <div>{{ now()->format('Y-m-d') }}</div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="TaskItemsTable">
                                    <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Employee</th>
                                            <th>Employee Rate</th>
                                            <th>Platform Fee</th>
                                            <th>Time (hrs/day)</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                            <button type="button" class="btn btn-outline-primary my-3" onclick="addTaskItem()">+ Add Row</button>

                            <div class="text-end fw-bold mb-3">
                                Subtotal: $<span id="subtotal">0.00</span>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-success">Save Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    let itemIndex = 0;
    let employeesData = [];

    function getSelectedEmployeeIds() {
        const selected = [];
        document.querySelectorAll('.employee-select').forEach(select => {
            const val = select.value;
            if (val) selected.push(val);
        });
        return selected;
    }

    function addTaskItem() {
        const tbody = document.querySelector('#TaskItemsTable tbody');
        const selectedIds = getSelectedEmployeeIds();
        let employeeOptions = `<option value="">Select Employee</option>`;

        employeesData.forEach(emp => {
            if (!selectedIds.includes(String(emp.id))) {
                const fullName = `${emp.user?.first_name ?? ''} ${emp.user?.last_name ?? ''}`;
                employeeOptions += `<option value="${emp.id}" data-pay="${emp.pay_rate}">${fullName}</option>`;
            }
        });

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
                <select name="items[${itemIndex}][employee_id]" class="form-control employee-select" required onchange="setPayRate(this)">
                    ${employeeOptions}
                </select>
            </td>
            <td><input type="number" name="items[${itemIndex}][price_per_unit]" class="form-control" readonly></td>
            <td><input type="number" name="items[${itemIndex}][platform_fee]" class="form-control" required onchange="calculateRow(this)"></td>
            <td><input type="number" name="items[${itemIndex}][time]" class="form-control" required onchange="calculateRow(this)"></td>
            <td><input type="date" name="items[${itemIndex}][start_date]" class="form-control" required onchange="calculateRow(this)"></td>
            <td><input type="date" name="items[${itemIndex}][end_date]" class="form-control" required onchange="calculateRow(this)"></td>
            <td><input type="number" name="items[${itemIndex}][total]" class="form-control" readonly></td>
            <td><button type="button" class="btn btn-danger" onclick="removeTaskItem(this)">X</button></td>
        `;
        tbody.appendChild(row);
        itemIndex++;
    }

    function setPayRate(select) {
        const payRate = select.selectedOptions[0].getAttribute('data-pay');
        const row = select.closest('tr');
        if (row && payRate) {
            row.querySelector('input[name*="[price_per_unit]"]').value = parseFloat(payRate);
            calculateRow(select);
        }
        refreshEmployeeDropdowns();
    }

    function calculateRow(element) {
        const row = element.closest('tr');
        const time = parseFloat(row.querySelector('input[name*="[time]"]').value) || 0;
        const rate = parseFloat(row.querySelector('input[name*="[price_per_unit]"]').value) || 0;
        const fee = parseFloat(row.querySelector('input[name*="[platform_fee]"]').value) || 0;
        const start = new Date(row.querySelector('input[name*="[start_date]"]').value);
        const end = new Date(row.querySelector('input[name*="[end_date]"]').value);

        let dayCount = 0;
        if (start.toString() !== 'Invalid Date' && end.toString() !== 'Invalid Date') {
            const diffTime = Math.abs(end - start);
            dayCount = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;
        }

        const total = ((rate + fee) * time * dayCount).toFixed(2);
        row.querySelector('input[name*="[total]"]').value = total;
        updateSubtotal();
    }

    function updateSubtotal() {
        let subtotal = 0;
        document.querySelectorAll('input[name*="[total]"]').forEach(field => {
            subtotal += parseFloat(field.value) || 0;
        });
        document.getElementById('subtotal').innerText = subtotal.toFixed(2);
    }

    function removeTaskItem(button) {
        const row = button.closest('tr');
        row.remove();
        updateSubtotal();
        refreshEmployeeDropdowns();
    }

    function refreshEmployeeDropdowns() {
        const selectedIds = getSelectedEmployeeIds();
        document.querySelectorAll('.employee-select').forEach(select => {
            const currentVal = select.value;
            const row = select.closest('tr');
            select.innerHTML = `<option value="">Select Employee</option>`;
            employeesData.forEach(emp => {
                const fullName = `${emp.user?.first_name ?? ''} ${emp.user?.last_name ?? ''}`;
                if (!selectedIds.includes(String(emp.id)) || String(emp.id) === currentVal) {
                    select.innerHTML += `<option value="${emp.id}" data-pay="${emp.pay_rate}" ${String(emp.id) === currentVal ? 'selected' : ''}>${fullName}</option>`;
                }
            });
        });
    }

    document.getElementById('hotel-select').addEventListener('change', function () {
        const hotelId = this.value;
        if (!hotelId) return;

        fetch(`/get-employees/${hotelId}`)
            .then(res => res.json())
            .then(data => {
                employeesData = data;
                document.querySelector('#TaskItemsTable tbody').innerHTML = '';
                itemIndex = 0;
                addTaskItem();
            });
    });
</script>
@endsection
