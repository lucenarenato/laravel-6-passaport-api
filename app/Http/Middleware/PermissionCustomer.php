<?php

namespace FederalSt\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use FederalSt\User;

class PermissionCustomer
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
        if(Auth::user()->role != User::ROLE_USER) {

            return redirect( '/admin/home');
        }

        return $next($request);
    }
}
