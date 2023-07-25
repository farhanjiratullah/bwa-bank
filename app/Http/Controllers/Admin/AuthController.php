<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            return to_route('admin.dashboard');
        }

        return redirect()->back()->with('error', 'Invalid credentials')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        return to_route('admin.login');
    }
}
