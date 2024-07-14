<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{
    function login()
    {
        return view('pages.user.login');
    }

    public function loginConfirm(Request $req){
        $check = User::where('email', $req->email)->first();

        if ($check && Hash::check($req->password, $check->password)) {
            session()->put('userId', $check->id);
            session()->put('user', $check->name);
            session()->put('role', $check->role);
            return redirect()->route('home');
        }
        return redirect()->route('login')->with('err', 'These credentials do not match our records');
    }

    // Admin Login
    function adminlogin()
    {
        return view('pages.admin.login');
    }

    public function adminloginConfirm(Request $req){
        $credentials = $req->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();
            session()->put('adminId', $admin->id);
            session()->put('admin', $admin->name);
            session()->put('adminEmail', $admin->email);
            return redirect()->route('adminDash');
        }
        return redirect()->route('admin')->with('err2', 'These credentials do not match our records');
    }

    public function logout(){
        session()->flush();
        return redirect()->route('home');
    }

    public function Alogout(){
        Auth::guard('admin')->logout();
        session()->flush();
        return redirect()->route('admin');
    }
}