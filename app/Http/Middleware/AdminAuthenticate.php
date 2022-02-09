<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $login = 1)
    {
        if($login) {
            if (!Auth::guard('backend')->check()) {
                return Redirect::action('\App\Http\Controllers\Backend\Auth\LoginController@login');
            }
        } else {
            if (Auth::guard('backend')->check()) {
                return Redirect::to(action('\App\Http\Controllers\Backend\AdminController@index'));
            }
        }

        return $next($request);
    }
}
