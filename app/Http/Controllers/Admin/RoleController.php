<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('name','!=','tiar4')->get();
        return view('admin.role.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all(); // Fetch all permissions
        return view('admin.role.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'required|array',
        ]);

        // Create the role
        $role = Role::create(['name' => $request->name]);

        // Assign permissions to the role
        $role->permissions()->sync($request->permissions);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully!');
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::orderBy('id','desc')->get();
        return view('admin.role.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id, // Ensure unique name except for the current role
            'permissions' => 'required|array', // Ensure permissions array is provided
            'permissions.*' => 'exists:permissions,id', // Ensure each permission exists in the database
        ]);

        try {
            $role->update([
                'name' => $request->name,
            ]);
            $role->permissions()->sync($request->permissions);

            return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong while updating the role.');
        }
    }
}
