<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;




use App\Models\{
    User
};


use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\{
    Auth,
    Hash,
    Session
};





class LoginController extends Controller
{
    public function index()
    {
        return view('admin.auth.login');
    }


    public function postLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        $credentials = $request->only('email', 'password');
        $remember_me = $request->get('remember');


        if(Auth::attempt($credentials,$remember_me))
        {
            $user = Auth::getProvider()->retrieveByCredentials($credentials);

            Auth::login($user, $request->get('remember'));
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')
                ->withSuccess('You have successfully logged in!');
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');


    }

    public function forgotpassword(){
        return view('admin.auth.forgetpassword');
    }



}