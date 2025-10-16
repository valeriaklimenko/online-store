<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
    $data=$request->validate([
        'email'=>'required|email',
        'password'=>'required',
    ]);
   if (Auth::attempt($data)) {
       return redirect()->intended(route('profile'));
   }
   return back()->withErrors(['email'=>'не верные учетные данные']);
    }
    public function logout() {
        auth()->logout();
        return redirect()->route('login');
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function register(Request $request) {
        $data=$request->validate([
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|string|min:8|confirmed'     //добавить доп настройки безопасности?
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['password'] = Hash::make($data['password']);
        User::create($data);
//        User::create([
//            'name'=>$data['name'],
//            'email'=>$data['email'],
//            'password'=>$data['password']
//        ]);
return redirect()->route('login')->withErrrors(['status','success']);
    }
    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }
    public function updateProfile(Request $request) {
        $data=$request->validate([
            'name'=>'string',
            'email'=>'string|email|unique:users,email' .Auth::id(),
        ]);
        $user=Auth::user();
        $user->update($data);
        return redirect()->route('profile');
    }

}

