<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendForgotPasswordOTP;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'fcm_token' => 'required|string',
        ]);

        // Find user by email
        $user = User::where('email', $request->email)->first();

        // Check if user exists and password matches
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials.'
            ], 401);
        }

        // Check if user is an employee
        if (!$user->employee) {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized as an employee.',
            ], 403);
        }

        $userEmployeeStatus = $user->employee->status;

        if ($userEmployeeStatus == 'terminated') {
            return response()->json([
                'status' => false,
                'message' => 'Your account has been terminated.'
            ], 403); // Use 403 Forbidden instead of 401 Unauthorized
        }

        if ($userEmployeeStatus == 'left') {
            return response()->json([
                'status' => false,
                'message' => 'You are not allowed to continue to this account.'
            ], 403); // Use 403 Forbidden
        }

        if ($userEmployeeStatus == 'hold') {
            return response()->json([
                'status' => false,
                'message' => 'You are hired but still on hold in ' . env('APP_NAME'),
            ], 403);
        }

        $user->fcm_token = $request->fcm_token;
        $user->save();

        $user->image = $user->image
            ? asset('profileImage/' . $user->image)
            : asset('default.png');

        $token = $user->createToken('auth_token')->plainTextToken;
        $tiar4User = User::whereHas('roles', function ($query) {
            $query->where('name', 'tiar4');
        })->first();
    
        if (!$tiar4User) {
            return response()->json([
                'status' => false,
                'message' => 'No user found with the "tiar4" role.',
            ], 404);
        }
    
        // Get the tiar4 role user's email and contact number
        $tiar4UserEmail = $tiar4User->email;
        $tiar4UserContact = $tiar4User->contact_number;
        return response()->json([
            'status' => true,
            'message' => 'Login successful!',
            'token' => $token,
            'adminEmail' => $tiar4UserEmail,
            'adminPhone' => $tiar4UserContact,
            'data' => $user,
        ], 200);
    }



   public function forgotPassword(Request $request)
   {
        $request->validate([
            'email' => 'required|email',
        ]);
    
        // Check if the user exists
        $requestedUser = User::where('email', $request->email)->first();
    
        if (!$requestedUser) {
            return response()->json([
                'status' => false,
                'message' => 'User not found with this email.',
            ], 404); // If user doesn't exist, return 404
        }
    
        // Check if the user has an employee record and the status of that record
        $userEmployeeStatus = $requestedUser->employee ? $requestedUser->employee->status : null;
    
        // Handle employee status checks
        if ($userEmployeeStatus == 'terminated') {
            return response()->json([
                'status' => false,
                'message' => 'Your account has been terminated.',
            ], 403); // Use 403 Forbidden instead of 401 Unauthorized
        }
    
        if ($userEmployeeStatus == 'left') {
            return response()->json([
                'status' => false,
                'message' => 'You are not allowed to continue to this account.',
            ], 403); // Use 403 Forbidden
        }
    
        // Check if a password reset request already exists for this email
        // $userExists = DB::table('password_reset_tokens')->where('email', '=', $request->email)->first();
    
        // if ($userExists) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'A password reset request has already been sent to this email.',
        //     ], 409); // Conflict - if a request already exists
        // }
    
        // Generate OTP
        $otp = rand(1000, 9999);
    
        // Store the OTP in the database
        DB::table('password_reset_tokens')->updateOrInsert([
            'email' => $request->email
        ], [
            'token' => $otp,
            'created_at' => now(),
        ]);
    
        // Dispatch a job to send the OTP to the user's email
        dispatch(new SendForgotPasswordOTP($request->email, $otp));
    
        return response()->json([
            'status' => true,
            'message' => 'OTP sent to your registered email.',
            'email' => $request->email,
            'otp' => $otp,
        ], 200); // Success - OTP sent
}


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string',
        ]);

        $otpCheck = DB::table('password_reset_tokens')->where([
            'email' => $request->email,
            'token' => $request->otp,
        ])->first();
        if (!$otpCheck) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP'
            ], 401);
        }
        return response()->json([
            'status' => true,
            'message' => 'OTP verified successfully!',
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'status' => false,
                'error' => 'User not found with this email.'
            ]);
        }

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Password reset successfully!',
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'User logged out successfully!'
        ]);
    }

}
