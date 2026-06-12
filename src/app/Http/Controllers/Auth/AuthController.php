<?php

namespace App\Http\Controllers\Auth;

use App\Enums\FlashMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\StorePostRequest;
use App\Services\User\AuthService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return redirect()
            ->back()
            ->withErrors(['email' => FlashMessage::LOGIN_FAILED->value]);
    }

    /**
     * Ends user's authentication and redirect to the login page.
     */
    public function logout(Request $request, AuthService $authService): RedirectResponse
    {
        $authService->logout();
        $request->session()->invalidate();

        return redirect()
            ->route('loginForm')
            ->with('status', FlashMessage::LOGOUT_SUCCESSFUL->value);
    }
}
