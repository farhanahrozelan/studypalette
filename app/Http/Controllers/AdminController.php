<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminController extends Controller
{
    public function showLoginForm() {
        return view('adminLogin'); //path to the login form
    }
    
    public function login(Request $request) {
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $admin = Admin::where('email', $request->email)->first();
        
        if ($admin && Hash::check($request->password, $admin->password)) {
        //Redirect to admin dashboard
        return redirect()->route('adminDashboard');

        }

        //If login fails
        return back()->with('error', 'Invalid email or password.');

    }

}
