<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Illuminate\Http\Response;

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
            // Get the response from the next middleware/route
            $response = $next($request);

            // Ensure the response can accept headers by casting it if needed
            if ($response instanceof SymfonyResponse) {
                $response = new Response($response->getContent(), $response->getStatusCode(), $response->headers->all());
            }
            
            // Add no-cache headers
            $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0')
                     ->header('Pragma', 'no-cache')
                     ->header('Expires', '0');
            
            return $response;
        }

        // Redirect or return an error response if user is not authorized
        return redirect('/error401')->with('error', 'You do not have access to this page.');
    }

}
