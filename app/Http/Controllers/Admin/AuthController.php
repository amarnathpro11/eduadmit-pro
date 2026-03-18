<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{
    //
    public function showLogin()
    {
        return view("admin.auth.login");
    }
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {

            $user = Auth::user();

            if (!$user->role || $user->role->name !== 'admin') {
                Auth::logout();
                return back()->withErrors(['email' => 'Not an admin account']);
            }

            $user->update([
                'last_login_at' => now()
            ]);

            return redirect()->route('admin.dashboard');
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
        return redirect()->route('admin.login');
    }
}
