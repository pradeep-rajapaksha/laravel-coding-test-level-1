<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('auth.login');
    }  

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.registration');
    } 

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }
  
        return redirect()->route("login")->with('error', 'invalid credentials!');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function register(Request $request)
    {  
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]); 

        $user = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route("login")->with('success', 'successfully registered, please login!');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        return view('dashboard');
        
        // if(Auth::check()){
            // return view('dashboard');
        // }

        // return redirect()->route("login")->with('error', 'invalid login or session expired!');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        Session::flush();
        Auth::logout();

        return redirect()->route("login");
    }
}
