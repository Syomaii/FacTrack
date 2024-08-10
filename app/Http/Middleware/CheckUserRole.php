<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$types)
    {
        if (Auth::check() && in_array(Auth::user()->type, $types)) {
            return $next($request);
        }

        // Redirect or return an error response if user is not authorized
        return redirect('/error401')->with('error', 'You do not have access to this page.');
    }

}
