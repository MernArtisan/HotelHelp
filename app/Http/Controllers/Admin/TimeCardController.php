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
    // public function timecardCreate()
    // {
    //     // Fetch timecards with associated employee data, ordered by the most recent 'created_at' first
    //     $timeCard = Timecard::with('employee.user', 'employee.hotel', 'employee.payGroup')
    //         ->orderBy('created_at', 'asc')
    //         ->get();

    //     // Loop through each timecard to calculate break and work durations
    //     $timeCard->each(function ($card) {
    //         // Break duration in minutes
    //         $breakStart = Carbon::parse($card->break_start);
    //         $breakEnd = Carbon::parse($card->break_end);
    //         $breakDurationInMinutes = $breakStart->diffInMinutes($breakEnd);
    //         $card->break_duration_in_minutes = $breakDurationInMinutes;

    //         // Work duration calculation (start_time to end_time minus break duration)
    //         $startTime = Carbon::parse($card->start_time);
    //         $endTime = Carbon::parse($card->end_time);
    //         $workDurationInMinutes = $startTime->diffInMinutes($endTime);
    //         $actualWorkDurationInMinutes = $workDurationInMinutes - $breakDurationInMinutes;
    //         $workDurationInHours = floor($actualWorkDurationInMinutes / 60);
    //         $workDurationRemainingMinutes = $actualWorkDurationInMinutes % 60;

    //         // Adding calculated working hours and remaining minutes
    //         $card->working_hours = $workDurationInHours;
    //         $card->remaining_minutes = $workDurationRemainingMinutes;
    //     });

    //     // Fetch active employees, ordered by ID in descending order
    //     $employees = Employee::where('status', 'active')
    //         ->orderBy('id', 'desc')
    //         ->get();

    //     // Fetch all hotels and payGroups
    //     $hotels = Hotel::all();
    //     $payGroups = PayGroup::all();

    //     // Return the view with the necessary data
    //     return view('admin.timecard.index', compact('employees', 'timeCard', 'hotels', 'payGroups'));
    // }

    public function timecardCreate(Request $request)
    {
        // Get timezone from cookie or use default
        $timezone = $request->cookie('user_timezone') ?? config('app.timezone');
        
        // Fetch timecards with associated employee data
        $timeCard = Timecard::with('employee.user', 'employee.hotel', 'employee.payGroup')
            ->orderBy('created_at', 'asc')
            ->get();

        // Process each timecard
        $timeCard->each(function ($card) use ($timezone) {
            // Parse all times as UTC and convert to user's timezone
            $start = Carbon::parse($card->start_time)->setTimezone('UTC')->setTimezone($timezone);
            $end = Carbon::parse($card->end_time)->setTimezone('UTC')->setTimezone($timezone);
            $breakStart = Carbon::parse($card->break_start)->setTimezone('UTC')->setTimezone($timezone);
            $breakEnd = Carbon::parse($card->break_end)->setTimezone('UTC')->setTimezone($timezone);

            // Store formatted times
            $card->local_start_time = $start->format('Y-m-d H:i:s');
            $card->local_break_start = $breakStart->format('Y-m-d H:i:s');
            $card->local_break_end = $breakEnd->format('Y-m-d H:i:s');
            $card->local_end_time = $end->format('Y-m-d H:i:s');
            
            // 12-hour format versions
            $card->display_start = $start->format('h:i A');
            $card->display_break_start = $breakStart->format('h:i A');
            $card->display_break_end = $breakEnd->format('h:i A');
            $card->display_end = $end->format('h:i A');

            // Validate time sequence
            if ($end->lte($start)) {
                $card->working_hours = 0;
                $card->remaining_minutes = 0;
                $card->break_duration_in_minutes = 0;
                $card->timecard_error = 'End time must be after start time';
                return;
            }

            // Calculate break duration
            $breakDuration = ($breakEnd->gt($breakStart)) ? $breakStart->diffInMinutes($breakEnd) : 0;
            $card->break_duration_in_minutes = $breakDuration;

            // Calculate work duration
            $totalMinutes = $start->diffInMinutes($end);
            $workMinutes = max(0, $totalMinutes - $breakDuration);
            $card->working_hours = floor($workMinutes / 60);
            $card->remaining_minutes = $workMinutes % 60;
        });

        // Fetch other data
        $employees = Employee::where('status', 'active')->orderBy('id', 'desc')->get();
        $hotels = Hotel::all();
        $payGroups = PayGroup::all();

        return view('admin.timecard.index', compact('timeCard', 'employees', 'hotels', 'payGroups'));
    }



    public function timecardPost(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'break_start' => 'nullable',
                'break_end' => 'nullable',
                'date' => 'required|date',
            ]);

            $employee = Employee::findOrFail($request->employee_id);
            $pay_rate = $employee->pay_rate;

            $start_time = Carbon::parse($request->start_time);
            $end_time = Carbon::parse($request->end_time);

            $worked_hours = $end_time->diffInMinutes($start_time) / 60;

            if ($request->break_start && $request->break_end) {
                $break_start = Carbon::parse($request->break_start);
                $break_end = Carbon::parse($request->break_end);
                $break_duration = $break_end->diffInMinutes($break_start) / 60;
                $worked_hours -= $break_duration;
            }

            $total_amount = $worked_hours * $pay_rate;
            $alreadyIn = Timecard::where('date', $request->date)
                ->where('employee_id', $request->employee_id)
                ->first();

            if ($alreadyIn) {
                return redirect()->back()->with('error', 'You have already marked timecard for this date');
            }


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
