<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Log::info('Redirecting to login: User not authenticated');
            return redirect()->route('login');
        }
    
        $user = Auth::user();
        if ($user->role_id == null) {
            // Log::info('Redirecting to login: User role not set');
            return redirect()->route('login');
        }
    
        if (!$user->email_verified) {
            // Log::info('Redirecting to login: Email not verified');
            return redirect()->route('login');
        }
    
        if ($user->role_id != 2) {
            // Log::info('Redirecting to login: User role is not 2');
            return redirect()->route('login');
        }
    
        return $next($request);
    }
}
