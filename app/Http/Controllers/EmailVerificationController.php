<?php

namespace App\Http\Controllers;

use App\Notifications\VerifyEmailWithCode;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    /**
     * Show the email verification form
     */
    public function show()
    {
        return view('auth.verify-email');
    }

    /**
     * Verify the email with code
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $user = $request->user();

        // Check if user already verified
        if ($user->email_verified_at) {
            return redirect('/dashboard')->with('message', 'Your email is already verified!');
        }

        // Verify the code
        if ($user->verifyCode($request->code)) {
            // Clear the code and mark email as verified
            $user->clearVerificationCode();
            
            return redirect('/dashboard')->with('message', 'Email verified successfully!');
        }

        return back()->withErrors(['code' => 'Invalid or expired verification code.']);
    }

    /**
     * Resend verification code
     */
    public function resend(Request $request)
    {
        $user = $request->user();

        // Generate and send new verification code
        $code = $user->generateVerificationCode();
        $user->notify(new VerifyEmailWithCode($code));

        return back()->with('message', 'A new verification code has been sent to your email!');
    }
}
