<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * Returns a view of the user profile form.
     */
    public function profile(): View
    {
        return view('layouts.userProfile.profile', ['user' => Auth::user()]);
    }
}
