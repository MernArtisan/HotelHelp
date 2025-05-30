@extends('admin.layouts.master')

@section('title')
    {{ isset($employee) ? 'Edit employee' : 'Create New employee' }}
@endsection
@section('content')
    <style>
        label {
            font-weight: bold;
            color: #333;
            position: relative;
        }

        .required {
            color: red
        }

        .mandatory {
            color: rgb(61, 105, 253)
        }

        .is-invalid {
            border-color: red;
        }
    </style>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="offset-1 col-10 offset-1">
                    <div class="main--container">
                        <form enctype="multipart/form-data" id="myForm" method="POST"
                            action="{{ isset($employee) ? route('admin.employees.update', $employee->id) : route('admin.employees.store') }}"
                            onsubmit="showLoader()">
                            @csrf
                            @if (isset($employee))
                                @method('PUT')
                            @endif
                            <div class="card mb-5">
                                <div class="card-header bg-dark text-white">
                                    <h4 class="ml-2">Basic Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="first_name">First Name <span class="required">*</span></label>
                                                <input type="text"
                                                       class="form-control @error('first_name') is-invalid @enderror"
                                                       name="first_name"
                                                       id="first_name"
                                                       value="{{ isset($employee) ? $employee->user->first_name : old('first_name') }}">
                                                @error('first_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="middle_name">Middle Name</label>
                                                <input type="text"
                                                       class="form-control @error('middle_name') is-invalid @enderror"
                                                       name="middle_name"
                                                       id="middle_name"
                                                       value="{{ isset($employee) ? $employee->user->middle_name : old('middle_name') }}">
                                                @error('middle_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="last_name">Last Name <span class="required">*</span></label>
                                                <input type="text"
                                                       class="form-control @error('last_name') is-invalid @enderror"
                                                       name="last_name"
                                                       id="last_name"
                                                       value="{{ isset($employee) ? $employee->user->last_name : old('last_name') }}">
                                                @error('last_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="designation">Designation <span class="required">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('designation') is-invalid @enderror"
                                                    name="designation" id="designation"
                                                    value="{{ isset($employee) ? $employee->designation : old('designation') }}">
                                                @error('designation')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email <span class="required">*</span></label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    id="email"
                                                    value="{{ isset($employee) ? $employee->user->email : old('email') }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- @if (isset($employee))
                                        @else --}}
                                            <div class="col-lg-4 col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Password <span class="required">*</span></label>
                                                    <input type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" id="password" value="{{ old('password') }}">
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        {{-- @endif --}}
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="ssn">SSN <span class="required">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('ssn') is-invalid @enderror" name="ssn"
                                                    id="ssn"
                                                    value="{{ isset($employee) ? $employee->user->ssn : old('ssn') }}">
                                                @error('ssn')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="birth_date">Birth Date <span class="required">*</span></label>
                                                <input type="date"
                                                    class="form-control @error('birth_date') is-invalid @enderror"
                                                    name="birth_date" id="birth_date"
                                                    value="{{ isset($employee) ? $employee->user->birth_date : old('birth_date') }}">
                                                @error('birth_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="marital_status">Marital Status <span
                                                        class="required">*</span></label>
                                                <select name="marital_status"
                                                    class="form-control @error('marital_status') is-invalid @enderror">
                                                    <option value="" disabled
                                                        {{ old('marital_status') == '' ? 'selected' : '' }}>Select Marital
                                                        Status</option>
                                                    <option value="single"
                                                        {{ (isset($employee) && $employee->user->marital_status == 'single') || old('marital_status') == 'single' ? 'selected' : '' }}>
                                                        Single</option>
                                                    <option value="married"
                                                        {{ (isset($employee) && $employee->user->marital_status == 'married') || old('marital_status') == 'married' ? 'selected' : '' }}>
                                                        Married</option>
                                                </select>
                                                @error('marital_status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label for="address">Address <span class="required">*</span></label>
                                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" rows="1">{{ isset($employee) ? $employee->user->address : old('address') }}</textarea>
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                       

                                    </div>
                                </div>
                            </div>



                            <!-- Employment Information -->
                            <div class="card mb-5">
                                <div class="card-header bg-dark text-white">
                                    <h4 class="ml-2">Employment Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="employee_id">Employee ID</label>
                                                <input type="text" class="form-control" name="employee_id"
                                                    id="employee_id"
                                                    value="{{ isset($employee) ? $employee->employee_id : $newEmployeeId }}"
                                                    readonly>

                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="hire_date">Hire Date</label>
                                                <input type="date"
                                                    class="form-control @error('hire_date') is-invalid @enderror"
                                                    name="hire_date" id="hire_date"
                                                    value="{{ isset($employee) ? $employee->hire_date : old('hire_date') }}">
                                                @error('hire_date')
                                                    <div class="invalid-feedback"></div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select name="status"
                                                    class="form-control @error('status') is-invalid @enderror">
                                                    <option value="" disabled
                                                        {{ old('status', isset($employee) ? $employee->status : '') == '' ? 'selected' : '' }}>
                                                        Select Status</option>
                                                    <option value="active"
                                                        {{ old('status', isset($employee) ? $employee->status : '') == 'active' ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="hold"
                                                        {{ old('status', isset($employee) ? $employee->status : '') == 'hold' ? 'selected' : '' }}>
                                                        Hold</option>
                                                    @if (isset($employee))
                                                        <option value="left"
                                                            {{ old('status', isset($employee) ? $employee->status : '') == 'left' ? 'selected' : '' }}>
                                                            Left</option>
                                                    @endif
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="employee_type">Employee Type</label>
                                                <select name="employee_type"
                                                    class="form-control @error('employee_type') is-invalid @enderror">
                                                    <option disabled>Select Employee Type</option>
                                                    <option value="w2"
                                                        {{ isset($employee) && $employee->employee_type == 'w2' ? 'selected' : '' }}>
                                                        W2</option>
                                                    <option value="1099"
                                                        {{ isset($employee) && $employee->employee_type == '1099' ? 'selected' : '' }}>
                                                        1099</option>
                                                </select>
                                                @error('employee_type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <!-- Managerial Assignments -->
                            <div class="card mb-5">
                                <div class="card-header bg-dark text-white">
                                    <h4 class="ml-2">Managerial Assignments</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="assigned_manager">Assigned Manager</label>
                                                <input type="text"
                                                    class="form-control @error('assigned_manager') is-invalid @enderror"
                                                    name="assigned_manager" id="assigned_manager"
                                                    value="{{ isset($employee) ? $employee->assigned_manager : old('assigned_manager') }}">
                                                @error('assigned_manager')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="organization_manager">Organization Manager <span
                                                        class="mandatory">(optional)</span></label>
                                                <input type="text"
                                                    class="form-control  @error('organization_manager') is-invalid @enderror"
                                                    name="organization_manager" id="organization_manager"
                                                    value="{{ isset($employee) ? $employee->organization_manager : old('organization_manager') }}">
                                                @error('organization_manager')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pay Information -->
                            <div class="card mb-5">
                                <div class="card-header bg-dark text-white">
                                    <h4 class="ml-2">Pay Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="pay_group">Pay Group</label>

                                                <select name="pay_group_id" id="pay_group_id"
                                                    class="form-control @error('pay_group_id') is-invalid @enderror">
                                                    <option value="" disabled
                                                        {{ old('pay_group_id', isset($employee) ? $employee->pay_group_id : '') == '' ? 'selected' : '' }}>
                                                        Select Pay Group
                                                    </option>
                                                    @foreach ($payGroup as $group)
                                                        <option value="{{ $group->id }}"
                                                            {{ old('pay_group_id', isset($employee) ? $employee->pay_group_id : '') == $group->id ? 'selected' : '' }}>
                                                            {{ $group->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('pay_group_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="pay_rate">Pay Rate</label>
                                               <input type="text"
                                            class="form-control @error('pay_rate') is-invalid @enderror"
                                            name="pay_rate"
                                            id="pay_rate"
                                            placeholder="Pay Rate"
                                            oninput="this.value = this.value.replace(/^(\d{0,2})(\.\d{0,2})?.*$/, '$1$2');"
                                            value="{{ isset($employee) ? $employee->pay_rate : old('pay_rate') }}">
                                        
                                                @error('pay_rate')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="alternate_pay_rate">Alternate Pay Rate <span class="mandatory">(optional)</span></label>
                                               <input type="text"
                                            class="form-control @error('alternate_pay_rate') is-invalid @enderror"
                                            name="alternate_pay_rate"
                                            id="alternate_pay_rate"
                                            placeholder="Alternate Pay Rate"
                                            oninput="this.value = this.value.replace(/^(\d{0,2})(\.\d{0,2})?.*$/, '$1$2');"
                                            value="{{ isset($employee) ? $employee->alternate_pay_rate : old('alternate_pay_rate') }}">
                                        
                                                @error('alternate_pay_rate')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Location Information -->
                            <div class="card mb-5">
                                <div class="card-header bg-dark text-white">
                                    <h4 class="ml-2">Location Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="hotel_id">Hotel</label>
                                                <select name="hotel_id" id="hotel_id"
                                                    class="form-control @error('hotel_id') is-invalid @enderror"
                                                    onchange="updateLocation()">
                                                    <option value="">Select Hotel</option>
                                                    @foreach ($hotels as $hotel)
                                                        <option value="{{ $hotel->id }}"
                                                            data-location="{{ $hotel->location }}"
                                                            {{ old('hotel_id', isset($employee) ? $employee->hotel_id : '') == $hotel->id ? 'selected' : '' }}>
                                                            {{ $hotel->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('hotel_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="location">Location</label>
                                                <input type="text"
                                                    class="form-control @error('location') is-invalid @enderror"
                                                    id="locations" name="location" readonly
                                                    value="{{ old('location', isset($employee) ? $employee->location : '') }}">
                                                @error('location')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="job_id">Job</label>
                                                <select name="job_id"
                                                    class="form-control @error('job_id') is-invalid @enderror">
                                                    <option value="">Select Job</option>
                                                    @foreach ($jobss as $job)
                                                        <option value="{{ $job->id }}"
                                                            {{ old('job_id', isset($employee) ? $employee->job_id : '') == $job->id ? 'selected' : '' }}>
                                                            {{ $job->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('job_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="job_id">Job</label>
                                                <div class="input-group">
                                                    <select name="job_id" id="jobSelect" class="form-control @error('job_id') is-invalid @enderror">
                                                        <option value="">Select Job</option>
                                                        @foreach ($jobss as $job)
                                                            <option value="{{ $job->id }}"
                                                                {{ old('job_id', isset($employee) ? $employee->job_id : '') == $job->id ? 'selected' : '' }}>
                                                                {{ $job->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <button type="button" class="btn btn-success repeater-1" style="border-radius: 0;padding: 0px 10px;" data-bs-toggle="modal" data-bs-target="#addJobModal">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                                @error('job_id')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="modal fade" id="addJobModal" tabindex="-1" aria-labelledby="addJobModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="addJobModalLabel">Add Job</h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal">X</button>
                                                </div>
                                                <div class="modal-body">
                                                  <input type="text" id="newJobName" class="form-control" placeholder="Enter Job Name">
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" id="saveJobBtn" class="btn btn-primary">Save</button>
                                                </div>
                                              </div>
                                            </div>
                                          </div> 
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="card mb-5">
                                <div class="card-header bg-dark text-white">
                                    <h4 class="ml-2">Additional Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="gender">Gender</label>
                                                <select name="gender" id="gender"
                                                    class="form-control @error('gender') is-invalid @enderror">
                                                    <option value="" disabled
                                                        {{ old('gender', isset($employee) ? $employee->gender : '') == '' ? 'selected' : '' }}>
                                                        Select Gender
                                                    </option>
                                                    <option value="male"
                                                        {{ old('gender', isset($employee) ? $employee->gender : '') == 'male' ? 'selected' : '' }}>
                                                        Male</option>
                                                    <option value="female"
                                                        {{ old('gender', isset($employee) ? $employee->gender : '') == 'female' ? 'selected' : '' }}>
                                                        Female</option>
                                                    <option value="other"
                                                        {{ old('gender', isset($employee) ? $employee->gender : '') == 'other' ? 'selected' : '' }}>
                                                        Other</option>
                                                </select>
                                                @error('gender')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="contact_number">Contact Number</label>
                                                <input type="tel"
                                                    class="form-control @error('contact_number') is-invalid @enderror"
                                                    id="contact_number" name="contact_number"
                                                    placeholder="Enter Your Contact Number"
                                                    value="{{ old('contact_number', isset($employee) ? $employee->user->contact_number : '') }}">
                                                @error('contact_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="select_tier">Select Tiers</label>
                                                <select id="select_tier" name="role"
                                                    class="form-control @error('role') is-invalid @enderror">
                                                    <option value="" disabled
                                                        {{ old('role', isset($roleAssigned) ? $roleAssigned->name : '') == '' ? 'selected' : '' }}>
                                                        Select Role
                                                    </option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->name }}"
                                                            {{ old('role', isset($roleAssigned) ? $roleAssigned->name : '') == $role->name ? 'selected' : '' }}>
                                                            {{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('role')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>




                                        <div class="col-lg-12 col-md-6">
                                            <div class="form-group">
                                                <label for="documents" class="form-label">Attach Documents</label>
                                                <div class="custom-file">
                                                    <input type="file"
                                                        class="custom-file-input @error('documents') is-invalid @enderror"
                                                        id="documents" name="documents" accept="pdf/*">
                                                    @error('documents')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <label class="custom-file-label" for="documents">Choose files</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-6">
                                            <div class="form-group">
                                                <label for="Message">Message <span
                                                        class="mandatory">(optional)</span></label>
                                                <textarea id="message" name="message" rows="5" class="form-control" placeholder="Enter your message">{{ old('message', isset($employee) ? $employee->message : '') }}</textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-success">Submit</button>
                                <button type="button" class="btn btn-warning"
                                    onclick="window.history.back();">Back</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('#saveJobBtn').click(function () {
            const jobName = $('#newJobName').val();
            if (!jobName) {
                Swal.fire('Validation Error', 'Job name is required.', 'warning');
                return;
            }
    
            $.ajax({
                url: "{{ route('admin.jobs.store') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    name: jobName
                },
                success: function (response) {
                    $('#jobSelect').append(`<option value="${response.id}" selected>${response.name}</option>`);
                    $('#addJobModal').modal('hide');
                    $('#newJobName').val('');
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        if (errors && errors.name) {
                            Swal.fire('Error', errors.name[0], 'error');
                        } else {
                            Swal.fire('Error', 'Something went wrong.', 'error');
                        }
                    } else {
                        Swal.fire('Error', 'Server error occurred.', 'error');
                    }
                }
            });
        });
    </script>
@endsection
@section('scripts')
    <script>
        function updateLocation() {
            var hotelSelect = document.getElementById('hotel_id');
            var selectedHotel = hotelSelect.options[hotelSelect.selectedIndex];
            var location = selectedHotel.getAttribute('data-location');

            document.getElementById('locations').value = location;
        }
    </script>
@endsection
