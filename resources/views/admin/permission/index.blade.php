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
                                <h2 class="page-title mb-0">Permissions List</h2>
                                <!-- Create Permission Button with Icon -->
                                <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#createpermission">
                                    <i class="fas fa-key"></i> + Create New Permission
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal for Creating Permission -->
                <div class="modal fade" id="createpermission" tabindex="-1" role="dialog" aria-labelledby="createPermissionLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-dark">
                                <h5 class="modal-title text-white" id="createPermissionLabel">Create Permission</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('admin.permissions.store') }}" id="createPermissionForm" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="name" class="form-label">Permission Name</label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="fas fa-key"></i></div>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                                </div>
                                                @error('name')
                                                    <small id="nameError" class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                
                                <!-- Modal Footer with Buttons -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Create Permission</button>
                                </div>
                            </form>
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
                                                <th width="2%">ID</th>
                                                <th>Permission Name</th>
                                                <th width="10%" class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permissions as $permission)
                                            <tr>
                                                <td>{{ $permission->id }}</td>
                                                <td>{{ $permission->name }}</td>
                                                <td class="text-primary text-center">
                                                    <span data-toggle="tooltip" data-placement="top" title="Only Developer Can Change">
                                                        Note
                                                    </span>
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
@section('scripts')
    <script></script>
@endsection
