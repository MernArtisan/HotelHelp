@extends('admin.layouts.master')

@section('title', 'Employee Termination Form')

@section('content')
    <div class="page-wrapper">
        <main class="main--container">
            <section class="main--content table-report">
                <div class="panel">
                    <div class="container alert alert-light mt-4">
                        <h1 class="text-center">Employee Termination Form</h1>

                        <form id="terminationForm" class="mt-4" action="{{ route('admin.TerminationPost') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="employee_id">Employee ID</label>
                                <select name="employee_id" id="employee_id" class="form-control"
                                    onchange="populateEmployeeDetails()">
                                    <option value="">Select Employee</option>
                                    @foreach ($employess as $employee)
                                        <option value="{{ $employee->id }}" data-employee-name="{{ $employee->user->first_name }} {{ $employee->user->middle_name }} {{ $employee->user->last_name }}"
                                            data-hotel-name="{{ $employee->hotel->name }}">
                                            {{ $employee->employee_id }} | {{ $employee->user->first_name }} {{ $employee->user->middle_name }} {{ $employee->user->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span id="employeeIdError" class="error"></span>
                            </div>

                            <div class="form-group">
                                <label for="employeeName">Employee Name</label>
                                <input type="text" id="employeeName" name="employee_name" class="form-control" readonly>
                                <span id="employeeNameError" class="error"></span>
                            </div>

                            <div class="form-group">
                                <label for="hotelName">Hotel Name</label>
                                <input type="text" id="hotelName" name="hotel_name" class="form-control" readonly>
                                <span id="hotelNameError" class="error"></span>
                            </div>

                            <div class="form-group">
                                <label for="terminationReason">Termination Reason</label>
                                <select id="terminationReason" name="terminationReason" class="form-control" required>
                                    <option value="">Select Termination Reason</option>
                                    <option value="Performance Issues">Performance Issues</option>
                                    <option value="Resigned">Resigned</option>
                                    <option value="Retirement">Retirement</option>
                                    <option value="Policy Violation">Policy Violation</option>
                                    <option value="Company Restructuring">Company Restructuring</option>
                                    <option value="Other">Other</option>
                                </select>
                                <span id="terminationReasonError" class="error"></span>
                            </div>

                            {{-- <div class="form-group">
                                <label for="terminationDate">Termination Date</label>
                                <input type="date" id="terminationDate" name="terminationDate" class="form-control" required>
                                <span id="terminationDateError" class="error"></span>
                            </div> --}}

                            <div class="form-group">
                                <label for="additionalNotes">Additional Notes</label>
                                <textarea id="additionalNotes" name="additional_notes" rows="4" class="form-control"
                                    placeholder="Enter any additional details..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary" onclick="validateForm()">Submit
                                Termination</button>
                        </form>
                    </div>
                </div>

                {{-- <div class="panel">
                    <div class="container alert alert-light mt-4">
                        <h1 class="text-center">Employee Termination List</h1>

                        <table class="table" id="example">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Hotel Name</th>
                                    <th>Termination Reason</th>
                                    <th>Additional Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employessList as $termination)
                                    <tr>
                                        <td>{{ $termination->employee_id }}</td>
                                        <td>{{ $termination->employee_name }}</td>
                                        <td>{{ $termination->hotel_name }}</td>
                                        <td>{{ $termination->termination_reason }}</td>
                                        <td>{{ $termination->additional_notes }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> --}}
            </section>
        </main>
    </div>
@endsection

@section('scripts')
    <script>
        function populateEmployeeDetails() {
            var employeeSelect = document.getElementById('employee_id');
            var selectedOption = employeeSelect.options[employeeSelect.selectedIndex];

            // Get the employee name and hotel name from the selected option
            var employeeName = selectedOption.getAttribute('data-employee-name');
            var hotelName = selectedOption.getAttribute('data-hotel-name');

            // Populate the employee name and hotel name fields
            document.getElementById('employeeName').value = employeeName || '';
            document.getElementById('hotelName').value = hotelName || '';
        }
    </script>
@endsection
