<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Mail\EmployeeHiredNotification;
use App\Models\Employee;
use App\Models\Hotel;
use App\Models\Job;
use App\Models\PayGroup;
use App\Models\Termination;
use App\Models\User;
use App\Services\EmployeeService;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{

    public function index()
    {
        $employees = Employee::with('hotel', 'job', 'payGroup')->where('status', '!=', 'terminated')->orderBy('id', 'desc')->get();
        return view('admin.employee.index', compact('employees'));
    }
    public function create()
    {
        $roles = Role::all();
        $prefix = 'hh-';
        $lastEmployee = Employee::orderBy('id', 'desc')->first();

        if ($lastEmployee) {
            $lastEmployeeId = (int)str_replace($prefix, '', $lastEmployee->employee_id);
            $newEmployeeId = $prefix . ($lastEmployeeId + 1);
        } else {
            $newEmployeeId = $prefix . '1';
        }

        $employees = Employee::whereHas('user', function ($user) {
            $user->whereHas('roles', function ($roleQuery) {
                $roleQuery->whereIn('name', ['tiar2', 'tiar3']);
            });
        })->get();

        $payGroup = PayGroup::where('status', 'active')
            ->where('name', '!=', 'tiar1')
            ->get();

        $jobss = Job::where('status', 'active')->get();

        $hotels = Hotel::where('status', 'active')->get();

        return view('admin.employee.create', compact('roles', 'payGroup', 'employees', 'newEmployeeId', 'jobss', 'hotels'));
    }
    private function validateHireform(Request $request, $employeeId = null)
    {
        $employee = Employee::find($employeeId);
        $userId = $employee ? $employee->user->id : null;

        return $request->validate([
            // 'name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId)
            ],
            'password' => $request->filled('password') ? ['sometimes', 'required', 'string', 'min:8'] : [],
            'address' => 'required|string|max:255',
            'ssn' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'marital_status' => 'required',
            'contact_number' => 'required',
            'gender' => 'required|in:male,female,other',
            'designation' => 'required|string|max:255',
            'employee_id' => [
                'required',
                'string',
                'max:255',
                Rule::unique('employees', 'employee_id')->ignore($employeeId)
            ],
            'hire_date' => 'required|date',
            'status' => 'required',
            'employee_type' => 'required|string|max:255',
            'assigned_manager' => 'required|string|max:255',
            'organization_manager' => 'nullable|string|max:255',
            'pay_group_id' => 'required|numeric|exists:pay_groups,id',
            'pay_rate' => 'required|numeric',
            'alternate_pay_rate' => 'nullable|numeric',
            'hotel_id' => 'required|numeric|exists:hotels,id',
            'location' => 'required|string|max:255',
            'job_id' => 'required|numeric|exists:jobs,id',
            'message' => 'nullable|string',
            'documents' => 'nullable|file|mimes:pdf|max:2048',

        ]);
    }
    public function store(Request $request)
    {
        
        try {
            DB::beginTransaction();
            $validatedData = $this->validateHireform($request);
            $user = User::create([
                // 'name' => "abc",
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'middle_name' => $validatedData['middle_name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'address' => $validatedData['address'],
                'ssn' => $validatedData['ssn'],
                'birth_date' => $validatedData['birth_date'],
                'marital_status' => $validatedData['marital_status'],
                'contact_number' => $validatedData['contact_number'],
                'gender' => $validatedData['gender'],
                'about' => $validatedData['about'] ?? null,
            ]);
            if ($request->has('role')) {
                $role = $request->input('role');
                $user->assignRole($role);
            }
            $employee = new Employee();
            $employee->user_id = $user->id;
            $employee->designation = $validatedData['designation'];
            $employee->employee_id = $validatedData['employee_id'];
            $employee->hire_date = $validatedData['hire_date'];
            $employee->status = $validatedData['status'];
            $employee->employee_type = $validatedData['employee_type'];
            $employee->assigned_manager = $validatedData['assigned_manager'];
            $employee->organization_manager = $validatedData['organization_manager'];
            $employee->pay_group_id = $validatedData['pay_group_id'];
            $employee->pay_rate = $validatedData['pay_rate'];
            $employee->alternate_pay_rate = $validatedData['alternate_pay_rate'];
            $employee->hotel_id = $validatedData['hotel_id'];
            $employee->location = $validatedData['location'];
            $employee->job_id = $validatedData['job_id'];
            $employee->contact = $validatedData['contact_number'];
            $employee->message = $validatedData['message'];
            $employee->gender = $validatedData['gender'];

            if ($request->hasFile('documents')) {
                if ($employee->documents && file_exists(public_path('documents/' . $employee->documents))) {
                    unlink(public_path('documents/' . $employee->documents));
                }

                $DocumentName = time() . '.' . $request->file('documents')->getClientOriginalExtension();
                $request->file('documents')->move(public_path('documents'), $DocumentName);

                $employee->documents = 'documents/' . $DocumentName;
            }

            $employee->save();
            // Mail::to($user->email)->send(new EmployeeHiredNotification($user, $validatedData['password']));
            DB::commit();
            return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully!');
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->errors());
        }
    }
    public function edit($id)
    {

        $employee = Employee::with('user')->find($id);  // Eager load the user relationship

        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found.');
        }

        $user = $employee->user;
        // dd($user);
        $roleAssigned = $user ? $user->roles->first() : null;  // Get the first role assigned to the user (you can modify it to handle multiple roles if needed)

        $roles = Role::all();  // Get all roles
        $payGroup = PayGroup::where('status', 'active')->get();
        $jobss = Job::where('status', 'active')->get();
        $hotels = Hotel::where('status', 'active')->get();
        // return $employee;
        return view('admin.employee.create', compact('employee', 'roles', 'payGroup', 'jobss', 'hotels', 'roleAssigned'));
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();

            $validatedData = $this->validateHireform($request, $id);

            $employee = Employee::findOrFail($id);
            $user = $employee->user;
            $user->name = "abc";
            $user->first_name = $validatedData['first_name'];
            $user->last_name = $validatedData['last_name'];
            $user->middle_name = $validatedData['middle_name'];
            $user->email = $validatedData['email'];
            $user->address = $validatedData['address'];
            $user->ssn = $validatedData['ssn'];
            $user->birth_date = $validatedData['birth_date'];
            $user->marital_status = $validatedData['marital_status'];
            $user->contact_number = $validatedData['contact_number'];
            $user->gender = $validatedData['gender'];
            $user->about = $validatedData['about'] ?? null;
            if ($request->has('role')) {
                $role = $request->input('role');
                $user->assignRole($role);
            }
            $user->save();

            $employee->designation = $validatedData['designation'];
            $employee->employee_id = $validatedData['employee_id'];
            $employee->hire_date = $validatedData['hire_date'];
            $employee->status = $validatedData['status'];
            $employee->employee_type = $validatedData['employee_type'];
            $employee->assigned_manager = $validatedData['assigned_manager'];
            $employee->organization_manager = $validatedData['organization_manager'];
            $employee->pay_group_id = $validatedData['pay_group_id'];
            $employee->pay_rate = $validatedData['pay_rate'];
            $employee->alternate_pay_rate = $validatedData['alternate_pay_rate'];
            $employee->hotel_id = $validatedData['hotel_id'];
            $employee->location = $validatedData['location'];
            $employee->job_id = $validatedData['job_id'];
            $employee->contact = $validatedData['contact_number'];
            $employee->message = $validatedData['message'];
            $employee->gender = $validatedData['gender'];
           
            if ($request->hasFile('documents')) {
                $document = $request->file('documents');
                $filename = time() . '_' . $document->getClientOriginalName();
                $destinationPath = public_path('documents');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }
                $document->move($destinationPath, $filename);
                $employee->documents = 'documents/' . $filename;
            }

            $employee->save();

            // Mail::to($user->email)->send(new EmployeeHiredNotification($user, $validatedData['password']));

            DB::commit();

            return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully!');
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->errors());
        }
    }
    public function destroy($id)
    {

        $employee = Employee::findOrFail($id);
        if (!$id) {
            return redirect()->back()->with('error', 'Employee not found.');
        }
        $employee->user()->delete();
        $employee->delete();
        return redirect()->route('admin.employees.index')->with('success', 'Employee and associated user deleted successfully!');
    }
    public function EmployeeDataReport(Request $request)
    {
        // Start with a query builder instance
        $employees = Employee::with('user', 'job', 'hotel', 'payGroup');

        // Fetch filter options
        $hotels = Hotel::where('status', 'active')->get();
        $locations = Employee::where('status', 'active')->get();
        $designations = Job::where('status', 'active')->get();  // assuming you have a Job model

        // Filter based on the request parameters
        if ($request->has('hotel') && $request->hotel != '') {
            $employees = $employees->whereHas('hotel', function ($query) use ($request) {
                $query->where('name', $request->hotel);
            });
        }

        if ($request->has('state') && $request->state != '') {
            $employees = $employees->where('location', $request->state);
        }

        if ($request->has('position') && $request->position != '') {
            $employees = $employees->whereHas('job', function ($query) use ($request) {
                $query->where('name', $request->position);
            });
        }

        if ($request->has('employee_id') && $request->employee_id != '') {
            $employees = $employees->where('employee_id', 'like', '%' . $request->employee_id . '%');
        }

        if ($request->has('employee_type') && $request->employee_type != '') {
            $employees = $employees->where('employee_type', $request->employee_type);
        }
 
        $employees = $employees->get();
 
        if ($request->ajax()) {
            return view('admin.employee.partials.employee_table', compact('employees'));
        }

        // Return the full view with employees and filter options
        return view('admin.employee.data_report', compact('employees', 'hotels', 'locations', 'designations'));
    }
    public function EmployeeDemographics(Request $request)
    {
        // Fetch all employees with their associated user, hotel, and payGroup data
        $employees = Employee::with('user', 'hotel', 'payGroup')->where('status', 'active')->get();

        // Calculate gender distribution
        $genderCounts = [
            'male' => $employees->where('gender', 'male')->count(),
            'female' => $employees->where('gender', 'female')->count(),
            'other' => $employees->where('gender', 'other')->count(),
        ];

        // Calculate hotel distribution
        $hotelCounts = $employees->groupBy('hotel.name')->map(function ($group) {
            return $group->count();
        });

        return view('admin.employee.demographics', compact('employees', 'genderCounts', 'hotelCounts'));
    }
    public function Termination(Request $request)
    {
        $employess = Employee::where('status', 'active')->get();
        $employessList = Termination::orderBy('id', 'desc')->get();
        // return $employessList;
        return view('admin.employee.termination', compact('employess', 'employessList'));
    }
    public function TerminationPost(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'terminationReason' => 'required|string|max:255',
            'additional_notes' => 'nullable|string',
        ]);
        try {
            // DB::beginTransaction();

            $employee = Employee::findOrFail($request->employee_id);

            $termination = new Termination();
            $termination->employee_id = $employee->id;
            $termination->termination_reason = $request->terminationReason;
            $termination->employee_name = $request->employee_name;
            $termination->hotel_name = $request->hotel_name;
            $termination->additional_notes = $request->additional_notes;
            $termination->save();

            $employee->status = 'terminated';
            $employee->save();
            return redirect()->back()->with('success', 'Employee terminated successfully.');

            // DB::commit();

        } catch (Exception $e) {
            // DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while processing the termination.');
        }
    }
    public function HeadCount(Request $request)
    {
        // Count terminated and active employees
        $terminatedCount = Employee::where('status', 'terminated')->count();
        $activeCount = Employee::where('status', 'active')->count();
        $totalCount = Employee::count(); // Total number of employees

        // Fetch employees
        $employees = Employee::orderBy('id', 'desc')->get();

        // Return the view with data
        return view('admin.employee.headcount', compact('employees', 'activeCount', 'totalCount', 'terminatedCount'));
    }

    public function jobstore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:jobs,name'
        ]);

        $job = Job::create([
            'name' => $request->name,
            'description' => "n/a"
        ]);

        return response()->json(['id' => $job->id, 'name' => $job->name]);
    }

}
