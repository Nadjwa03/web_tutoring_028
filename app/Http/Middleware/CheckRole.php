<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $roles = empty($roles) ? [null] : $roles;

        if (Auth::check()) {
            if (collect($roles)->contains(Auth::user()->role)) {
                return $next($request);
            }
        }
        return abort(404);
    }
}
