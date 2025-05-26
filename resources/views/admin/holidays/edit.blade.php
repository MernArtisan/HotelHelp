@extends('admin.layouts.master')
@section('title', 'Hotels List')

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
                        <form id="hireForm" method="POST" action="{{ route('admin.holidaysUpdate', $holiday->id) }}">
                            @csrf
                            @method('PUT') 

                            <div class="card mb-5">
                                <div class="card-header bg-dark text-white">
                                    <h4 class="ml-2">Holiday Edit</h4>
                                </div>
                                <div class="card-header bg-danger text-white">
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-6">
                                            <div class="form-group">
                                                <label for="name">Role Name</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-hotel"></i></span>
                                                    </div>
                                                    <select name="role" id="role" class="form-control">
                                                        <option value="">Select Role</option>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->name }}" {{ $role->name == $holiday->role ? 'selected' : '' }}>
                                                                {{ $role->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid role name.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-6">
                                            <div class="form-group">
                                                <label for="location">Eligibility Criteria</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                    </div>
                                                    <textarea name="eligibility_criteria" id="eligibility_criteria" class="form-control">{{ old('eligibility_criteria', $holiday->eligibility_criteria) }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="holiday_entitlement">Holiday Entitlement</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                                    </div>
                                                    <input type="number" step="any" class="form-control"
                                                        name="holiday_entitlement" id="holiday_entitlement"
                                                        placeholder="Enter Holiday Entitlement"
                                                        value="{{ old('holiday_entitlement', $holiday->holiday_entitlement) }}">
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid holiday_entitlement.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="shift">Shift Start</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                                    </div>
                                                    <input type="time" class="form-control" name="shift" id="shift"
                                                        value="{{ old('shift', \Carbon\Carbon::parse($holiday->shift)->format('H:i')) }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="holiday_start_date">Shift End</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                                    </div>
                                                    <input type="time" class="form-control" name="holiday_start_date" id="holiday_start_date"
                                                        value="{{ old('holiday_start_date', \Carbon\Carbon::parse($holiday->holiday_start_date)->format('H:i')) }}">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-success">Update</button>
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
