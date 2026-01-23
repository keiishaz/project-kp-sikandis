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
            'nip' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $attempted = Auth::attempt([
            'nip' => $validated['nip'],
            'password' => $validated['password']
        ]);

        if (!$attempted) {
            return back()->withErrors([
                'nip' => 'NIP atau password salah.',
            ])->onlyInput('nip');
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
