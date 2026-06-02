<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if (auth()->check() && strtolower(auth()->user()->role) === 'admin') {
            return $next($request);
        }

        
        return redirect()->route('dashboard')->with('toast_error', 'You do not have administrator access to that page.');
    }
}