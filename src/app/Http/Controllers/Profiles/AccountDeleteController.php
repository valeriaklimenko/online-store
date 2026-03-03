<?php

namespace App\Http\Controllers\Profiles;

use App\Enums\FlashMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\DeleteAccountRequest;
use App\Services\User\AccountDeleteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AccountDeleteController extends Controller
{
    /**
     * Delete user account
     */
    public function destroy(DeleteAccountRequest $request, AccountDeleteService $deleteService): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        try {
            $deleteService->deleteAccount($user);

            return redirect()->route('home')
                ->with('status', FlashMessage::DELETE_ACCOUNT_SUCCESSFUL->value);
        } catch (\Exception $e) {
            return redirect()->route('profile')
                ->with('error', FlashMessage::DELETE_ACCOUNT_FAILED->value);
        }
    }
}
