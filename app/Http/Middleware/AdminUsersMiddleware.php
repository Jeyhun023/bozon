<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpseclib\Crypt\Hash;

class AdminUsersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
//        dd(Auth::guard('seller')->check(), Auth::guard('admin_user')->check());
//        dd(bcrypt("1"));
        if (Auth::guard('admin_user')->check() || Auth::guard('seller')->check()) {
//            dd("A");
            return $next($request);
        } else {
            return redirect()->route('admin.login');
        }
    }
}
