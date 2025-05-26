<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Import Hash facade
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class LockScreenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('locked') && session('locked') == true) {
            return redirect()->route('admin.lock-screen');
        }
        
        return $next($request);
    }
}
