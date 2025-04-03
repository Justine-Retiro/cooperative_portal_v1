<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckGuest
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
        if (auth()->check()) {
            if (auth()->user()->role_id == 1) { 
                return redirect()->route('admin.dashboard'); 
            } else if (auth()->user()->role_id == 2) { 
                return redirect()->route('member.dashboard'); 
            }
        }
        return $next($request);
    }
}
