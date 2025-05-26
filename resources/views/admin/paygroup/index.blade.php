@extends('admin.layouts.master')
@section('title', 'Pay Group')
@section('content')
    <div class="page-wrapper">
        <main class="main--container text-dark">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header text-dark d-flex justify-content-between align-items-center">
                                <h2 class="page-title mb-0">Pay-Group List</h2>
                                <a href="#" class="btn btn-dark btn-sm" data-toggle="modal"
                                    data-target="#createPayGroupModal">
                                    <i class="fas fa-key"></i> + Create New Pay Group
                                </a>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-hover table-bordered table-sm">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Pay Frequency</th>
                                                <th>Payroll Input Method</th>
                                                <th>Payroll Type</th>
                                                <th>Normal Hours</th>
                                                <th>Pay Day of Week</th>
                                                <th>Status</th>
                                                <th width="15%" class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($payGroups as $key => $payGroup)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $payGroup->name ?? '' }}</td>
                                                    <td>{{ ucfirst($payGroup->pay_frequency) ?? '' }}</td>
                                                    <td>{{ ucfirst($payGroup->payroll_input_method) ?? '' }}</td>
                                                    <td>{{ ucfirst($payGroup->payroll_type) ?? '' }}</td>
                                                    <td>{{ $payGroup->normal_hours ?? '' }}</td>
                                                    <td>{{ $payGroup->pay_day_of_week ?? '' }}</td>
                                                    <td>
                                                        @if ($payGroup->status == 'active')
                                                            <button class="btn btn-info btn-sm">Active</button>
                                                        @elseif($payGroup->status == 'block')
                                                            <button class="btn btn-danger btn-sm">Block</button>
                                                        @else
                                                            <button class="btn btn-secondary">N/A</button>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        {{-- <button type="button" class="btn btn-info btn-sm me-2"
                                                            data-toggle="modal" data-target="#viewGroupModal"
                                                            onclick="ShowGroupDetail(
                                                            '{{ $payGroup->name }}', 
                                                            '{{ $payGroup->pay_frequency }}', 
                                                            '{{ $payGroup->payroll_input_method }}', 
                                                            '{{ $payGroup->payroll_type }}', 
                                                            '{{ $payGroup->normal_hours }}', 
                                                            '{{ $payGroup->pay_day_of_week }}', 
                                                            '{{ $payGroup->run_date }}', 
                                                            '{{ $payGroup->inpound_date }}', 
                                                            '{{ $payGroup->period_date }}',  
                                                            '{{ $payGroup->status }}' 
                                                        )">
                                                            <i class="bi bi-eye"></i>
                                                        </button> --}}

                                                        <a href="javascript:void(0)" class="btn btn-warning btn-sm me-2"
                                                            onclick="openEditModal(
                                                                '{{ $payGroup->id }}',
                                                                '{{ $payGroup->name }}',
                                                                '{{ $payGroup->pay_frequency }}',
                                                                '{{ $payGroup->payroll_input_method }}',
                                                                '{{ $payGroup->payroll_type }}',
                                                                '{{ $payGroup->normal_hours }}',
                                                                '{{ $payGroup->pay_day_of_week }}',
                                                                '{{ $payGroup->period_date }}',
                                                                '{{ $payGroup->status }}'
                                                            )">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>

                                                        <form id="delete-form-{{ $payGroup->id }}"
                                                            action="{{ route('admin.pay-group.destroy', $payGroup->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="confirmDelete({{ $payGroup->id }})">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Table --}}
            </div>
        </main>
    </div>

    {{-- Modals --}}
    <div class="modal fade" id="createPayGroupModal" tabindex="-1" aria-labelledby="createPayGroupModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <!-- Added modal-lg class for larger width -->
            <div class="modal-content">
                <div class="modal-header bg-dark ">
                    <h5 class="modal-title text-white" id="createPayGroupModalLabel">Create New Pay Group</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.pay-group.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <!-- Pay Group Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-info text-white">
                                                <i class="fas fa-users"></i> <!-- Icon for name -->
                                            </span>
                                        </div>
                                        <input type="text" name="name" class="form-control" id="name"
                                            placeholder="Enter pay group name" required>
                                    </div>
                                </div>
                            </div>
                            <!-- Pay Frequency -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pay_frequency">Pay Frequency</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-info text-white">
                                                <i class="fas fa-calendar-alt"></i>
                                                <!-- Icon for pay frequency -->
                                            </span>
                                        </div>
                                        <select name="pay_frequency" class="form-control" id="pay_frequency" required>
                                            <option value="weekly">Weekly</option>
                                            <option value="biweekly">Biweekly</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Payroll Input Method -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payroll_input_method">Payroll Input Method</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-info text-white">
                                                <i class="fas fa-keyboard"></i>
                                                <!-- Icon for payroll input method -->
                                            </span>
                                        </div>
                                        {{-- <input type="text" name="payroll_input_method" class="form-control"
                                    id="payroll_input_method" placeholder="Enter payroll input method"
                                    required> --}}
                                        <select name="payroll_input_method" class="form-control" id="">
                                            <option value="manual">Manual</option>
                                            <option value="automatic">automatic</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Payroll Type -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payroll_type">Payroll Type</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-info text-white">
                                                <i class="fas fa-file-alt"></i> <!-- Icon for payroll type -->
                                            </span>
                                        </div>
                                        <input type="text" name="payroll_type" class="form-control" id="payroll_type"
                                            placeholder="Enter payroll type" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Normal Hours -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="normal_hours">Normal Hours</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-info text-white">
                                                <i class="fas fa-clock"></i> <!-- Icon for normal hours -->
                                            </span>
                                        </div>
                                        {{-- <input type="number" name="normal_hours" class="form-control" id="normal_hours"
                                            step="0.01" placeholder="Enter normal hours" required> --}}
                                        <select name="normal_hours" class="form-control" id="normal_hours" required>
                                            <option value="40">40</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Pay Day of Week -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pay_day_of_week">Pay Day of Week</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-info text-white">
                                                <i class="fas fa-calendar-day"></i>
                                                <!-- Icon for pay day of week -->
                                            </span>
                                        </div>
                                        <select name="pay_day_of_week" class="form-control" id="pay_day_of_week"
                                            required>
                                            <option value="Monday">Monday</option>
                                            <option value="Tuesday">Tuesday</option>
                                            <option value="Wednesday">Wednesday</option>
                                            <option value="Thursday">Thursday</option>
                                            <option value="Friday">Friday</option>
                                            <option value="Saturday">Saturday</option>
                                            <option value="Sunday">Sunday</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Period Date -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="period_date">Period Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-info text-white">
                                                <i class="fas fa-calendar-alt"></i>
                                                <!-- Icon for period date -->
                                            </span>
                                        </div>
                                        <input type="text" name="period_date" class="form-control" id="period_date"
                                            placeholder="Enter period date" required>
                                    </div>
                                </div>
                            </div>
                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-info text-white">
                                                <i class="fas fa-toggle-on"></i> <!-- Icon for status -->
                                            </span>
                                        </div>
                                        <select name="status" class="form-control" id="status" required>
                                            <option value="active">Active</option>
                                            <option value="block">Block</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Pay Group</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPayGroupModal" tabindex="-1" role="dialog"
        aria-labelledby="editPayGroupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white" id="createPayGroupModalLabel">Edit Pay Group</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editPayGroupForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="payGroupId" name="id">
                        <div class="modal-body">
                            <div class="row">
                                <!-- Pay Group Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-info text-white">
                                                    <i class="fas fa-users"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="name" class="form-control" id="GroupName"
                                                placeholder="Enter pay group name" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- Pay Frequency -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pay_frequency">Pay Frequency</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-info text-white">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <select name="pay_frequency" class="form-control" id="payFrequency" required>
                                                <option value="weekly">Weekly</option>
                                                <option value="biweekly">Biweekly</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Payroll Input Method -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payroll_input_method">Payroll Input Method</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-info text-white">
                                                    <i class="fas fa-keyboard"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="payroll_input_method" class="form-control"
                                                id="payrollInputMethod" placeholder="Enter payroll input method" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- Payroll Type -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payroll_type">Payroll Type</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-info text-white">
                                                    <i class="fas fa-file-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="payroll_type" class="form-control"
                                                id="payrollType" placeholder="Enter payroll type" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="normal_hours">Normal Hours</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-info text-white">
                                                    <i class="fas fa-clock"></i>
                                                </span>
                                            </div>
                                            <select name="normal_hours" class="form-control" id="normalHours" required>
                                                <option value="40">40</option>
                                                <option value="80">80</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pay Day of Week -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pay_day_of_week">Pay Day of Week</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-info text-white">
                                                    <i class="fas fa-calendar-day"></i>
                                                </span>
                                            </div>
                                            <select name="pay_day_of_week" class="form-control" id="payDayOfWeek"
                                                required>
                                                <option value="Monday">Monday</option>
                                                <option value="Tuesday">Tuesday</option>
                                                <option value="Wednesday">Wednesday</option>
                                                <option value="Thursday">Thursday</option>
                                                <option value="Friday">Friday</option>
                                                <option value="Saturday">Saturday</option>
                                                <option value="Sunday">Sunday</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Period Date -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="period_date">Period Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-info text-white">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="period_date" class="form-control"
                                                id="periodDate" placeholder="Enter period date" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- Status -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-info text-white">
                                                    <i class="fas fa-toggle-on"></i>
                                                </span>
                                            </div>
                                            <select name="status" class="form-control" id="EditGroupStatus" required>
                                                <option value="active">Active</option>
                                                <option value="block">Block</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="submitEditForm()">Save
                                Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <script>
        function ShowGroupDetail(payGroupName, pay_frequency, payroll_input_method, payroll_type, normal_hours,
            pay_day_of_week, period_date, status) {
            document.getElementById('payGroupName').innerText = payGroupName;
            document.getElementById('PayFrequency').innerText = pay_frequency;
            document.getElementById('PayRollInputMethod').innerText = payroll_input_method;
            document.getElementById('PayRollType').innerText = payroll_type;
            document.getElementById('NormalHours').innerText = normal_hours;
            document.getElementById('PayDayOfWeek').innerText = pay_day_of_week;
            // document.getElementById('RunDate').innerText = run_date;
            // document.getElementById('InpoundDate').innerText = inpound_date;
            document.getElementById('PeriodDate').innerText = period_date;
            document.getElementById('GroupStatus').innerText = status;
        }

        function openEditModal(id, name, pay_frequency, payroll_input_method, payroll_type, normal_hours, pay_day_of_week,
            period_date, status) {
            // Set the values of the modal fields
            document.getElementById('payGroupId').value = id;
            document.getElementById('GroupName').value = name;
            document.getElementById('payFrequency').value = pay_frequency;
            document.getElementById('payrollInputMethod').value = payroll_input_method;
            document.getElementById('payrollType').value = payroll_type;

            // Set the value for normal hours (select field)
            const normalHoursSelect = document.getElementById('normalHours');
            if (normalHoursSelect) {
                normalHoursSelect.value = normal_hours;
            }

            document.getElementById('payDayOfWeek').value = pay_day_of_week;
            // document.getElementById('runDate').value = run_date;
            // document.getElementById('inpoundDate').value = inpound_date;
            document.getElementById('periodDate').value = period_date;
            document.getElementById('EditGroupStatus').value = status;

            // Update the form action URL dynamically
            let formAction = '{{ route('admin.pay-group.update', ':id') }}';
            formAction = formAction.replace(':id', id);
            document.getElementById('editPayGroupForm').action = formAction;

            // Show the modal
            $('#editPayGroupModal').modal('show');
        }


        // Function to submit the form
        function submitEditForm() {
            // Submit the form
            document.getElementById('editPayGroupForm').submit();
        }
    </script>

@endsection
