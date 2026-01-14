<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $login = $validated['login'];
        $password = $validated['password'];

        $attempted = false;

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $attempted = Auth::attempt(['email' => $login, 'password' => $password]);
        } else {
            $attempted = Auth::attempt(['name' => $login, 'password' => $password]);
            if (!$attempted) {
                $attempted = Auth::attempt(['email' => $login, 'password' => $password]);
            }
        }

        if (!$attempted) {
            return back()->withErrors([
                'login' => 'Username/email atau password salah.',
            ])->onlyInput('login');
        }

        $request->session()->regenerate();

        $user = $request->user();

        if ($user && $user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user && $user->hasRole('operator')) {
            return redirect()->route('operator.dashboard');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
