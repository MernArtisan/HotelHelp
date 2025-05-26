@extends('admin.layouts.master')
@section('title', 'Hotels List')

@section('content')
    <div class="page-wrapper">
        <main class="main--container text-dark">
            <div class="container-fluid">
                <!-- Card for Heading and Create Button -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header text-dark d-flex justify-content-between align-items-center">
                                <h2 class="page-title mb-0">Hotel List</h2>
                                <!-- Create Permission Button with Icon -->
                                <a href="{{ route('admin.hotels.create') }}" class="btn btn-dark btn-sm">
                                    <i class="fas fa-key"></i> + Create New Hotel
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
                                                <th width="0%">ID</th>
                                                <th width="14%">Hotel Name</th>
                                                <th>Location</th>
                                                <th>Person Email</th>
                                                <th>Contact Person</th>
                                                <th>Workers</th>
                                                <th>Status</th>
                                                <th width="15%" class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($hotels as $key => $hotel)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $hotel->name ?? '' }}</td>
                                                    <td>{{ $hotel->location ?? '' }}</td>
                                                    <td>{{ $hotel->email ?? '' }}</td>
                                                    <td>{{ $hotel->contact ?? '' }}</td>
                                                    <td class="btn btn-dark btn-sm text-center" style="margin-left: 20px; margin-top: 10px;">{{ $hotel->employees_count  ?? '' }}</td>
                                                    <td>
                                                        @if($hotel->status == 'active')
                                                            <button class="btn btn-success btn-sm">Active</button>
                                                        @elseif($hotel->status == 'block')
                                                            <button class="btn btn-danger btn-sm">Block</button>
                                                        @else
                                                            <button class="btn btn-secondary">N/A</button>
                                                        @endif
                                                    </td>
                                                    
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-info btn-sm me-2"
                                                            data-toggle="modal" data-target="#viewHotel"
                                                            onclick="showHotelDetails(
                                                            '{{ $hotel->name }}', 
                                                            '{{ $hotel->location }}', 
                                                            '{{ $hotel->email }}', 
                                                            '{{ $hotel->contact }}', 
                                                            '{{ $hotel->address }}', 
                                                            '{{ $hotel->manager }}', 
                                                            '{{ $hotel->supervisor }}', 
                                                            '{{ $hotel->management_company }}', 
                                                            '{{ $hotel->ownership_group }}', 
                                                            '{{ $hotel->tax_location_code }}', 
                                                            '{{ $hotel->notes }}', 
                                                            '{{ $hotel->status }}'
                                                        )">
                                                            <i class="bi bi-eye"></i>
                                                        </button>

                                                        <a href="{{ route('admin.hotels.edit', $hotel->id) }}"
                                                            class="btn btn-warning btn-sm me-2">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        <form action="{{ route('admin.hotels.destroy', $hotel->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure?')">
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

    <div class="modal fade text-dark" id="viewHotel" tabindex="-1" role="dialog" aria-labelledby="ViewHotel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white" id="ViewHotel">View Hotel Details</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Hotel Information Section -->
                        <div class="col-md-6 mb-3">
                            <div class="card p-4 shadow-sm border-info">
                                <h5 class="card-title text-info"><i class="bi bi-house-door"></i> Hotel Information</h5>
                                <table class="table table-striped table-borderless">
                                    <tr>
                                        <th>Name:</th>
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
                                <h5 class="card-title text-info"><i class="bi bi-person-lines-fill"></i> Management Details</h5>
                                <table class="table table-striped table-borderless">
                                    <tr>
                                        <th>Manager:</th>
                                        <td id="hotelManager"></td>
                                    </tr>
                                    <tr>
                                        <th>Supervisor:</th>
                                        <td id="hotelSupervisor"></td>
                                    </tr>
                                    <tr>
                                        <th>Management Company:</th>
                                        <td id="hotelManagementCompany"></td>
                                    </tr>
                                    <tr>
                                        <th>Ownership Group:</th>
                                        <td id="hotelOwnershipGroup"></td>
                                    </tr>
                                    <tr>
                                        <th>Tax Location Code:</th>
                                        <td id="hotelTaxLocationCode"></td>
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
                                <th>Notes:</th>
                                <td id="hotelNotes"></td>
                            </tr>
                            <tr>
                                <th>Status:</th>
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
        function showHotelDetails(name, location, email, contact, address, manager, supervisor, managementCompany, ownershipGroup, taxLocationCode, notes, status) {
            // Set the modal content dynamically
            document.getElementById('hotelName').innerText = name;
            document.getElementById('hotelLocation').innerText = location;
            document.getElementById('hotelEmail').innerText = email;
            document.getElementById('hotelContact').innerText = contact;
            document.getElementById('hotelAddress').innerText = address;
            document.getElementById('hotelManager').innerText = manager;
            document.getElementById('hotelSupervisor').innerText = supervisor;
            document.getElementById('hotelManagementCompany').innerText = managementCompany;
            document.getElementById('hotelOwnershipGroup').innerText = ownershipGroup;
            document.getElementById('hotelTaxLocationCode').innerText = taxLocationCode;
            document.getElementById('hotelNotes').innerText = notes;
            document.getElementById('hotelStatus').innerText = status;
        }
    </script>
    
    

@endsection
