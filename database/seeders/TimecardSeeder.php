<?php
namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Timecard;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TimecardSeeder extends Seeder
{
    public function run()
    {
        // Loop to create timecards for existing employees
        $employees = Employee::all(); // Get all existing employees

        // Check if there are employees available
        if ($employees->isNotEmpty()) {
            foreach ($employees as $employee) {
                // Define the start, break, and end times
                $start_time = now();
                $break_start = now()->addHours(1);
                $break_end = now()->addHours(1, 30);
                $end_time = now()->addHours(8);

                // Calculate the total hours worked (excluding break time)
                $worked_hours = $start_time->diffInHours($end_time);
                $break_duration = $break_start->diffInHours($break_end);
                $total_hours = $worked_hours - $break_duration;

                // Calculate the total amount for the day based on hour_rate
                $pay_rate = $employee->pay_rate; // Get the hour_rate from the employee
                $total_amount = $total_hours * $pay_rate; // Calculate the total amount

                // Create the timecard
                Timecard::create([
                    'employee_id' => $employee->id, // Assign employee_id
                    'date' => now()->format('Y-m-d'),
                    'start_time' => $start_time,
                    'break_start' => $break_start,
                    'break_end' => $break_end,
                    'end_time' => $end_time,
                    'total_hours' => $total_hours, // Save the calculated total hours
                    'total_amount' => $total_amount // Save the calculated total amount
                ]);
            }
        } else {
            echo "No employees found to assign timecards!";
        }
    }
}
