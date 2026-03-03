<?php

namespace App\Http\Controllers\Register;

use App\Enums\FlashMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\RegisterRequest;
use App\Services\User\RegisterService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    /**
     * Returns a view of the register form.
     */
    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    /**
     * Creates a new user account in the system and redirects to email verification page.
     */
    public function register(RegisterRequest $request, RegisterService $registerService): RedirectResponse
    {
        $user = $registerService->register($request->validated());
        event(new Registered($user));
        auth()->login($user);

        return redirect()->route('verification.notice')
            ->with('status', FlashMessage::LINK_SENT->value);
    }
}
