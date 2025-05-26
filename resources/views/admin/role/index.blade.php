@extends('admin.layouts.master')
@section('title', 'Permission List')

@section('content')
    <div class="page-wrapper">
        <main class="main--container text-dark">
            <div class="container-fluid">
                <!-- Card for Heading and Create Button -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header text-dark d-flex justify-content-between align-items-center">
                                <h2 class="page-title mb-0">Roles List</h2>
                                <!-- Create Permission Button with Icon -->
                                <a href="{{route('admin.roles.create')}}" class="btn btn-dark btn-sm">
                                    <i class="fas fa-key"></i> + Create New Role
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
                                                <th>Role Name</th>
                                                <th width="15%" class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles as $role)
                                                <tr>
                                                    <td>{{ $role->id }}</td>
                                                    <td>{{ $role->name }}</td>
                                                    <td class="text-center">
                                                        {{-- <!-- Show Icon -->
                                                        <a href="{{ route('admin.roles.show', $role->id) }}"
                                                            class="btn btn-info btn-sm me-2">
                                                            <i class="bi bi-eye"></i> <!-- Show icon -->
                                                        </a> --}}
                                                        <!-- Edit Icon -->
                                                        <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                            class="btn btn-warning btn-sm me-2">
                                                            <i class="bi bi-pencil-square"></i> <!-- Edit icon -->
                                                        </a>
                                                        <!-- Delete Icon -->
                                                        {{-- <form
                                                            action="{{ route('admin.roles.destroy', $role->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="bi bi-trash"></i> <!-- Delete icon -->
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
