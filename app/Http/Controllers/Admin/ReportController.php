<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Hotel;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Revenue;
use App\Models\Timecard;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function agedReceivables()
    {
        $envoice = Invoice::orderBy('created_at', 'desc')->get();
        $hotels = Hotel::orderBy('created_at', 'desc')->get();
        return view('admin.report.aged-receivables', compact('envoice', 'hotels'));
    }

    public function PaidAgedReceivables(Request $request, $id)
    {
        $invoice = Invoice::find($id);

        $invoiceItems = InvoiceItem::where('invoice_id', $invoice->id)->get();
        $invoice->status = 'paid';
        $invoice->save();

        $revenue = Revenue::create([
            'invoice_id' => $invoice->id,
            'hotel_id' => $invoice->hotel_id,
            'total_amount' => $invoice->total_amount,
            'paid_amount' => $invoice->total_amount,
            'due_amount' => 0,
            'profit_amount' => $invoice->total_amount,
            'status' => 'paid',
        ]);

        $revenue->save();

        return redirect()->back()->with('success', 'Invoice paid successfully and revenue calculated.');
    }


    public function organizationalChart()
    {
        // Fetch data dynamically
        $activeEmployees = Employee::where('status', 'active')->count();
        $inactiveEmployees = Employee::where('status', 'terminated')->count();

        $activeHotels = Hotel::where('status', 'active')->count();
        $inactiveHotels = Hotel::where('status', 'block')->count();

        // ROI data dynamically (for any year)
        $currentYear = Carbon::now()->year;
        $roiData = [
            'Q1' => Revenue::whereBetween('created_at', ["$currentYear-01-01", "$currentYear-03-31"])->sum('total_amount'),
            'Q2' => Revenue::whereBetween('created_at', ["$currentYear-04-01", "$currentYear-06-30"])->sum('total_amount'),
            'Q3' => Revenue::whereBetween('created_at', ["$currentYear-07-01", "$currentYear-09-30"])->sum('total_amount'),
            'Q4' => Revenue::whereBetween('created_at', ["$currentYear-10-01", "$currentYear-12-31"])->sum('total_amount'),
        ];

        // Receivables data dynamically for each month
        $receivablesData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::createFromDate(null, $i, 1)->format('F');
            $receivablesData[$monthName] = Revenue::where('status', 'paid')
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $i)
                ->sum('total_amount');
        }

        // Pass the data to the view
        return view('admin.report.organizational-chart', [
            'activeEmployees' => $activeEmployees,
            'inactiveEmployees' => $inactiveEmployees,
            'activeHotels' => $activeHotels,
            'inactiveHotels' => $inactiveHotels,
            'roiData' => $roiData,
            'receivablesData' => $receivablesData,
        ]);
    }


    public function HotelReport()
    {
        $revenue = Revenue::with('hotel')->orderBy('created_at', 'desc')->get();
        return view('admin.report.hotel-report', compact('revenue'));
    }

    public function RoiDashboard(Request $request)
    {
        // Get the selected year or use the current year by default
        $selectedYear = $request->input('year', date('Y'));

        // Initialize empty array for chart data
        $chartData = [];

        // Get data for each month
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        foreach ($months as $index => $month) {
            // Get the start and end date for each month of the selected year
            $startOfMonth = Carbon::create($selectedYear, $index + 1, 1)->startOfMonth();
            $endOfMonth = Carbon::create($selectedYear, $index + 1, 1)->endOfMonth();

            // Get revenue for the current month
            $monthlyRevenue = Revenue::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('total_amount');

            // Get employee payable for the current month
            $employees = Employee::all();
            $employeePayable = 0;
            foreach ($employees as $employee) {
                $timecards = Timecard::where('employee_id', $employee->id)
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->sum('total_hours');
                $payable = $employee->pay_rate * $timecards;
                $employeePayable += $payable;
            }

            // Calculate profit for the current month
            $profit = $monthlyRevenue - $employeePayable;

            // Prepare data for this month
            $chartData[] = [
                'month' => $month,
                'a' => $monthlyRevenue, // Total Revenue
                'b' => $employeePayable, // Employee Payable
                'c' => $profit, // Profit
            ];
        }

        $totalRevenue = array_sum(array_column($chartData, 'a'));
        $totalEmployeePayable = array_sum(array_column($chartData, 'b'));
        $totalProfit = array_sum(array_column($chartData, 'c'));

        return view('admin.report.roi-dashboard', [
            'totalRevenue' => $totalRevenue,
            'employeePayable' => $totalEmployeePayable,
            'profit' => $totalProfit,
            'chartData' => json_encode($chartData),
            'selectedYear' => $selectedYear,
        ]);
    }

    public function QuarterlyReports(Request $request)
    {
        $year = $request->has('year') ? $request->year : now()->year;

        // Fetching revenues and joining the hotels table to get hotel names
        $revenues = Revenue::query()
            ->select('revenues.*', 'hotels.name as hotel_name')
            ->join('hotels', 'revenues.hotel_id', '=', 'hotels.id');

        // Apply quarter filter
        if ($request->has('quarter') && !empty($request->quarter)) {
            $revenues->where(function ($query) use ($request, $year) {
                if ($request->quarter == 'Q1') {
                    $query->whereBetween('revenues.created_at', ["$year-01-01", "$year-03-31"]);
                } elseif ($request->quarter == 'Q2') {
                    $query->whereBetween('revenues.created_at', ["$year-04-01", "$year-06-30"]);
                } elseif ($request->quarter == 'Q3') {
                    $query->whereBetween('revenues.created_at', ["$year-07-01", "$year-09-30"]);
                } elseif ($request->quarter == 'Q4') {
                    $query->whereBetween('revenues.created_at', ["$year-10-01", "$year-12-31"]);
                }
            });
        }

        // Apply hotel filter
        if ($request->has('hotel_id')) {
            $revenues->where('revenues.hotel_id', $request->hotel_id);
        }

        if ($request->has('status')) {
            $revenues->where('revenues.status', $request->status);
        }

        $revenues = $revenues->get();
        $hotels = Hotel::all();

        return view('admin.report.quarterly-reports', compact('revenues', 'hotels', 'year'));
    }



    public function EmployeesReports()
    {
        // Fetch employees with unpaid timecards
        $employees = Employee::with(['user', 'timecards' => function ($query) {
            $query->where('status', ['unpaid', 'paid']);
        }])->get();

        $employeeTimecardsTotal = [];

        // Loop through each employee and calculate the total_amount from their unpaid timecards
        foreach ($employees as $employee) {
            $totalAmount = $employee->timecards->sum('total_amount');

            if ($totalAmount > 0) {
                $employeeTimecardsTotal[] = [
                    'employee_id'  => $employee->id,
                    'first_name'   => $employee->user->first_name,
                    'middle_name'  => $employee->user->middle_name,
                    'last_name'    => $employee->user->last_name,
                    'total_amount' => $totalAmount,
                    'email'        => $employee->user->email,
                    'hotel'        => $employee->hotel->name,
                    'status'       => $employee->timecards->first()->status
                ];
            }
            
        }

        return view('admin.report.employees-reports', compact('employeeTimecardsTotal'));
    }

    public function calculateAmount(Request $request)
    {
        $employeeId = $request->employee_id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Calculate total amount for timecards in the selected date range
        $totalAmount = Timecard::where('employee_id', $employeeId)
            ->whereBetween('date', [$startDate, $endDate])
            ->where('status', 'unpaid')
            ->sum('total_amount');

        return response()->json(['total_amount' => $totalAmount]);
    }

    public function markAsPaid(Request $request)
    {
        $employeeId = $request->employee_id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        Timecard::where('employee_id', $employeeId)
            ->whereBetween('date', [$startDate, $endDate])
            ->where('status', 'unpaid')
            ->update(['status' => 'paid']);

        return redirect()->back()->with('success', 'Timecards marked as paid successfully.');
    }



    public function payables()
    {
        // Fetch only employees with unpaid timecards and their related 'unpaid' timecards
        $employees = Employee::with(['timecards' => function ($query) {
            $query->where('status', 'paid');
        }])->whereHas('timecards', function ($query) {
            $query->where('status', 'paid');
        })->get();

        // Return the employee data along with unpaid timecards (which include daily wages)
        // return $employees;
        return view('admin.report.payables', compact('employees'));
    }
}
