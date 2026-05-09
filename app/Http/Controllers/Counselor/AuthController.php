<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\CounselorResetPasswordMail;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->role && Auth::user()->role->name === 'counselor') {
            return redirect()->route('counselor.dashboard');
        }
        return view('counselor.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            if ($user->role && $user->role->name === 'counselor') {
                $request->session()->regenerate();
                $user->update(['last_login_at' => now()]);
                return redirect()->intended(route('counselor.dashboard'));
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You do not have Counselor access.',
                ])->onlyInput('email');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('counselor.login');
    }

    // Forgot Password
    public function showForgotPasswordForm()
    {
        return view('counselor.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user || !$user->role || $user->role->name !== 'counselor') {
            return back()->withErrors(['email' => 'Counselor account not found with this email address.']);
        }

        $token = Str::random(60);

        Mail::to($user->email)->send(new CounselorResetPasswordMail($token, $user->email));

        return back()->with('success', 'Reset instructions sent to your email.');
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        return view('counselor.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) return back()->withErrors(['email' => 'User not found.']);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('counselor.login')->with('success', 'Password reset successful.');
    }
}
