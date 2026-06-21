<?php

namespace App\Services\User;

use App\Models\User;
use App\Notifications\VerifyEmailChangeNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ProfileService
{
    /**
     * Saves modified user data to the data base
     */
    public function update(User $user, array $data): User
    {
        if (isset($data['email']) && $data['email'] !== $user->email) {
            $data['new_email'] = $data['email'];
            unset($data['email']);

            $token = Str::random(64);
            $data['email_change_token'] = hash('sha256', $token);
            $data['email_change_requested_at'] = now();

            $user->update($data);

            $user->notify(new VerifyEmailChangeNotification($data['new_email'], $token));

            return $user;
        }

        $user->update($data);
        return $user;
    }

    /**
     * Verify and complete email change
     *
     * @throws \Exception
     */
    public function verifyEmailChange(User $user, string $token): void
    {
        if (!$user->email_change_token) {
            throw new \Exception('No pending email change request found.');
        }

        if ($user->email_change_requested_at &&
            $user->email_change_requested_at->addHours(24)->isPast()) {

            $this->clearEmailChangeRequest($user);
            throw new \Exception('Email change link has expired. Please request again.');
        }

        if (!hash_equals($user->email_change_token, hash('sha256', $token))) {
            throw new \Exception('Invalid verification link.');
        }

        if (!$user->new_email) {
            $this->clearEmailChangeRequest($user);
            throw new \Exception('New email address not found. Please request again.');
        }

        if (User::where('email', $user->new_email)
            ->where('id', '!=', $user->id)
            ->exists()) {

            $this->clearEmailChangeRequest($user);
            throw new \Exception('This email is already taken by another user.');
        }

        $oldEmail = $user->email;
        $newEmail = $user->new_email;

        $user->email = $newEmail;
        $user->new_email = null;
        $user->email_change_token = null;
        $user->email_change_requested_at = null;
        $user->email_verified_at = null;
        $user->save();

        $user->sendEmailVerificationNotification();

    }

    private function clearEmailChangeRequest(User $user): void
    {
        $user->new_email = null;
        $user->email_change_token = null;
        $user->email_change_requested_at = null;
        $user->save();
    }
}
