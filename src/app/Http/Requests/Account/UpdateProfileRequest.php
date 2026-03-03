<?php

namespace App\Http\Requests\Account;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */

    public function rules():array
    {
        $userId = Auth::id();
        return [
            'name' => 'nullable|string',
            'email' => 'nullable|string|email|unique:users,email,'. $userId . '|unique:users,new_email,' . $userId,
        ];

    }
}
