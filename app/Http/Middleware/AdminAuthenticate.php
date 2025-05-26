<?php

// app/Http/Middleware/AdminAuthenticate.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        // If the user is not authenticated, redirect to the login page
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}

