<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch hotel and employee data
        $hotelsActive = Hotel::where('status', 'active')->get();
        $totalHotels = Hotel::all();
        $employeesActive = Employee::all();
        $hotels = Hotel::select('name', 'latitude', 'longitude')->get(); 
    
        // Fetch total revenues amount
        $totalAmount = DB::table('revenues')->sum('total_amount');
    
        // Fetch this month's and last month's revenues
        $thisMonthAmount = DB::table('revenues')
            ->whereMonth('created_at', now()->month)
            ->sum('total_amount');
    
        $lastMonthAmount = DB::table('revenues')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('total_amount');
    
        // Pass all data to the view
        return view('admin.dashboard', compact(
            'hotelsActive', 'totalHotels', 'employeesActive', 'hotels', 
            'totalAmount', 'thisMonthAmount', 'lastMonthAmount'
        ));
    }
    
    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        session()->forget('locked');
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Successfully logged out');
    }

    public function LockScreen(Request $request)
    {
        session(['locked' => true]);
        return view('admin.lockscreen');
    }


    public function unlockScreen(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors(['You must be logged in to unlock the screen.']);
        }
        if (Hash::check($request->password, $user->password)) {
            session(['locked' => false]);
            session()->forget('locked');
            return redirect()->route('admin.dashboard')->with('success', 'Successfully unlocked');
        } else {
            return redirect()->back()->withErrors(['Invalid password.'])->with('error', 'Password does not match');
        }
    }

    public function PermissionDenied(){
        return view('admin.permission-denied');
    }
}
