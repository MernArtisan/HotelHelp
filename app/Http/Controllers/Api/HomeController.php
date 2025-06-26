<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Employee;
use App\Models\Inquiry;
use App\Models\Notification;
use App\Models\Timecard;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    public function homeScreen(Request $request)
    {
        $today = Carbon::today()->format('Y-m-d');
        $currentWeek = Carbon::now()->weekOfYear;
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $user = auth()->user();
        $employeeId = $user->employee->id;

        $timecardToday = Timecard::where('employee_id', $employeeId)
            ->whereDate('date', $today)
            ->first();

        $todayHours = 0;
        if ($timecardToday) {
            $startTime = Carbon::parse($timecardToday->start_time)->setTimezone('UTC')->format('h:i:s A');
            $endTime = Carbon::parse($timecardToday->end_time)->setTimezone('UTC')->format('h:i:s A');
            $breakStart = Carbon::parse($timecardToday->break_start)->setTimezone('UTC')->format('h:i:s A');
            $breakEnd = Carbon::parse($timecardToday->break_end)->setTimezone('UTC')->format('h:i:s A');

            $workedTimeToday = Carbon::parse($endTime)->diffInHours(Carbon::parse($startTime));
            $breakTimeToday = Carbon::parse($breakEnd)->diffInHours(Carbon::parse($breakStart));
            $todayHours = $workedTimeToday - $breakTimeToday;
        }

        $weekStartDate = Carbon::now()->startOfWeek()->format('Y-m-d');
        $weekEndDate = Carbon::now()->endOfWeek()->format('Y-m-d');

        $totalHoursThisWeek = 0;
        $attendanceDaysThisWeek = 0;
        for ($date = Carbon::parse($weekStartDate); $date->lte(Carbon::parse($weekEndDate)); $date->addDay()) {
            if (!$date->isWeekend()) {
                $attendance = Timecard::where('employee_id', $employeeId)
                    ->whereDate('date', $date->format('Y-m-d'))
                    ->first();

                if ($attendance) {
                    $attendanceDaysThisWeek++;
                    $startTime = Carbon::parse($attendance->start_time)->setTimezone('UTC')->format('h:i:s A');
                    $endTime = Carbon::parse($attendance->end_time)->setTimezone('UTC')->format('h:i:s A');
                    $breakStart = Carbon::parse($attendance->break_start)->setTimezone('UTC')->format('h:i:s A');
                    $breakEnd = Carbon::parse($attendance->break_end)->setTimezone('UTC')->format('h:i:s A');

                    $workedTimeThisDay = Carbon::parse($endTime)->diffInHours(Carbon::parse($startTime));
                    $breakTimeThisDay = Carbon::parse($breakEnd)->diffInHours(Carbon::parse($breakStart));
                    $totalHoursThisWeek += $workedTimeThisDay - $breakTimeThisDay;
                }
            }
        }

        $totalDaysInMonth = 0;
        $totalWorkingHoursInMonth = 0;
        $attendanceDaysThisMonth = 0;

        $startDate = Carbon::create($currentYear, $currentMonth, 1);
        $endDate = Carbon::create($currentYear, $currentMonth, $startDate->daysInMonth);

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            if (!$date->isWeekend()) {
                $totalDaysInMonth++;

                $attendance = Timecard::where('employee_id', $employeeId)
                    ->whereDate('date', $date->format('Y-m-d'))
                    ->first();

                if ($attendance) {
                    $attendanceDaysThisMonth++;
                    $startTime = Carbon::parse($attendance->start_time)->setTimezone('UTC')->format('h:i:s A');
                    $endTime = Carbon::parse($attendance->end_time)->setTimezone('UTC')->format('h:i:s A');
                    $breakStart = Carbon::parse($attendance->break_start)->setTimezone('UTC')->format('h:i:s A');
                    $breakEnd = Carbon::parse($attendance->break_end)->setTimezone('UTC')->format('h:i:s A');

                    $workedTimeThisDay = Carbon::parse($endTime)->diffInHours(Carbon::parse($startTime));
                    $breakTimeThisDay = Carbon::parse($breakEnd)->diffInHours(Carbon::parse($breakStart));
                    $totalWorkingHoursInMonth += $workedTimeThisDay - $breakTimeThisDay;
                }
            }
        }

        $expectedWorkingDaysInMonth = $totalDaysInMonth;
        $expectedHoursInMonth = $expectedWorkingDaysInMonth * 8;

        $expectedHoursThisWeek = 40;

        // Prevent division by zero
        $attendancePercentage = $totalDaysInMonth > 0
            ? number_format(($attendanceDaysThisMonth / $totalDaysInMonth) * 100, 2) . '%'
            : 'N/A';

        $todayFormatted = [
            'today_hour' => $todayHours,
            'expected_hour' => 8
        ];

        $weekFormatted = [
            'week_on_hour' => $totalHoursThisWeek,
            'week_expected_hour' => 40
        ];

        $monthFormatted = [
            'month_on_hour' => $totalWorkingHoursInMonth,
            'month_expected_hour' => $expectedHoursInMonth
        ];

        return response()->json([
            'today' => Carbon::now()->setTimezone('UTC')->format('d-M-Y'),
            'data' => [
                'user' => $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name,
                'designation' => $user->employee->designation,
                'employee_id' => $user->employee->employee_id,
                'start_time' => null,
                'break_start' => null,
                'break_end' => null,
                'end_time' => null,
                'total_hours' => $todayHours ?? null,
                'total_amount' => $timecardToday->total_amount ?? null,
                'attendance_percentage' => $attendancePercentage,
                'total_working_days_in_month' => $totalDaysInMonth,
                'attendance_days' => $attendanceDaysThisMonth,
                'today' => $todayFormatted,
                'week' => $weekFormatted,
                'month' => $monthFormatted,
            ],
            'message' => 'Here is the statistics for today, this week, and this month.'
        ]);
    }



    public function updateTime(Request $request)
    {
        $user = auth()->user();  // logged-in user
        $employeeId = $user->employee->id;

        // Validate the input times
        $request->validate([
            'start_time' => 'nullable|string', // Validate as a string
            'break_start' => 'nullable|string',
            'break_end' => 'nullable|string',
            'end_time' => 'nullable|string',
        ]);

        // Get today's timecard or create a new one if none exists
        $timecard = Timecard::where('employee_id', $employeeId)
            ->whereDate('date', Carbon::today()->format('Y-m-d'))
            ->first();

        // Case 1: Start Time post
        if (!$timecard || is_null($timecard->start_time)) {
            $startTime = $request->input('start_time');

            $timecard = $timecard ?: new Timecard();
            $timecard->employee_id = $employeeId;
            $timecard->date = Carbon::today()->format('Y-m-d');
            $timecard->start_time = $startTime;  // Save the raw input value
            $timecard->save();

            return response()->json([
                'message' => 'Start Time recorded successfully',
                'punch_in_time' => $startTime,  // Return the raw input time
                'status' => 'success',
            ]);
        }

        // Case 2: Break Start post (only if the user is taking a break)
        if ($timecard->start_time && is_null($timecard->break_start) && $request->has('break_start')) {
            $breakStart = $request->input('break_start');

            $timecard->break_start = $breakStart;  // Save the raw input value
            $timecard->save();

            return response()->json([
                'message' => 'Break Start recorded successfully',
                'break_in_time' => $breakStart,  // Return the raw input time
                'status' => 'success',
            ]);
        }

        // Case 3: Break End post (only if the user has taken a break)
        if ($timecard->break_start && is_null($timecard->break_end) && $request->has('break_end')) {
            $breakEnd = $request->input('break_end');
            $breakStart = $timecard->break_start;

            $timecard->break_end = $breakEnd;  // Save the raw input value
            $timecard->save();

            return response()->json([
                'message' => 'Break End recorded successfully',
                'break_start_time' => $breakStart,
                'break_end_time' => $breakEnd,  // Return the raw input time
                'status' => 'success',
            ]);
        }

        // Case 4: End Time post (if no break taken, or break has already ended)
        if ($timecard->start_time && is_null($timecard->end_time)) {
            $endTime = $request->input('end_time');

            $timecard->end_time = $endTime;  // Save the raw input value

            // Calculate worked hours (considering break duration if break was taken)
            $workedDuration = Carbon::parse($timecard->end_time)->diff(Carbon::parse($timecard->start_time));

            $workedHours = $workedDuration->h + $workedDuration->i / 60;

            // If break is taken, subtract break time
            if ($timecard->break_start && $timecard->break_end) {
                $breakDuration = Carbon::parse($timecard->break_end)->diff(Carbon::parse($timecard->break_start));
                $breakHours = $breakDuration->h + $breakDuration->i / 60;
                $workedHours -= $breakHours;
            }

            // Fetch the logged-in user's pay rate from the employees table
            $employee = $user->employee;
            $payRate = $employee->pay_rate;

            // Calculate total amount based on pay rate and worked hours
            $totalAmount = $payRate * $workedHours;

            // Save the total hours and amount
            $timecard->total_hours = $workedHours;
            $timecard->total_amount = $totalAmount;
            $timecard->save();

            return response()->json([
                'message' => 'End Time recorded successfully',
                'status' => 'success',
                'punch_in_time' => $timecard->start_time,
                'punch_out_time' => $endTime,  // Return the raw input end time
                'total_hours' => $workedHours,
                'total_amount' => $totalAmount,
            ]);
        }

        return response()->json([
            'message' => 'Time update process already completed for today.',
            'status' => 'error',
        ]);
    }


    public function getMonthlyAttendanceOverview(Request $request)
    {
        // Validate the month input from the user
        $request->validate([
            'month' => 'required|integer|min:1|max:12', // Ensure the month is between 1 and 12
        ]);

        // Get the selected month and the current year
        $selectedMonth = $request->input('month');
        $currentYear = Carbon::now()->year;

        $user = auth()->user();
        $employeeId = $user->employee->id;

        // Get the start and end date of the selected month
        $startDate = Carbon::create($currentYear, $selectedMonth, 1);
        $endDate = Carbon::create($currentYear, $selectedMonth, $startDate->daysInMonth);

        // Initialize counters
        $totalDaysInMonth = 0;
        $attendanceDaysThisMonth = 0;
        $totalMonthHours = 0;

        // Today's attendance data
        $today = Carbon::now()->startOfDay();
        $todayAttendance = Timecard::where('employee_id', $employeeId)
            ->whereDate('date', $today->format('Y-m-d'))
            ->first();

        $todayWorkedHours = 0;
        if ($todayAttendance) {
            $todayWorkedHours = Carbon::parse($todayAttendance->start_time)
                ->diffInHours(Carbon::parse($todayAttendance->end_time));
        }

        // Weekly attendance data (start of the week)
        $weekStartDate = Carbon::now()->startOfWeek();
        $totalWeekHours = 0;

        // Loop through the days of the selected month
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            if (!$date->isWeekend()) {
                $totalDaysInMonth++;

                // Check attendance for each day
                $attendance = Timecard::where('employee_id', $employeeId)
                    ->whereDate('date', $date->format('Y-m-d'))
                    ->first();

                if ($attendance) {
                    $attendanceDaysThisMonth++;

                    // Calculate worked hours for the month
                    $workedHours = Carbon::parse($attendance->start_time)
                        ->diffInHours(Carbon::parse($attendance->end_time));
                    $totalMonthHours += $workedHours;

                    // If it's within the current week, accumulate week hours
                    if ($date->gte($weekStartDate)) {
                        $totalWeekHours += $workedHours;
                    }
                }
            }
        }

        // Format the statistics for today, week, and month
        $todayFormatted = [
            'today_hour' => $todayWorkedHours,
            'expected_hour' => 8 // Assuming 8 hours expected per working day
        ];

        $weekFormatted = [
            'week_on_hour' => $totalWeekHours,
            'week_expected_hour' => Carbon::now()->diffInWeekdays($weekStartDate) * 8 // Expected hours for the week
        ];

        $monthFormatted = [
            'month_on_hour' => $totalMonthHours, // Worked hours for the month
            'month_expected_hour' => $totalDaysInMonth * 8 // Expected hours for the month (8 hours per working day)
        ];

        return response()->json([
            'status' => 'success',
            'data' => [

                'total_working_days_in_month' => $totalDaysInMonth,
                'attendance_days' => $attendanceDaysThisMonth,
            ],
            // 'Statistics' => '--------------------------------------------------------------------------------------------------------',
            // 'today' => $todayFormatted,
            // 'week' => $weekFormatted,
            // 'month' => $monthFormatted,
        ]);
    }

    public function getAttendanceByDate(Request $request)
    {
        // Validate the date input
        $request->validate([
            'date' => 'required|date', // Ensure the date is a valid date format
        ]);

        // Get the selected date from the query parameter
        $selectedDate = $request->input('date');
        $user = auth()->user();
        $employeeId = $user->employee->id;

        // Fetch the attendance record for the selected date
        $attendance = Timecard::where('employee_id', $employeeId)
            ->whereDate('date', $selectedDate)
            ->first();

        // If attendance record is found, return the details
        if ($attendance) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'check_in' => $attendance->start_time,
                    'check_out' => $attendance->end_time,
                    'break_start' => $attendance->break_start,
                    'break_end' => $attendance->break_end,
                ]
            ]);
        } else {
            // If no record is found, return an error message
            return response()->json([
                'status' => 'error',
                'message' => 'No attendance record found for the selected date.'
            ], 404);
        }
    }


    public function getProfile(Request $request)
    {
        $user = auth()->user();
        $employee = $user->employee;

        return response()->json([
            'status' => 'success',
            'data' => [
                'image' => $employee->user->image
                    ? asset('profileImage/' . $employee->user->image)
                    : asset('default.png'),
                'name' => $employee->user->first_name . ' ' . $employee->user->middle_name . ' ' . $employee->user->last_name,
                'email' => $employee->user->email,
                'contact_number' => $employee->user->contact_number,
                'employee_id' => $employee->employee_id,
                'joining_date' => $employee->created_at->format('Y-m-d'),
                'work_location' => $employee->location,
                'pay_rate' => $employee->pay_rate,
                'designation' => $employee->designation,
            ]
        ]);


    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $employee = $user->employee;

        // Validation rules
        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'contact_number' => 'nullable',
            'email' => 'nullable|email|max:255',
            'contact_number' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'pay_rate' => 'nullable|numeric',
            'designation' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Update user data only if provided
        if ($request->filled('first_name')) {
            $user->first_name = $request->input('first_name');
        }
        if ($request->filled('middle_name')) {
            $user->middle_name = $request->input('middle_name');
        }
        if ($request->filled('last_name')) {
            $user->last_name = $request->input('last_name');
        }
        if ($request->filled('email')) {
            $user->email = $request->input('email');
        }
        if ($request->filled('contact_number')) {
            $user->contact_number = $request->input('contact_number');
        }
        $user->save();

        // Update employee data only if provided
        if ($request->filled('location')) {
            $employee->location = $request->input('location');
        }
        if ($request->filled('pay_rate')) {
            $employee->pay_rate = $request->input('pay_rate');
        }
        if ($request->filled('designation')) {
            $employee->designation = $request->input('designation');
        }
        $employee->save();

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Delete old image if exists
            if ($employee->user->image && file_exists(public_path('profileImage/' . $employee->user->image))) {
                unlink(public_path('profileImage/' . $employee->user->image));
            }

            // Move the new image to profileImage folder
            $image->move(public_path('profileImage'), $imageName);
            $user->image = $imageName;
            $user->save();
        }

        // Return response with updated data
        return response()->json([
            'status' => 'success',
            'data' => [
                'image' => $user->image
                    ? asset('profileImage/' . $user->image)
                    : asset('default.png'),
                'name' => $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name,
                'email' => $user->email,
                'contact_number' => $user->contact_number,
                'employee_id' => $employee->employee_id,
                'joining_date' => $employee->created_at->format('Y-m-d'),
                'work_location' => $employee->location,
                'pay_rate' => $employee->pay_rate,
                'designation' => $employee->designation,
            ]
        ]);
    }

    public function payRoll(Request $request)
    {
        // Get the current user
        $user = auth()->user();
        $employee = $user->employee;

        // Get the current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Fetch the total working hours for the user in the current month
        $totalHoursWorked = Timecard::where('employee_id', $employee->id)
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->sum('total_hours'); // Assuming 'hours_worked' is the column storing the worked hours

        // Get the user's pay rate
        $payRate = $employee->pay_rate;

        // Calculate the total amount (subtotal) for the current month
        $subtotal = $totalHoursWorked * $payRate;

        // Return the response
        return response()->json([
            'status' => 'success',
            'data' => [
                'image' => $user->image
                    ? asset('profileImage/' . $user->image)
                    : asset('default.png'),
                'employee_id' => $employee->employee_id,
                'designation' => $employee->designation,
                'name' => $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name,
                'total_hours' => intval($totalHoursWorked),
                'pay_rate' => $payRate,
                'subtotal' => $subtotal,
            ]
        ]);
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ]);

            $user = auth()->user();
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json(['error' => 'The current password is incorrect.']);
            }
            $user->password = Hash::make($request->new_password);
            $user->save();
            return response()->json(['message' => 'Password changed successfully'], 200);
        } catch (Exception $exception) {
            return response()->json([
                "error" => $exception->getMessage()
            ]);
        }
    }

    public function adminDetail()
    {
        $admins = User::role('tiar4')->get(['email', 'contact_number']);
        return response()->json([
            'status' => 'success',
            'data' => $admins,
            'message' => 'Admin details fetched successfully'
        ]);
    }

    public function inquiries(Request $request)
    {
        try {
            DB::beginTransaction();
            $authUserId = auth()->user()->id;

            $employee = Employee::where('user_id', $authUserId)->first();
            if (!$employee) {
                return response()->json([
                    'status' => false,
                    'message' => 'Employee not found',
                ]);
            }

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'message' => 'required|string',
            ]);

            $inquiry = Inquiry::create([
                'employee_id' => $employee->id,
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
                'seen' => 0,
            ]);

            $authUser = auth()->user();
            $admin = User::role('tiar4')->first();

            Notification::create([
                'employee_id' => $employee->id,
                'message' => $authUser->name . ' has contacted you',
                'notifyBy' => 'admin Contact',
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Inquiry submitted successfully',
                'data' => $inquiry,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }


    public function privacy()
    {
        try {
            $faqs = Content::select('id', 'name', 'description')->where('id', 1)->get();

            // Remove HTML tags from the description
            foreach ($faqs as $faq) {
                $faq->description = strip_tags($faq->description);
            }

            return response()->json([
                'status' => true,
                'Data' => $faqs,
                'Message' => 'Privacy Policy fetched successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function termsCondition()
    {
        try {
            $faqs = Content::select('id', 'name', 'description')->where('id', 2)->get();

            // Remove HTML tags from the description
            foreach ($faqs as $faq) {
                $faq->description = strip_tags($faq->description);
            }

            return response()->json([
                'status' => true,
                'Data' => $faqs,
                'Message' => 'Terms & Conditions fetched successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }


    public function getNotification(Request $request)
    {
        $user = auth()->user();
        $employee = Employee::where('user_id', $user->id)->first();
        $notifications = Notification::where('employee_id', $employee->id)->get();
        $notifications = $notifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'message' => $notification->message,
                'notify' => $notification->notifyBy,
                'created_at' => Carbon::parse($notification->created_at)->diffForHumans(),
            ];
        });
        return response()->json([
            'status' => true,
            'data' => [
                'notifications' => $notifications,
            ]
        ], 200);
    }
}
