<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\VerifyEmailWithCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Find the user first
        $user = User::where('email', $credentials['email'])->first();

        // Check if user exists and password is correct
        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Check if email is verified
            if (!$user->email_verified_at) {
                // Generate and send verification code
                $code = $user->generateVerificationCode();
                $user->notify(new VerifyEmailWithCode($code));
                
                // Redirect back to login with verification form
                return redirect()->back()->with([
                    'require_verification' => true,
                    'user_email' => $user->email,
                ]);
            }
            
            // Email is verified, proceed with login
            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();
            
            if ($user->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            }
            
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Verify the code and complete login
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'verification_code' => ['required', 'string', 'size:6'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found.'])->withInput();
        }

        // Verify the code
        if ($user->verifyCode($request->verification_code)) {
            // Clear the code and mark email as verified
            $user->clearVerificationCode();
            
            // Login the user
            Auth::login($user);
            $request->session()->regenerate();
            
            if ($user->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            }
            
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'verification_code' => 'Invalid or expired verification code.',
        ])->with(['require_verification' => true, 'user_email' => $request->email]);
    }

    /**
     * Resend verification code during login
     */
    public function resendCode(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Generate and send new verification code
            $code = $user->generateVerificationCode();
            $user->notify(new VerifyEmailWithCode($code));
        }

        return back()->with([
            'require_verification' => true,
            'user_email' => $request->email,
            'message' => 'A new verification code has been sent to your email!',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
