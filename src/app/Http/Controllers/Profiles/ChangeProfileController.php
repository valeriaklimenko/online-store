<?php

namespace App\Http\Controllers\Profiles;

use App\Enums\FlashMessage;
use App\Enums\RoleSystem\Roles;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\ChangePasswordRequest;
use App\Http\Requests\Account\UpdateProfileRequest;
use App\Services\User\PasswordService;
use App\Services\User\ProfileService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ChangeProfileController extends Controller
{
    /**
     * Get the appropriate profile route based on user role
     */
    private function getProfileRoute(): string
    {
        $user = Auth::user();

        if ($user->hasRole(Roles::ADMIN->value)) {
            return 'admin.profile';
        }

        if ($user->hasRole(Roles::MANAGER->value)) {
            return 'manager.profile';
        }

        return 'profile';
    }

    /**
     * handles updating user data (name and email).
     */
    public function updateProfile(UpdateProfileRequest $request, ProfileService $profileService): RedirectResponse
    {

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $data = $request->validated();

        $emailChanged = isset($data['email']) && $data['email'] !== $user->email;

        $profileService->update($user, $data);

        $profileRoute = $this->getProfileRoute();

        if ($emailChanged) {
            return redirect()->route($profileRoute)
                ->with('email_change_pending', true)
                ->with(FlashMessage::EMAIL_CHANGE_PENDING->value);
        }

        return redirect()->route($profileRoute)->with('success', FlashMessage::ACCOUNT_UPDATED->value);
    }

    /**
     * Email address change verification
     */
    public function verifyEmailChange(int $id, string $token, ProfileService $profileService): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user || $user->getKey() !== $id)

        try {
            $profileService->verifyEmailChange($user, $token);

            return redirect()->route($this->getProfileRoute())
                ->with('success', FlashMessage::EMAIL_CHANGED->value);
        } catch (\Exception) {}

            return redirect()->route($this->getProfileRoute())
                ->with('error', FlashMessage::PROFILE_ERROR->value );
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
     * @throws \Exception
     */
    public function changePassword(ChangePasswordRequest $request, PasswordService $passwordService): RedirectResponse
    {

        /** @var \App\Models\User $user */

        $user = auth()->user();
        $passwordService->changePassword($user, $request->validated());
        $profileRoute = $this->getProfileRoute();
        return redirect()->route($profileRoute)->with('success', FlashMessage::PASSWORD_UPDATED->value);
    }
}
