<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm(): View //returns a view of the login form
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse //processes the submission of the login form and authorizes the user
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($data)) {
            return redirect()->intended(route('profile'));
        }
        return back()->withErrors(['email' => 'не верные учетные данные']);
    }

    public function logout(): RedirectResponse //ends user's authentication and redirect to the login page
    {
        auth()->logout();

        return redirect()->route('login');
    }

    public function showRegisterForm(): View //returns a view of the register form
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse //creates a new user account in the system and redirects to the login page
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $data['password'] = Hash::make($data['password']);
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);
        return redirect()->route('login')->with('status', 'success');
    }

    public function profile(): View //returns a view of the profile form
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    public function updateProfile(Request $request): RedirectResponse //handles updating user data (name and email)
    {
        $data = $request->validate([
            'name' => 'string',
            'email' => 'string|email|unique:users,email,' . Auth::id(),
        ]);
        $user = Auth::user();
        $user->update($data);
        return redirect()->route('profile');
    }

    public function showChangePasswordForm(): View //returns a view of the change-password
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request): RedirectResponse //allows the user to securely change password
    {
        $data = $request->validate([
            'current_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        $user = Auth::user();
        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'the current password is incorrect!']);
        }
        $user->password = Hash::make($data['new_password']);
        $user->save();
        return redirect()->route('profile')->with('status', 'Your password has been changed!');
    }
}
