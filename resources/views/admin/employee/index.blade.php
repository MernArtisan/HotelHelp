@extends('admin.layouts.master')
@section('title', 'Employee List')

@section('content')
    <div class="page-wrapper">
        <main class="main--container text-dark">
            <div class="container-fluid">
                <!-- Card for Heading and Create Button -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header text-dark d-flex justify-content-between align-items-center">
                                <h2 class="page-title mb-0">Employee List</h2>
                                <!-- Create Permission Button with Icon -->
                                <a href="{{ route('admin.employees.create') }}" class="btn btn-dark btn-sm">
                                    <i class="fas fa-key"></i> + Create New Employee
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
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-hover table-bordered table-sm">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>#</th>
                                                <th width="0%">Employee ID</th>
                                                <th>First Name</th>
                                                <th>Middle Name</th>
                                                <th>Last Name</th>
                                                <th>Assigned Hotel</th>
                                                <th>Pay Rate</th>
                                                <th>Email</th>
                                                <th>Job</th>
                                                <th>Status</th>
                                                <th width="15%" class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employees as $key => $employe)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $employe->employee_id }}</td>
                                                    <td>{{ $employe->user->first_name ?? '' }}</td>
                                                    <td>{{ $employe->user->middle_name ?? '' }}</td>
                                                    <td>{{ $employe->user->last_name ?? '' }}</td>
                                                    <td>{{ $employe->hotel->name ?? '' }}</td>
                                                    <td class="text-center">
                                                        <span
                                                            class="btn btn-sm 
                                                            @if ($employe->pay_rate > 50) btn-success  <!-- High: Green color -->
                                                            @elseif($employe->pay_rate >= 30)
                                                                btn-warning  <!-- Mid: Yellow color -->
                                                            @else
                                                                btn-danger  <!-- Low: Red color --> @endif
                                                        ">
                                                            {{ $employe->pay_rate ?? '' }}
                                                        </span>
                                                    </td>

                                                    <td>{{ $employe->user->email ?? '' }}</td>
                                                    <td>{{ $employe->job->name ?? '' }}</td>
                                                    <td>
                                                        @if ($employe->status == 'active')
                                                            <button class="btn btn-info btn-sm">Active</button>
                                                        @elseif($employe->status == 'left')
                                                            <button class="btn btn-danger btn-sm">Left</button>
                                                        @elseif($employe->status == 'hold')
                                                            <button class="btn btn-warning btn-sm">Hold</button>
                                                        @else
                                                            <button class="btn btn-secondary">N/A</button>
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-info btn-sm me-2"
                                                            data-toggle="modal" data-target="#viewHotel"
                                                            onclick="showHotelDetails(
                                                            '{{ $employe->user->name }}', 
                                                            '{{ $employe->hotel->name }}', 
                                                            '{{ $employe->location }}', 
                                                            '{{ $employe->user->email }}', 
                                                            '{{ $employe->contact }}', 
                                                            '{{ $employe->user->address }}', 
                                                            '{{ $employe->assigned_manager }}', 
                                                            '{{ $employe->organization_manager }}', 
                                                            '{{ $employe->pay_rate }}', 
                                                            '{{ $employe->hotel->tax_location_code }}', 
                                                            '{{ $employe->hotel->notes }}', 
                                                            '{{ $employe->status }}',
                                                            '{{ $employe->documents }}'  <!-- Single text or string for documents -->
                                                        )">
                                                            <i class="bi bi-eye"></i>
                                                        </button>

                                                        <a href="{{ route('admin.employees.edit', $employe->id) }}"
                                                            class="btn btn-warning btn-sm me-2">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        <form id="delete-form-{{ $employe->id }}"
                                                            action="{{ route('admin.employees.destroy', $employe->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="confirmDelete({{ $employe->id }})">
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
            </div>
        </main>
    </div>

    <div class="modal fade text-dark" id="viewHotel" tabindex="-1" role="dialog" aria-labelledby="ViewHotel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white" id="ViewHotel">Employee Details</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Hotel Information Section -->
                        <div class="col-md-6 mb-3">
                            <div class="card p-4 shadow-sm border-info">
                                <h5 class="card-title text-info"><i class="bi bi-house-door"></i> Information</h5>
                                <table class="table table-striped table-borderless">
                                    <tr>
                                        <th>Employee Name:</th>
                                        <td id="EmpName"></td>
                                    </tr>
                                    <tr>
                                        <th>Hotel Name:</th>
                                        <td id="hotelName"></td>
                                    </tr>
                                    <tr>
                                        <th>Location:</th>
                                        <td id="hotelLocation"></td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td id="hotelEmail"></td>
                                    </tr>
                                    <tr>
                                        <th>Contact Person:</th>
                                        <td id="hotelContact"></td>
                                    </tr>
                                    <tr>
                                        <th>Address:</th>
                                        <td id="hotelAddress"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Management Details Section -->
                        <div class="col-md-6 mb-3">
                            <div class="card p-4 shadow-sm border-info">
                                <h5 class="card-title text-info"><i class="bi bi-person-lines-fill"></i> Details</h5>
                                <table class="table table-striped table-borderless">
                                    <tr>
                                        <th>Assigned Manager:</th>
                                        <td id="hotelManager"></td>
                                    </tr>
                                    <tr>
                                        <th>Organization Manager:</th>
                                        <td id="hotelSupervisor"></td>
                                    </tr>
                                    <tr>
                                        <th>Pay Rate:</th>
                                        <td id="PayRate"></td>
                                    </tr>
                                    <tr>
                                        <th>Tax Location Code:</th>
                                        <td id="hotelTaxLocationCode"></td>
                                    </tr>

                                    <tr>
                                        <th>Employee Documents</th>
                                        <td id="documents"></td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information Section -->
                    <div class="card p-4 shadow-sm border-info">
                        <h5 class="card-title text-info"><i class="bi bi-file-earmark-text"></i> Additional Information</h5>
                        <table class="table table-striped table-borderless">
                            <tr>
                                <th>Hotel Notes:</th>
                                <td id="hotelNotes"></td>
                            </tr>
                            <tr>
                                <th>Status Employee:</th>
                                <td id="hotelStatus"></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showHotelDetails(empName, hotelName, location, email, contact, address, manager, supervisor, pay_rate,
            taxLocationCode, notes, status, documents) {

            document.getElementById('EmpName').innerText = empName;
            document.getElementById('hotelName').innerText = hotelName;
            document.getElementById('hotelLocation').innerText = location;
            document.getElementById('hotelEmail').innerText = email;
            document.getElementById('hotelContact').innerText = contact;
            document.getElementById('hotelAddress').innerText = address;
            document.getElementById('hotelManager').innerText = manager;
            document.getElementById('hotelSupervisor').innerText = supervisor;
            document.getElementById('PayRate').innerText = pay_rate;
            document.getElementById('hotelTaxLocationCode').innerText = taxLocationCode;
            document.getElementById('hotelNotes').innerText = notes;
            document.getElementById('hotelStatus').innerText = status;

            // Handling documents as a comma-separated string
            const documentsElement = document.getElementById('documents');
            documentsElement.innerHTML = ''; // Clear previous content

            // Split the documents string into an array if it's comma-separated
            const documentsArray = documents.split(','); // Assuming documents are comma-separated

            documentsArray.forEach((doc) => {
                let downloadButton = document.createElement('a');
                downloadButton.href = `${doc.trim()}`; // Path where documents are stored
                downloadButton.innerText = `Download`; // Display document name
                downloadButton.classList.add('btn', 'btn-primary', 'btn-sm'); // Bootstrap classes for styling
                downloadButton.setAttribute('download', doc.trim()); // Force download

                documentsElement.appendChild(downloadButton);
                documentsElement.appendChild(document.createElement('br')); // Add line break after each button
            });
        }
    </script>


@endsection
