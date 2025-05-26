<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile()
    {
        $hotelsActive = Hotel::where('status', 'active')->get();
        $totalHotels = Hotel::all();
        $employeesActive = Employee::where('status', 'active')->get();
        $hotels = Hotel::select('name', 'latitude', 'longitude')->get(); // Get hotels with latitude and longitude
        return view('admin.profile.index',compact('hotels', 'totalHotels','hotelsActive','employeesActive'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.'])->with('error', 'The old password is incorrect.');
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'required|regex:/^\d{10}$/',
            'birth_date' => 'required|date',
            'ssn' => 'required|string',
            'address' => 'required|string|max:255',
            'about' => 'nullable|string|max:500',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'gender' => 'required|in:male,female,other',
        ]);

        $user = Auth::user();
        if ($request->hasFile('image')) {
            if ($user->image && file_exists(public_path('profileImage/' . $user->image))) {
                unlink(public_path('profileImage/' . $user->image)); 
            }
    
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('profileImage'), $imageName);
    
            $user->image = 'profileImage/' . $imageName;
        }
        $user->update([
            'name' => $validated['name'],
            'contact_number' => $validated['contact_number'],
            'birth_date' => $validated['birth_date'],
            'ssn' => $validated['ssn'],
            'address' => $validated['address'],
            'about' => $validated['about'],
            'marital_status' => $validated['marital_status'],
            'gender' => $validated['gender'],
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
