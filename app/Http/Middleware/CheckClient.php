<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckClient
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
        if (!Auth::check() || !session('is_birthdate_verified') || Auth::user()->role_id != 2) {
            return redirect()->route('login');
        }
        if (Auth::user()->auth_client->account_status == 'Non-Active') {
            return redirect()->route('login')->with('message', 'This account has been disabled by the admin. For assistance, please contact support.');
        }
        return $next($request);
    }
}
