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
                                <h2 class="page-title mb-0">Holidays List</h2>
                                <!-- Create Permission Button with Icon -->
                                <a href="{{ route('admin.holidaysCreate') }}" class="btn btn-dark btn-sm">
                                    <i class="fas fa-key"></i> + Create New Holiday
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
                                                <th width="14%">Role Name</th>
                                                <th>Eligibility Criteria</th>
                                                <th>Holiday Entitlement	</th>
                                                <th>Shift</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($holidays as $key => $holiday)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $holiday->role ?? '' }}</td>
                                                    <td>{{ $holiday->eligibility_criteria ?? '' }}</td>
                                                    <td>{{ $holiday->holiday_entitlement ?? '' }}</td>
                                                    <td class="btn btn-dark btn-sm">{{ $holiday->shift ?? '' }} | {{ $holiday->holiday_start_date ?? '' }}</td>
                                                    {{-- <td>{{ $holiday->holiday_start_date ?? '' }}</td>
                                                    <td>{{ $holiday->holiday_end_date ?? '' }}</td> --}}
                                                     <td>
                                                        <a href="{{ route('admin.holidaysEdit', $holiday->id) }}"
                                                            class="btn btn-warning btn-sm me-2">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                       {{-- <form action="{{ route('admin.hotels.destroy', $holiday->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure?')">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form> --}}
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
    
    

@endsection
