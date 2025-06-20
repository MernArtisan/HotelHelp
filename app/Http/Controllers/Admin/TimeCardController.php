<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Hotel;
use App\Models\PayGroup;
use App\Models\Timecard;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class TimeCardController extends Controller
{
    public function timecardCreate()
    {
        $timeCard = Timecard::with('employee.user', 'employee.hotel', 'employee.payGroup')->orderBy('created_at', 'desc')->get();

        $timeCard->each(function ($card) {
            $breakStart = Carbon::parse($card->break_start);
            $breakEnd = Carbon::parse($card->break_end);
            $breakDurationInMinutes = $breakStart->diffInMinutes($breakEnd);
            $card->break_duration_in_minutes = $breakDurationInMinutes;

            $startTime = Carbon::parse($card->start_time);
            $endTime = Carbon::parse($card->end_time);
            $workDurationInMinutes = $startTime->diffInMinutes($endTime);
            $actualWorkDurationInMinutes = $workDurationInMinutes - $breakDurationInMinutes;
            $workDurationInHours = floor($actualWorkDurationInMinutes / 60);
            $workDurationRemainingMinutes = $actualWorkDurationInMinutes % 60;

            $card->working_hours = $workDurationInHours;
            $card->remaining_minutes = $workDurationRemainingMinutes;
        });

        $employees = Employee::where('status', 'active')->orderBy('id', 'desc')->get();

        $hotels = Hotel::all();

        $payGroups = PayGroup::all();

        return view('admin.timecard.index', compact('employees', 'timeCard', 'hotels', 'payGroups'));
    }


    public function timecardPost(Request $request)
    {
        try {
            // Validation
            $request->validate([
                'employee_id' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'break_start' => 'nullable',
                'break_end' => 'nullable',
                'date' => 'required|date',
            ]);

            // Get Employee
            $employee = Employee::findOrFail($request->employee_id);
            $pay_rate = $employee->pay_rate;

            // Parse Start and End time
            $start_time = Carbon::parse($request->start_time);
            $end_time = Carbon::parse($request->end_time);

            // Calculate Worked Hours
            $worked_hours = $end_time->diffInMinutes($start_time) / 60;

            // Calculate Break Time if applicable
            if ($request->break_start && $request->break_end) {
                $break_start = Carbon::parse($request->break_start);
                $break_end = Carbon::parse($request->break_end);
                $break_duration = $break_end->diffInMinutes($break_start) / 60;
                $worked_hours -= $break_duration;
            }

            // Total Amount Calculation
            $total_amount = $worked_hours * $pay_rate;

            // Prevent Timecard Entry for Future Dates
            if (Carbon::parse($request->date)->isFuture()) {
                return redirect()->back()->with('error', 'You cannot mark time for a future date');
            }

            // Check if Timecard Already Exists for this Date
            $alreadyIn = Timecard::where('date', $request->date)
                ->where('employee_id', $request->employee_id)
                ->first();

            if ($alreadyIn) {
                return redirect()->back()->with('error', 'You have already marked timecard for this date');
            }

            // Create New Timecard
            TimeCard::create([
                'employee_id' => $request->employee_id,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'break_start' => $request->break_start,
                'break_end' => $request->break_end,
                'total_hours' => $worked_hours,
                'total_amount' => $total_amount,
                'date' => $request->date,
            ]);

            return redirect()->back()->with('success', 'TimeCard marked successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong while saving your timecard.');
        }
    }
}
