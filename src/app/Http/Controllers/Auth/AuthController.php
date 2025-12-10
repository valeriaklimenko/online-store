<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\ChangePasswordRequest;
use App\Http\Requests\Account\RegisterRequest;
use App\Http\Requests\Account\StorePostRequest;
use App\Http\Requests\Account\UpdateProfileRequest;
use App\Services\User\AuthService;
use App\Services\User\PasswordService;
use App\Services\User\ProfileService;
use App\Services\User\RegisterService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


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
            return redirect()->intended('/');
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
     * Returns a view of the user profile form.
     */
    public function profile(): View
    {
        return view('layouts.userProfile.profile', ['user' => Auth::user()]);
    }

    /**
     * Returns a view of the admin profile form.
     */
    public function adminProfile(): View
    {
        return view('layouts.adminProfile.profile', ['user' => Auth::user()]);
    }

    /**
     * Returns a view of the manager profile form.
     */
    public function managerProfile(): View
    {
        return view('layouts.managerProfile.profile', ['user' => Auth::user()]);
    }

    /**
     * handles updating user data (name and email).
     *
     */
    public function updateProfile(UpdateProfileRequest $request, ProfileService $profileService): RedirectResponse
    {

        /** @var \App\Models\User $user */

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

        /** @var \App\Models\User $user */

        $user = auth()->user();
        $passwordService->changePassword($user, $request->validated());
        return redirect()->route('profile')->with('status', 'Password successfully changed!');
    }
}
