<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewUser
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
        if (Auth::check()) {
            $user = Auth::user();
            
            // Define the routes that users with default password or unverified email are allowed to access
            $allowedRoutes = [
                'password.change', // Route name for changing password
                'change.password', // Assuming this is the route name for the POST request to change the password
                'change.email',    // Route name for changing email
                'email.change',    // Ensure this matches the POST route for changing email
                'enter.code.email', // Add any other routes that are part of the email verification or update process
                'resend.verification.code',
                'email.verify.code',
                'email.verify.url',
               
                // Add any other routes necessary for the password change or email verification process
            ];
        
            // Check if the current route is in the list of allowed routes
            $currentRoute = $request->route()->getName();
            
            // Redirect based on user status
            if ($user->default_password && !in_array($currentRoute, $allowedRoutes)) {
                // If the user has a default password and is trying to access a route not in the allowed list
                return redirect()->route('password.change');
            } elseif (!$user->email_verified && !in_array($currentRoute, $allowedRoutes)) {
                // If the user's email is not verified and is trying to access a route not in the allowed list
                return redirect()->route('change.email');
            }
        }
    
        // If the user is not authenticated, or if none of the conditions apply, proceed with the request
        return $next($request);
    }
}
