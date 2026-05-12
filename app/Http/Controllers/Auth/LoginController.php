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
        return view('auth.login', ['loginMode' => 'default']);
    }

    public function showSuperAdminLoginForm()
    {
        return view('auth.login', ['loginMode' => 'super_admin']);
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
            if ($user->isSuperAdmin()) {
                return redirect()->route('super-admin.login')
                    ->with('error', 'Please use the dedicated super admin login.');
            }

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
            
            return $this->completeLogin($request, $user);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function superAdminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !$user->isSuperAdmin() || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'The provided super admin credentials do not match our records.',
            ])->onlyInput('email');
        }

        if (!$user->email_verified_at) {
            $code = $user->generateVerificationCode();
            $user->notify(new VerifyEmailWithCode($code));

            return redirect()->back()->with([
                'require_verification' => true,
                'user_email' => $user->email,
            ]);
        }

        return $this->completeLogin($request, $user);
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
            
            return $this->completeLogin($request, $user);
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
        $redirectRoute = Auth::user()?->isSuperAdmin() ? 'super-admin.login' : 'login';

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route($redirectRoute);
    }

    private function completeLogin(Request $request, User $user)
    {
        Auth::login($user, $request->filled('remember'));
        $request->session()->regenerate();

        if ($user->isSuperAdmin()) {
            return redirect()->route('super-admin.dashboard');
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard.index');
    }
}
