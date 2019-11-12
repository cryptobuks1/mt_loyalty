<?php

namespace App\Http\Middleware;

use Closure;

class CheckDoctor
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
        if (Auth::user()->user_role == config('baseapp.user_role.doctor')) {
            return $next($request);
        }
        
        abort(404);
    }
}
