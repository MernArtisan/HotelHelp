<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetTimezone
{
    public function handle(Request $request, Closure $next)
    {
        if ($timezone = $request->cookie('user_timezone')) {
            config(['app.timezone' => $timezone]);
            date_default_timezone_set($timezone);
        }
        
        return $next($request);
    }
}