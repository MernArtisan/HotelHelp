<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdditionalCheck;
use App\Models\Employee;
use App\Models\Hotel;
use App\Models\PayGroup;
use App\Models\Revenue;
use App\Models\Timecard;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class PayrollController extends Controller
{
    public function Earning()
    {
        $revenues = Revenue::with('hotel')->where('status', 'paid')->get();
        // return $revenues;
        return view('admin.payroll.earnings', compact('revenues'));
    }


    public function AdditionalChecks()
    {
        $employees = Employee::with('user')->where('status', 'active')->get();
        // return $employees;
        $checks = AdditionalCheck::with(['employee.user'])->orderBy('id', 'desc')->get();
        // return $checks;
        return view('admin.payroll.additional_checks', compact('employees', 'checks'));
    }


    public function additionalChecksStore(Request $request)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',  // Ensure employee exists
            'amount' => 'required|numeric|min:0',             // Ensure amount is numeric and non-negative
            'check_date' => 'required',                        // Ensure date is a valid date
            'description' => 'nullable|string|max:255',
        ]);

        $employee = Employee::find($validatedData['employee_id']);

        if (!$employee) {
            return redirect()->back()->withErrors('Employee not found.');
        }

        try {
            $userRole = auth()->user()->roles->pluck('name')->first();

            $check = AdditionalCheck::create([
                'employee_id' => $validatedData['employee_id'],
                'amount' => $validatedData['amount'],
                'check_date' => $validatedData['check_date'],
                'description' => $validatedData['description'],
                'created_by' => $userRole,
            ]);

            return redirect()->back()->with('success', 'Check added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error adding check: ' . $e->getMessage());
        }
    }


    public function payrollReport()
    {
        $employees = Employee::where(column: function ($query) {
            $query->where('status', 'active');
        })->has('timecards')
            ->with('timecards')
            ->get();

        $payGroups = PayGroup::where('status', 'active')->get();
        $hotels = Hotel::where('status', 'active')->get();
        // return [$hotels, $payGroups];
        return view('admin.payroll.report', compact('employees', 'payGroups', 'hotels'));
    }

    public function generateInvoiceWithMpdf($id)
    {
        $employee = Employee::with('timecards', 'hotel', 'payGroup', 'user')->findOrFail($id);

        $data = [
            'employee' => $employee,
            'total_hours' => $employee->timecards->sum('total_hours'),
            'total_pay' => $employee->timecards->sum('total_hours') * $employee->pay_rate,
        ];

        $html = view('admin.payroll.invoice-mpdf', $data)->render();

        $mpdf = new Mpdf();

        $mpdf->WriteHTML($html);

        return $mpdf->Output('invoice-' . $employee->user->name . 'Timecards.pdf', 'D'); // 'D' stands for Download
    }
}
