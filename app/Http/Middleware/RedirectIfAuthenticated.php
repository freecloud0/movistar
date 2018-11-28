<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        
    //    if(!Auth::guard($guard)->check())
    //    {
    //      // if session is expired
    //       return response()->json(['message' => 'Forbidden!'],403);
    //    }
        if (Auth::guard($guard)->check()) {
            return redirect('/main');
        }
        
        
        
        return $next($request);
    }
}
