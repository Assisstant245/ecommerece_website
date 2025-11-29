<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFrontendUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->name === 'webuser') {
            return $next($request);
        }
        Auth::logout();
        return redirect('/login')->with('error', 'Access denied.');

        // if ($request->ajax() || $request->wantsJson()) {
        //     return response()->json(['message' => 'Please login first.'], 401);
        // }
        // return redirect('/login')->with('error', 'Please login first.');
    }
}
