@extends('admin.layouts.master')
@section('title', 'Edit Role')

@section('content')
    <div class="page-wrapper">
        <main class="main--container">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h2 class="page-title mb-0 text-dark font-weight-bold">Edit Role</h2>
                                <!-- Back to Roles List Button -->
                                <a href="{{ route('admin.roles.index') }}" class="btn btn-dark btn-sm">
                                    <i class="fas fa-arrow-left"></i> Back to Roles List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Role Form -->
                <div class="row">
                    <div class="col-lg-12 col-md-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h4 class="text-center text-dark font-weight-bold mb-4">Role Information</h4>

                                <form id="editRoleForm" method="POST" action="{{ route('admin.roles.update', $role->id) }}"
                                    enctype="multipart/form-data" novalidate>
                                    @csrf
                                    @method('PUT')  
                                    <div class="form-group">
                                        <label for="name" class="text-dark font-weight-bold">Role Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-info text-white"><i
                                                        class="fas fa-key"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ old('name', $role->name) }}" placeholder="Enter role name" readonly>
                                        </div>
                                        @error('name')
                                            <small id="nameError" class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="permissions" class="text-dark font-weight-bold">Assign Permissions</label>
                                        <div class="border border-info p-3 rounded">
                                            
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="select-all">
                                                <label class="form-check-label text-dark font-weight-bold" for="select-all">
                                                    Select All
                                                    <hr>
                                                </label>
                                            </div>

                                            <div class="row">
                                                @foreach ($permissions as $permission)
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input permission-checkbox"
                                                                type="checkbox" name="permissions[]"
                                                                value="{{ $permission->id }}"
                                                                id="permission-{{ $permission->id }}"
                                                                @if ($role->permissions->contains($permission->id)) checked @endif>
                                                            <label class="form-check-label text-dark"
                                                                for="permission-{{ $permission->id }}">
                                                                <b class="text-info">{{ $permission->name }}</b>
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @error('permissions')
                                            <small id="permissionsError" class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                @section('scripts')
                                    <script>
                                        // Select/Deselect all permissions when "Select All" checkbox is toggled
                                        document.getElementById('select-all').addEventListener('change', function() {
                                            var checkboxes = document.querySelectorAll('.permission-checkbox');
                                            for (var checkbox of checkboxes) {
                                                checkbox.checked = this.checked;
                                            }
                                        });
                                    </script>
                                @endsection

                                <!-- Submit Button -->
                                <div class="form-group mt-4 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">Update Role</button>
                                    <a href="{{ route('admin.roles.index') }}"
                                        class="btn btn-secondary btn-lg px-5 ml-2">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
