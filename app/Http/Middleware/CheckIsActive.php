<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check())
        {
            if (Auth::User()->status != 'active')
            {
                Auth::logout();
                return redirect()->to('/')->with('warning', 'Your account has been deactivated by admin.');
            }
        }

        return $next($request);
    }
}
