<?php

namespace App\Http\Middleware;

use Closure;

class SpecialRole
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
        if(!auth()->user()->employee->inSpecialRole() || auth()->user()->employee->isPimpinan())
            return redirect('/login');

        return $next($request);
    }
}
