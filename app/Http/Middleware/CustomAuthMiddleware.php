<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CustomAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // if (!Auth::check()) {
        //     // If it's an AJAX request, return JSON response
        //     // abort(403, 'Unauthorized access');

        //     // Redirect to home or a custom page instead of auth.login
        //     return redirect()->route('home'); // Change this if needed
        // }

        return $next($request);
    }
}
