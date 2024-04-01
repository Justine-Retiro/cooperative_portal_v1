<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('auth.forgot_password');
    }

    public function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => "We can't find a user with that email address."]);
        }

        // Generate and save the code
        $user->code = rand(100000, 999999);
        $user->save();

        session([
            'resetting_password' => true,
            'resetting_email' => $request->email 
        ]);

        // Send the code via email
        Mail::to($user->email)->send(new ForgotPasswordEmail($user));

        return redirect()->route('forgot.password.code')->with('message', 'Verification code sent to your email.');
    }

    public function enterCode()
    {
        return view('auth.forgot_password_code');
    }

    public function verifyCode(Request $request)
    {
        $request->validate(['code' => 'required']);
        $user = User::where('code', $request->code)->first();

        if (!$user) {
            return back()->withErrors(['code' => 'Invalid verification code.']);
        }

        // Code verified, proceed to password reset
        Auth::login($user);
        return redirect()->route('forgot.password.reset');
    }

    public function resendCode(Request $request)
    {
        try {
            if (!session()->has('resetting_password')) {
                return back()->withErrors(['message' => 'Please start the password reset process.']);
            }

            $user = User::where('email', session('resetting_email'))->first();

            if (!$user) {
                return back()->withErrors(['email' => "We can't find a user with that email address."]);
            }

            // Generate and save the new code
            $user->code = rand(100000, 999999);
            $user->save();

            // Send the new code via email
            Mail::to($user->email)->send(new ForgotPasswordEmail($user));

            return response()->json(['message' => 'A new verification code has been sent to your email.']);
        } catch (\Exception $e) {
            \Log::error('Failed to resend verification code: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while resending the verification code. Please try again.']);
        }
    }


    public function showResetForm()
    {
        return view('auth.forgot_password_changepass');
    }

    public function resetPassword(Request $request)
    {
        Log::info('Reset Password method called.');
    
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);
    
        $user = Auth::user();
        if (!$user) {
            Log::error('No authenticated user found.');
            return back()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
        }
    
        $user->password = Hash::make($request->password);
        $user->code = null; 
        $user->save();
    
        Auth::logout();
        return redirect()->route('login')->with('message', 'Your password has been changed successfully.');
    }

    public function verify($code)
    {
        $user = User::where('code', $code)->first();

        if (!$user) {
            return redirect()->route('forgot.password')->withErrors(['code' => 'Invalid or expired code.']);
        }

        // Set a session variable to indicate the user has verified their code
        session(['verified_code' => true]);

        // Optionally, log the user in and redirect to the reset password form
        Auth::login($user);
        return redirect()->route('forgot.password.reset');
    }
}