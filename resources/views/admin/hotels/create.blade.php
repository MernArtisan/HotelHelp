@extends('admin.layouts.master')

@section('title', 'Hotel Add Form')

@section('styles')
    <style>
        label {
            font-weight: bold;
            color: #333;
            position: relative;
        }

        label::after {
            content: " *";
            color: red;
            font-weight: normal;
        }

        .input-group-text {
            background-color: #2bb3c0;
            border-right: none;
        }

        .form-control {
            border-left: none;
        }
    </style>

@endsection

@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="offset-1 col-10 offset-1">
                    <div class="main--container">
                        <form id="hireForm" method="POST" action="{{ route('admin.hotels.store') }}">
                            @csrf
                            <div class="card mb-5">
                                <div class="card-header bg-dark text-white">
                                    <h4 class="ml-2">Hotel Information</h4>
                                </div>
                                <div class="card-header bg-danger text-white">
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Hotel Name -->
                                        <div class="col-lg-12 col-md-6">
                                            <div class="form-group">
                                                <label for="name">Hotel Name</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-hotel"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="name" id="name"
                                                        required placeholder="Enter Hotel Name" value="{{ old('name') }}">
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid hotel name.
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="location">Location</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-map-marker-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="location"
                                                        id="location" required placeholder="Enter Location"
                                                        value="{{ old('location') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="latitude">Latitude</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                                    </div>
                                                    <input type="number" step="any" class="form-control"
                                                        name="latitude" id="latitude" placeholder="Enter Latitude" readonly
                                                        value="{{ old('latitude') }}">
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid latitude.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="longitude">Longitude</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                                    </div>
                                                    <input type="number" step="any" class="form-control"
                                                        name="longitude" id="longitude" placeholder="Enter Longitude"
                                                        readonly value="{{ old('longitude') }}">
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid longitude.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12" id="map-container" style="display: none;">
                                            <div class="form-group">
                                                <label for="map">Location Map</label>
                                                <div id="map" style="width: 100%; height: 400px;"></div>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">
                                        <!-- Address -->
                                        <div class="col-lg-8 col-md-12">
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-address-card"></i></span>
                                                    </div>
                                                    <textarea class="form-control" name="address" id="address" rows="3" required placeholder="Enter Address"> {{ old('address') }}</textarea>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid address.
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Manager -->
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="manager">Manager</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-user-tie"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="manager"
                                                        id="manager" required placeholder="Enter Manager Name"
                                                        value="{{ old('manager') }}">
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid manager name.
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="contact">Contact Person</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    </div>
                                                    <input type="number" class="form-control" name="contact"
                                                        id="contact" required placeholder="Enter contact Name"
                                                        value="{{ old('contact') }}">
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid contact.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="email">Person Email</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-envelope"></i></span>
                                                    </div>
                                                    <input type="email" class="form-control" name="email"
                                                        id="email" placeholder="Enter email company" required
                                                        value="{{ old('email') }}">
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid email company.
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <!-- Supervisor -->
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="supervisor">Supervisor</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="supervisor"
                                                        id="supervisor" required placeholder="Enter Supervisor Name"
                                                        value="{{ old('supervisor') }}">
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid supervisor name.
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Management Company -->
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="management_company">Management Company</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-building"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="management_company"
                                                        id="management_company" placeholder="Enter Management Company"
                                                        value="{{ old('management_company') }}">
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid management company.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="ownership_group">Ownership Group</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-building"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="ownership_group"
                                                        id="ownership_group" placeholder="Enter ownership_group"
                                                        value="{{ old('ownership_group') }}">
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid ownership_group.
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tax Location Code -->
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="tax_location_code">Tax Location Code</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-file-invoice-dollar"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="tax_location_code"
                                                        id="tax_location_code" required
                                                        placeholder="Enter Tax Location Code"
                                                        value="{{ old('tax_location_code') }}">
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid tax location code.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Notes -->
                                        <div class="col-lg-8 col-md-12">
                                            <div class="form-group">
                                                <label for="notes">Notes</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-sticky-note"></i></span>
                                                    </div>
                                                    <textarea class="form-control" name="notes" id="notes" rows="3" placeholder="Enter Notes (optional)">{{ old('notes') }}</textarea>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide valid notes.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group">
                                                <label for="notes">Status</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-circle"></i>
                                                        </span>
                                                    </div>
                                                    <select name="status" id="status" class="form-control">
                                                        <option value="active">Active</option>
                                                        <option value="block">Block</option>
                                                    </select>
                                                </div>
                                                <div class="invalid-feedback"> Please provide valid notes.</div>
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
@endsection

@section('scripts')

@endsection
