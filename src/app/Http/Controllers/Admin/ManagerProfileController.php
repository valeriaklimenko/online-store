<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class ManagerProfileController extends Controller
{
    /**
     * Returns a view of the manager profile form.
     */
    public function managerProfile(): View
    {
        return view('layouts.managerProfile.profile', ['user' => Auth::user()]);
    }
}
