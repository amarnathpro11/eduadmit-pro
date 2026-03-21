<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentResetPasswordMail;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('student.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('student')->attempt($credentials)) {
            $user = Auth::guard('student')->user();

            if (!$user->is_active) {
                Auth::guard('student')->logout();
                return back()->with('error', 'Your account is inactive. Please contact admin for approval.');
            }

            if ($user->role && $user->role->name === 'student') {
                $user->update([
                    'last_login_at' => now()
                ]);
                $request->session()->regenerate();
                return redirect()->intended(route('student.dashboard'));
            }
            Auth::guard('student')->logout();
            return back()->withErrors(['email' => 'Not a student account']);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function registerForm()
    {
        return view('student.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $studentRole = Role::where('name', 'student')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $studentRole ? $studentRole->id : null,
            'is_active' => true,
            'last_login_at' => now()
        ]);

        Auth::guard('student')->login($user);

        return redirect()->route('student.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('student.login');
    }

    // Forgot Password
    public function showForgotPasswordForm()
    {
        // For students, reuse login style or create new
        return view('student.auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user || !$user->role || $user->role->name !== 'student') {
            return back()->withErrors(['email' => 'Student account not found with this email addresses.']);
        }

        $token = Str::random(60);

        // Normally we'd store this in password_resets table, but for now we'll send it 
        // In a real app use Password::broker()->createToken($user)
        
        Mail::to($user->email)->send(new StudentResetPasswordMail($token, $user->email));

        return back()->with('success', 'Reset instructions sent to your email.');
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        return view('student.auth.reset-password', ['token' => $token, 'email' => $request->email]);
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

        return redirect()->route('student.login')->with('success', 'Password reset successful.');
    }
}
