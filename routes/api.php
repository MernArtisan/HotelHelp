<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('home-screen',[HomeController::class,'homeScreen']);
    Route::post('update-time', [HomeController::class, 'updateTime']);
    Route::post('attendance-overview', [HomeController::class, 'getMonthlyAttendanceOverview']);
    Route::get('attendance-by-date', [HomeController::class, 'getAttendanceByDate']);
    Route::get('get-profile',[HomeController::class, 'getProfile']);
    Route::post('update-profile', [HomeController::class, 'updateProfile']);
    Route::get('pay-roll',[HomeController::class, 'payRoll']);
    Route::post('change-password', [HomeController::class, 'changePassword']);
    Route::get('admin-detail', [HomeController::class, 'adminDetail']);
    Route::post('inquiries', [HomeController::class, 'inquiries']);
    Route::get('privacy', [HomeController::class, 'privacy']);
    Route::get('terms-condition', [HomeController::class, 'termsCondition']);
    Route::get('notification-get', [HomeController::class, 'getNotification']);
    
});
