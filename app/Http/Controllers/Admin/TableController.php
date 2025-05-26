<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Hotel;
use App\Models\Miscellaneous;
use App\Models\MiscellaneousEmployeeField;
use App\Models\Termination;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function organizationTable()
    {
        $hotels = Hotel::where('status', 'active')->get();
        $employees = Employee::where('status', 'active')->get();
        return view('admin.tables.organization-table', compact('hotels', 'employees'));
    }

    public function employmentCategories()
    {
        $employees = Employee::where('status', 'active')->get();
        $hotels = Hotel::where('status', 'active')->get();
        return view('admin.tables.employment-categories', compact('employees', 'hotels'));
    }

    public function terminationReasons()
    {
        $employees = Employee::with('termination')->where('status', 'terminated')->get();
        // dd($employees);
        $hotels = Hotel::where('status', 'active')->get();
        return view('admin.tables.termination-reasons', compact('employees', 'hotels'));
    }

    public function employmentStatuses(Request $request)
    {
        $hotels = Hotel::where('status', 'active')->get();
        $employees = Employee::where('status', 'active')->get();
        // $termination = Termination::select('status')->get();
        return view('admin.tables.employeestatus', compact('employees', 'hotels'));
    }


    public function miscFieldCategories()
    {
        $miscellaneousItems = Miscellaneous::with('hotel')->get();
        $hotels = Hotel::all();
        return view('admin.tables.misc-field-categories', compact('miscellaneousItems', 'hotels'));
    }


    public function AddmiscFieldCategories(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'categories' => 'required|array',
            'categories.*.hotel_id' => 'required|exists:hotels,id',
            'categories.*.item_name' => 'required|string|max:255',
            'categories.*.category' => 'required|string|max:255',
            'categories.*.description' => 'nullable|string',
        ]);

        // Loop through categories and store each one
        foreach ($request->categories as $category) {
            Miscellaneous::updateOrCreate(
                ['id' => $category['id']], // Check if the category already exists (edit) or create a new one
                [
                    'hotel_id' => $category['hotel_id'],
                    'item_name' => $category['item_name'],
                    'category' => $category['category'],
                    'description' => $category['description'],
                    // Remove the 'value' field as it's not used anymore
                ]
            );
        }

        // Return success message
        return redirect()->back()->with('success', 'Miscellaneous items added/updated successfully.');
    }

    public function deleteCategory($id)
    {
        // Find the category by ID
        $category = Miscellaneous::find($id);

        // Check if the category exists
        if ($category) {
            // Delete the category from the database
            $category->delete();

            return response()->json(['message' => 'Category deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Category not found.'], 404);
        }
    }


    // public function miscFieldEmployees()
    // {
    //     $miscellaneousItems = MiscellaneousEmployeeField::with('hotel')->get();
    //     $employees = Employee::where('status', 'active')->get();
    //     $hotels = Hotel::all();
    //     return view('admin.tables.misc-employee-fields', compact('miscellaneousItems', 'hotels', 'employees'));
    // }
    public function miscFieldEmployees()
    {
        $miscellaneousItems = MiscellaneousEmployeeField::with('employee', 'hotel')->get(); // Add the employee relation
        $employees = Employee::with('user')->where('status', 'active')->get();
        $hotels = Hotel::all();
        // return $employees;
        return view('admin.tables.misc-employee-fields', compact('miscellaneousItems', 'hotels', 'employees'));
    }


    public function AddmiscFieldEmployees(Request $request)
    {
        $request->validate([
            'employeesFields' => 'required|array',
            'employeesFields.*.hotel_id' => 'required|exists:hotels,id',
            'employeesFields.*.employee_id' => 'required|exists:employees,id',
            'employeesFields.*.field_name' => 'required|string|max:255',
            'employeesFields.*.field_value' => 'nullable|string',
        ]);
    
        foreach ($request->employeesFields as $employeeField) {
            MiscellaneousEmployeeField::updateOrCreate(
                ['id' => $employeeField['id']],
                [
                    'hotel_id' => $employeeField['hotel_id'],
                    'employee_id' => $employeeField['employee_id'],
                    'field_name' => $employeeField['field_name'],
                    'field_value' => $employeeField['field_value'],
                ]
            );
        }
    
        return redirect()->back()->with('success', 'Miscellaneous Employee fields added/updated successfully.');
    }
    
    public function deleteEmployeeField($id)
    {
        // Find the category by ID
        $EmployeeField = MiscellaneousEmployeeField::find($id);

        // Check if the category exists
        if ($EmployeeField) {
            // Delete the category from the database
            $EmployeeField->delete();

            return response()->json(['message' => 'EmployeeField deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'EmployeeField not found.'], 404);
        }
    }
}
