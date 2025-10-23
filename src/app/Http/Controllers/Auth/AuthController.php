<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\User\RegisterService;
use App\Services\User\AuthService;
use App\Services\User\PasswordService;
use App\Services\User\ProfileService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{

    /**
     * Returns a view of the login form.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Processes the submission of the login form and authorizes the user.
     */
    public function login(StorePostRequest $request, AuthService $authService): RedirectResponse
    {
        if ($authService->login($request->validated())) {
            return redirect()->intended(route('profile'));
        }
        return redirect()->back()->withErrors(['email' => 'Credentials are not correct']);
    }

    /**
     * Ends user's authentication and redirect to the login page.
     */
    public function logout(AuthService $authService): RedirectResponse
    {
       $authService->logout();
        return redirect()->route('login');
    }

    /**
     * Returns a view of the register form.
     */
    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    /**
     * Creates a new user account in the system and redirects to the login page.
     */
    public function register(RegisterRequest $request, RegisterService $registerService): RedirectResponse
    {
        $registerService->register($request->validated());

        return redirect()->route('login')->with('status', 'success');
    }

    /**
     * returns a view of the profile form.
     */
    public function profile(): View
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    /**
     * handles updating user data (name and email).
     */
    public function updateProfile(UpdateProfileRequest $request, ProfileService $profileService): RedirectResponse
    {
        $user = Auth::user();
        $profileService->update($user, $request->validated());
        return redirect()->route('profile');
    }

    /**
     * returns a view of the change-password.
     */
    public function showChangePasswordForm(): View
    {
        return view('auth.change-password');
    }

    /**
     * allows the user to securely change password.
     */
    public function changePassword(ChangePasswordRequest $request, PasswordService $passwordService): RedirectResponse
    {
        $user = auth()->user();
       $passwordService->changePassword($user, $request->validated());
        return redirect()->route('profile')->with('status', 'Password successfully changed!');
    }
}
