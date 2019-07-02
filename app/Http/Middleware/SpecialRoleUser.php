<?php

namespace App\Http\Middleware;

use Closure;

class SpecialRoleUser
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
        if((!auth()->user()->employee->inSpecialRoleUser() || auth()->user()->employee->isPimpinan()) && !auth()->user()->employee->kepala_group_special_role())
            return redirect('/login');

        return $next($request);
    }
}
