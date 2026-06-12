<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    /**
     * Returns a view of the admin profile form.
     */
    public function adminProfile(): View
    {
        return view('layouts.adminProfile.profile', ['user' => Auth::user()]);
    }
}
