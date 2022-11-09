<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIsDelete
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
            if (Auth::User()->deleted_at != null)
            {
                Auth::logout();
                return redirect()->to('login')->with('warning', 'Your account has been deleted by admin.');
            }
        }
        return $next($request);
    }
}
