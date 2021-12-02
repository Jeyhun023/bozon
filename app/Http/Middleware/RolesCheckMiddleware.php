<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolesCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $check = false;
        foreach (explode('|', $role) as $r) {
            if (Auth::guard('admin_user')->check()) {
                if (Auth::guard('admin_user')->user()->hasRole($r)) {
                    $check = true;
                    break;
                }
            }
            if (Auth::guard('seller')->check()) {
                if (Auth::guard('seller')->user()->hasRole($r)) {
                    $check = true;
                    break;
                }
            }
        }
        if ($check) {
            return $next($request);
        }
        abort(404);
    }
}
