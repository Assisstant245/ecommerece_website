<?php
namespace App\Http\Middleware;
use Illuminate\Support\Facades\Session;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserLogin
{
    /**
     * Handle  an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->name === 'adminuser') {
        return $next($request);
    }
    Auth::logout();
    return redirect('admin/login')->with('error', 'Access denied.');
        
    //     if ($request->ajax() || $request->wantsJson()) {
    //     return response()->json(['message' => 'Please login first.'], 401);
    // }
        
    
    //         return redirect('admin/login')->with('error', 'Please login first.');

    }
}
