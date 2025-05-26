@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('content')
    <div class="page-wrapper">
        <main class="main--container">
            <section class="main--content">
                <div class="row gutter-20">
                    <div class="col-lg-6">
                        <div class="panel profile-cover">
                            <div class="profile-cover__img">
                                <img src="{{ asset(Auth::user()->image ? Auth::user()->image : 'admin/assets/img/avatars/01_150x150.png') }}" 
                                alt="Profile Picture of {{ Auth::user()->name }}">
                           
                                <h3 class="h3">{{ Auth::user()->name }}</h3>
                            </div>
                            <div class="profile-cover__info">
                                <ul class="nav">
                                    <li><strong>{{$employeesActive->count()}}</strong> Workers</li>
                                    <li><strong>{{$hotelsActive->count()}}</strong> Active Hotels</li>
                                    <li><strong>{{$totalHotels->count()}}</strong> Total Hotels</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <!-- Panel Start -->
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">About Me</h3>
                            </div>

                            <div class="panel-content panel-about">
                                <p>{{ Auth::user()->about ?? 'No description yet' }}</p>

                                <table class="table table-borderless">
                                    <tr>
                                        <th><i class="fas fa-briefcase"></i> Role</th>
                                        <td>Tiar 1</td>
                                    </tr>
                                    
                                    <tr>
                                        <th><i class="fas fa-birthday-cake"></i> Date of Birth</th>
                                        <td>13 June 1983</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-map-marker-alt"></i> Location</th>
                                        <td>{{ Auth::user()->address }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-mobile-alt"></i> Mobile No.</th>
                                        <td><a href="tel:7328397510" class="btn-link">{{ Auth::user()->contact_number }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-globe"></i> Website</th>
                                        <td><a href="https://example.com" class="btn-link" target="_blank"
                                                rel="noopener noreferrer">{{ env('APP_URL') }}</a></td>
                                    </tr>
                                </table>

                                <div class="panel-buttons">
                                    <!-- Button to open Edit Profile modal -->
                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                        data-target="#editProfileModal">
                                        Edit Profile
                                    </button>

                                    <a href="#" class="btn btn-warning" data-toggle="modal"
                                        data-target="#changePasswordModal">
                                        <i class="fas fa-key"></i> Change Password
                                    </a>
                                </div>

                                @if (session('success'))
                                    <div class="alert alert-success mt-3">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger mt-3">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="changePasswordForm" method="POST" action="{{ route('admin.updatePassword') }}">
                    @csrf
                    <div class="modal-body">
                        <!-- Old Password Input -->
                        <div class="form-group">
                            <label for="old_password">Old Password</label>
                            <input type="password" class="form-control" id="old_password" name="old_password" required>
                            @error('old_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- New Password Input -->
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <small id="newPasswordError" class="text-danger d-none">Password must be at least 8 characters
                                long.</small>
                            @error('new_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="form-group">
                            <label for="new_password_confirmation">Confirm New Password</label>
                            <input type="password" class="form-control" id="new_password_confirmation"
                                name="new_password_confirmation" required>
                            <small id="confirmPasswordError" class="text-danger d-none">Passwords do not match.</small>
                            @error('new_password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="submitBtn" class="btn btn-primary" disabled>Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog"
        aria-labelledby="editProfileLabel"aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white" id="editProfileLabel">Edit Profile</h5>
                    <button type="button" class="" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form method="POST" action="{{ route('admin.updateProfile') }}" id="editProfileForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <!-- Name Input (1st Column) -->
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ Auth::user()->name }}" required>
                                    </div>
                                    <small id="nameError" class="text-danger" style="display:none;"></small>
                                </div>

                                <!-- Email Input (2nd Column) -->
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ Auth::user()->email }}" readonly>
                                    </div>
                                    <small id="emailError" class="text-danger" style="display:none;"></small>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Phone Input (1st Column) -->
                                <div class="col-md-6 mb-3">
                                    <label for="contact_number" class="form-label">Phone Number</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fas fa-phone-alt"></i></div>
                                        <input type="text" class="form-control" id="contact_number"
                                            name="contact_number" value="{{ Auth::user()->contact_number }}" required>
                                    </div>
                                    <small id="phoneError" class="text-danger" style="display:none;"></small>
                                </div>

                                <!-- Birth Date Input (2nd Column) -->
                                <div class="col-md-6 mb-3">
                                    <label for="birth_date" class="form-label">Birth Date</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                        <input type="date" class="form-control" id="birth_date" name="birth_date"
                                            value="{{ Auth::user()->birth_date ? \Carbon\Carbon::parse(Auth::user()->birth_date)->format('Y-m-d') : '' }}"
                                            required>
                                    </div>
                                    <small id="birthDateError" class="text-danger" style="display:none;"></small>
                                </div>
                            </div>

                            <div class="row">
                                <!-- SSN Input (1st Column) -->
                                <div class="col-md-6 mb-3">
                                    <label for="ssn" class="form-label">Social Security Number (SSN)</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fas fa-id-card"></i></div>
                                        <input type="text" class="form-control" id="ssn" name="ssn"
                                            value="{{ Auth::user()->ssn }}" required>
                                    </div>
                                    <small id="ssnError" class="text-danger" style="display:none;"></small>
                                </div>

                                <!-- Marital Status Input (2nd Column) -->
                                <div class="col-md-6 mb-3">
                                    <label for="marital_status" class="form-label">Marital Status</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fas fa-heart"></i></div>
                                        <select class="form-control" id="marital_status" name="marital_status" required>
                                            <option value="single"
                                                {{ Auth::user()->marital_status == 'single' ? 'selected' : '' }}>Single
                                            </option>
                                            <option value="married"
                                                {{ Auth::user()->marital_status == 'married' ? 'selected' : '' }}>Married
                                            </option>
                                            <option value="divorced"
                                                {{ Auth::user()->marital_status == 'divorced' ? 'selected' : '' }}>Divorced
                                            </option>
                                            <option value="widowed"
                                                {{ Auth::user()->marital_status == 'widowed' ? 'selected' : '' }}>Widowed
                                            </option>
                                        </select>
                                    </div>
                                    <small id="maritalStatusError" class="text-danger" style="display:none;"></small>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Gender Input (1st Column) -->
                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fas fa-venus-mars"></i></div>
                                        <select class="form-control" id="gender" name="gender" required>
                                            <option value="male" {{ Auth::user()->gender == 'male' ? 'selected' : '' }}>
                                                Male</option>
                                            <option value="female"
                                                {{ Auth::user()->gender == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other"
                                                {{ Auth::user()->gender == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    <small id="genderError" class="text-danger" style="display:none;"></small>
                                </div>

                                <!-- Address Input (2nd Column) -->
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fas fa-map-marker-alt"></i></div>
                                        <textarea name="address" id="address" class="form-control" rows="3">{{ Auth::user()->address }}</textarea>
                                    </div>
                                    <small id="addressError" class="text-danger" style="display:none;"></small>
                                </div>
                            </div>

                            <div class="row">
                                <!-- About Me Input (Full Width) -->
                                <div class="col-12 mb-3">
                                    <label for="about" class="form-label">About Me</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fas fa-user-edit"></i></div>
                                        <textarea name="about" id="about" class="form-control" rows="3">{{ Auth::user()->about }}</textarea>
                                    </div>
                                    <small id="aboutError" class="text-danger" style="display:none;"></small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="image" class="form-label">Profile Image</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fas fa-image"></i></div>
                                        <!-- Display current image -->
                                        <img id="currentImage" src="{{ Auth::user()->image ? asset( Auth::user()->image) : asset('admin/assets/img/avatars/01_150x150.png') }}"
                                             alt="Profile Image" class="img-fluid" style="max-width: 150px;">
                                    </div>
                                    <!-- Buttons to select or remove the image -->
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-info" id="selectImageBtn">Select Image</button>
                                        <button type="button" class="btn btn-danger" id="removeImageBtn" style="display: none;">Remove Image</button>
                                        <input type="file" class="form-control d-none" id="image" name="image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer with Buttons -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="updateProfileBtn" disabled>Update
                            Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
         document.getElementById('selectImageBtn').addEventListener('click', function() {
        // Trigger file input click
        document.getElementById('image').click();
    });

    document.getElementById('image').addEventListener('change', function(event) {
        // If a new image is selected
        if (event.target.files.length > 0) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('currentImage').src = e.target.result;
                document.getElementById('removeImageBtn').style.display = 'inline-block';
                document.getElementById('updateProfileBtn').disabled = false;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    });

    document.getElementById('removeImageBtn').addEventListener('click', function() {
        // Remove the image
        document.getElementById('currentImage').src = "{{ asset('admin/assets/img/avatars/01_150x150.png') }}";
        document.getElementById('image').value = ''; // Clear the file input
        document.getElementById('removeImageBtn').style.display = 'none';
        document.getElementById('updateProfileBtn').disabled = false;
    });
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('editProfileForm');
            const updateProfileBtn = document.getElementById('updateProfileBtn');

            // Real-time validation for the form fields
            form.addEventListener('input', function() {
                let isValid = true;

                // Check Name Field
                const name = document.getElementById('name').value.trim();
                const nameError = document.getElementById('nameError');
                if (name === "") {
                    isValid = false;
                    nameError.textContent = "Full Name is required.";
                    nameError.style.display = 'block';
                } else {
                    nameError.style.display = 'none';
                }

                // Check Phone Number Field
                const phone = document.getElementById('contact_number').value.trim();
                const phonePattern = /^[0-9]{10}$/;
                const phoneError = document.getElementById('phoneError');
                if (!phonePattern.test(phone)) {
                    isValid = false;
                    phoneError.textContent = "Please enter a valid 10-digit phone number.";
                    phoneError.style.display = 'block';
                } else {
                    phoneError.style.display = 'none';
                }

                // Check SSN Field
                const ssn = document.getElementById('ssn').value.trim();
                const ssnError = document.getElementById('ssnError');
                if (ssn === "") {
                    isValid = false;
                    ssnError.textContent = "SSN is required.";
                    ssnError.style.display = 'block';
                } else {
                    ssnError.style.display = 'none';
                }

                // Check Birth Date Field
                const birthDate = document.getElementById('birth_date').value.trim();
                const birthDateError = document.getElementById('birthDateError');
                if (birthDate === "") {
                    isValid = false;
                    birthDateError.textContent = "Birth Date is required.";
                    birthDateError.style.display = 'block';
                } else {
                    birthDateError.style.display = 'none';
                }

                // Check Address Field
                const address = document.getElementById('address').value.trim();
                const addressError = document.getElementById('addressError');
                if (address === "") {
                    isValid = false;
                    addressError.textContent = "Address is required.";
                    addressError.style.display = 'block';
                } else {
                    addressError.style.display = 'none';
                }

                // Check Gender Field
                const gender = document.getElementById('gender').value;
                const genderError = document.getElementById('genderError');
                if (gender === "") {
                    isValid = false;
                    genderError.textContent = "Gender is required.";
                    genderError.style.display = 'block';
                } else {
                    genderError.style.display = 'none';
                }

                // Enable or Disable Submit Button
                updateProfileBtn.disabled = !isValid;
            });
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('changePasswordForm');
            const oldPasswordInput = document.getElementById('old_password');
            const newPasswordInput = document.getElementById('new_password');
            const confirmPasswordInput = document.getElementById('new_password_confirmation');
            const submitBtn = document.getElementById('submitBtn');
            const newPasswordError = document.getElementById('newPasswordError');
            const confirmPasswordError = document.getElementById('confirmPasswordError');

            function validateForm() {
                let isValid = true;

                // Validate new password length
                if (newPasswordInput.value.length < 8) {
                    newPasswordError.classList.remove('d-none');
                    isValid = false;
                } else {
                    newPasswordError.classList.add('d-none');
                }

                // Validate password confirmation
                if (newPasswordInput.value !== confirmPasswordInput.value) {
                    confirmPasswordError.classList.remove('d-none');
                    isValid = false;
                } else {
                    confirmPasswordError.classList.add('d-none');
                }

                // Check if all fields are filled
                if (oldPasswordInput.value.trim() === '' || newPasswordInput.value.trim() === '' ||
                    confirmPasswordInput.value.trim() === '') {
                    isValid = false;
                }

                // Enable or disable submit button
                submitBtn.disabled = !isValid;
            }

            // Add event listeners for real-time validation
            oldPasswordInput.addEventListener('input', validateForm);
            newPasswordInput.addEventListener('input', validateForm);
            confirmPasswordInput.addEventListener('input', validateForm);
        });
    </script>

@endsection
