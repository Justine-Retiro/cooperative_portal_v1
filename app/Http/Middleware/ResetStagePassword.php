<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ResetStagePassword
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
        if ($request->is('forgot-password/reset') && !session()->has('verified_code') && !session()->has('resetting_password')) {
            // Redirect them to enter the verification code if they haven't verified yet
            return redirect()->route('forgot.password.code')->withErrors(['message' => 'Please verify your code first.']);
        }

        // If the user is trying to access the verification URL directly, let them through
        // This assumes your verify method sets a session variable upon successful verification
        if ($request->is('reset-password/verify-code/*')) {
            // This route should handle the verification and set the necessary session variables
            return $next($request);
        }

    
        return $next($request);
    }
}
