<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        return $request->all();
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Login Successful, ' . Auth::user()->name);
            }


            return redirect()->back()->with('error', 'Invalid Credentials');
        } catch (Exception $e) {
            return back()->withErrors([
                'error' => 'There was an error processing your request. Please try again later.',
            ]);
        }
    }
}
