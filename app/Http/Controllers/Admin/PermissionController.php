<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        try {
            $permissions = Permission::orderBy('id','asc')->get();
            return view('admin.permission.index', compact('permissions'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name|max:255',  // Permission name must be unique
        ]);

        try {
            Permission::create([
                'name' => $request->name,
            ]);
            return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

}
