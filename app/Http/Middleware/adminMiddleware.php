<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class adminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (null !== Auth::user()) {
            if (Auth::user()->role == "admin") {
                return $next($request);
            }else if(Auth::user()->role =="member"){
                return redirect('/member/dashboard');
            }
            return abort(500);
        } else {
            return redirect('/login');
        }
    }
}
