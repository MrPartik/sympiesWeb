<?php

namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Support\Facades\Auth;

class memberMiddleware
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
            if (Auth::user()->role == "member") {
                return $next($request);
            }else if(Auth::user()->role =="admin"){
                return redirect('admin/dashboard');
            }
            return abort(500);
        } else {
            return redirect('/login');
        }
    }
}
