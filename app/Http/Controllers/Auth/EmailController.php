<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index(){
        return view('auth.email_change');
    }

    public function entercode(){
        return view('auth.emailcode_verification');
    }

    public function change(Request $request){
        $user = Auth::user();
    
        $request->validate([
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        ]);
    
        $user->email = $request->email;
        // Generate a simple random verification code and encode it in hexadecimal
        $user->code = strtoupper(substr(dechex(rand(100000, 999999)) . bin2hex(random_bytes(3)), 0, 6));
        
        if (!$user->save()) {
            throw new \Exception('Failed to save user details.');
        }
        // Log::info('Request received', $request->all());
    
        // Attempt to send verification emai;
        try {
            Mail::to($user->email)->send(new VerifyEmail($user));
        } catch (\Exception $e) {
            throw new \Exception('Failed to send verification email.');
        }
    
        return redirect()->route('enter.code.email')->with('success', 'Verification email sent successfully!');
    }

    public function resendVerificationCode()
    {
        try {
            $user = Auth::user();
            $user->code = strtoupper(substr(dechex(rand(100000, 999999)) . bin2hex(random_bytes(3)), 0, 6));
            $user->save();
    
            Mail::to($user->email)->send(new VerifyEmail($user));
    
            return response()->json(['message' => 'Verification code resent successfully.']);
        } catch (\Exception $e) {
            // Log::error('Failed to resend verification code: ' . $e->getMessage());
            return response()->json(['message' => 'Error resending the code. Please try again later.'], 500);
        }
    }

    
    public function verify(Request $request)
    {
        $loggedInUser = Auth::user();
        $inputCode = strtoupper(trim($request->input('code')));
    
        // Attempt to retrieve the user with the given code
        $user = User::where('code', $inputCode)->first();
    
        // Check if user is found and logged in user matches the found user
        if ($user && $loggedInUser && $loggedInUser->id === $user->id) {
            $user->code = null;
            $user->email_verified = true;
            $user->email_verified_at = now();
            $user->save();
            session(['is_birthdate_verified' => true]);
            // Log::info('Redirecting to: ' . $this->redirectPath());
            return redirect()->route('login')->with('success', 'Email verified successfully.');
        } else {
            // Log detailed error if user is not found or does not match
            // Log::error('User with code ' . $inputCode . ' not found or user mismatch. LoggedInUser: ' . ($loggedInUser ? $loggedInUser->id : 'None'));
            return back()->with('error', 'Invalid verification code or user mismatch.');
        }
    }
    public function retrieveLinkBasedCode(Request $request, $code)
    {
        try {
            $user = User::where('code', $code)->first();

            if (!$user) {
                // Log::error('No user found with the provided code.');
                return back()->with('error', 'No user found with the provided code.');
            }

            // if ($user->email_verified) {
            //     Log::info('Email already verified.');
            //     return redirect()->route('dashboard')->with('info', 'Email already verified.'); // Assuming 'dashboard' is a safe landing page
            // }

            $user->email_verified = true;
            $user->code = null; // Clear the verification code
            $user->email_verified_at = now();
            $user->save();

            session(['is_birthdate_verified' => true]);

            // Log::info('Email verified successfully.');
            return redirect()->route('login')->with('success', 'Email verified successfully.'); // Redirect to a dashboard or similar
        } catch (\Exception $e) {
            // Log::error('Error processing email verification: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while verifying the email. Please try again.');
        }
    }
}

