<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Job;
use App\Models\Hotel;
use App\Models\Notification;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AnnoicmentController extends Controller
{
    public function announcements()
    {
        $announcements = Notification::orderBy('id', 'desc')->get();

        // Only jobs that exist in employees
        $jobs = Job::whereIn('id', function ($query) {
            $query->select('job_id')->from('employees')->whereNotNull('job_id');
        })->distinct()->orderBy('id', 'desc')->get();

        // Only hotels that exist in employees
        $hotels = Hotel::whereIn('id', function ($query) {
            $query->select('hotel_id')->from('employees')->whereNotNull('hotel_id');
        })->distinct()->orderBy('id', 'desc')->get();

        $roles = Role::where('name', '!=', 'tiar4')->get();

        return view('admin.announcements.create', [
            'jobs' => $jobs,
            'roles' => $roles,
            'hotels' => $hotels,
            'announcements' => $announcements,
        ]);
    }




    public function announcementsStore(Request $request)
    {
        try {
            $request->validate([
                'jobs' => 'required|array',
                'roles' => 'required|array',
                'hotels' => 'required|array',
                'notifyBy' => 'required|string',
                'message' => 'required|string',
            ]);

            $employees = Employee::query();

            // Filter jobs if not All
            if (!in_array('All', $request->jobs)) {
                $employees->whereHas('job', function ($q) use ($request) {
                    $q->whereIn('name', $request->jobs);
                });
            }

            // Filter roles if not All
            if (!in_array('All', $request->roles)) {
                $employees->whereHas('user.roles', function ($q) use ($request) {
                    $q->whereIn('name', $request->roles);
                });
            }

            // Filter hotels if not All
            if (!in_array('All', $request->hotels)) {
                $employees->whereIn('hotel_id', $request->hotels);
            }

            $employees = $employees->get();

            if ($employees->isEmpty()) {
                return back()->with('error', 'No employees matched the selected filters.');
            }

            foreach ($employees as $employee) {
                Notification::create([
                    'employee_id' => $employee->id,
                    'notifyBy' => $request->notifyBy,
                    'message' => $request->message,
                ]);
            }

            return redirect()->back()->with('success', 'Announcement sent successfully!');
        } catch (\Exception $e) {
            \Log::error('Announcement Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while sending the announcement.');
        }
    }
}
