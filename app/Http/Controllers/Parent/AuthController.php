<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('parent.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('parent')->attempt($credentials)) {
            $user = Auth::guard('parent')->user();

            if (!$user->is_active) {
                Auth::guard('parent')->logout();
                return back()->with('error', 'Your account is inactive.');
            }

            if ($user->role && $user->role->name === 'parent') {
                $request->session()->regenerate();
                return redirect()->intended(route('parent.dashboard'));
            }
            
            Auth::guard('parent')->logout();
            return back()->withErrors(['email' => 'Not a parent account']);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function registerForm()
    {
        return view('parent.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'student_email' => 'required|email|exists:users,email',
            'student_password' => 'required|string',
        ]);

        $parentRole = \App\Models\Role::where('name', 'parent')->first();
        $studentRole = \App\Models\Role::where('name', 'student')->first();

        $student = User::where('email', $request->student_email)
            ->where('role_id', $studentRole->id)
            ->first();

        if (!$student || !\Illuminate\Support\Facades\Hash::check($request->student_password, $student->password)) {
            return back()->withErrors(['student_email' => 'Invalid student email or password.'])->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $parentRole ? $parentRole->id : null,
            'is_active' => true,
        ]);

        \Illuminate\Support\Facades\DB::table('parent_student')->insert([
            'parent_id' => $user->id,
            'student_id' => $student->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Auth::guard('parent')->login($user);

        return redirect()->route('parent.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('parent')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('parent.login');
    }
}
