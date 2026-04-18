<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\AdminResetPasswordMail;


class AuthController extends Controller
{
    //
    public function showLogin()
    {
        return view("admin.auth.login");
    }

    public function showAccountantLogin()
    {
        return view("accountant.auth.login");
    }
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {

            $user = Auth::user();
            $roleName = $user->role ? $user->role->name : null;

            if (!in_array($roleName, ['admin', 'accountant', 'counselor'])) {
                Auth::logout();
                return back()->withErrors(['email' => 'Insufficient permissions for staff portal.']);
            }

            $user->update([
                'last_login_at' => now()
            ]);

            // Redirect based on role
            if ($roleName === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($roleName === 'accountant') {
                return redirect()->route('accountant.dashboard');
            } elseif ($roleName === 'counselor') {
                // To be implemented or handled
                return redirect()->route('admin.dashboard')->with('info', 'Counselor module to be finalized.');
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function signup(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required",
            "password" => "required",
        ]);
        $adminRoleId = Role::where("name", "admin")->value('id');
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $adminRoleId,
            'is_active' => 1,
            'signup_approved' => 1,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('admin.login')->with('success', 'Admin account created.Please Login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    // Password Reset
    public function showForgotPasswordForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Check if admin
        $user = User::where('email', $request->email)->first();
        if (!$user || !$user->role || $user->role->name !== 'admin') {
            return back()->withErrors(['email' => 'Admin account not found.']);
        }

        $token = Str::random(60);

        // In a real app use Password::broker()->createToken($user)
        Mail::to($user->email)->send(new AdminResetPasswordMail($token, $user->email));

        return back()->with('success', 'Admin password reset link sent to your email.');
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        return view('admin.auth.reset-password', ['token' => $token, 'email' => $request->email]);
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

        return redirect()->route('admin.login')->with('success', 'Password updated successfully. Please login.');
    }
}
