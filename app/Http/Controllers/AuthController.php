<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $log = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if (Auth::attempt($log)) {
            $request->session()->regenerate();
    
            $user = Auth::user();
    
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard'); // atau redirect('/admin-page/dashboard')
            } elseif ($user->role === 'petugas') {
                return redirect()->route('petugas.dashboard'); // atau redirect('/petugas-page/dashboard')
            } else {
                Auth::logout(); // untuk keamanan
                return redirect('/login')->withErrors(['email' => 'Role tidak valid.']);
            }
        }
    
        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function logout(Request $request)
    {
        Auth::logout();  // Log the user out
        $request->session()->invalidate();  // Invalidate the session
        // $request->session()->regenerateToken();  // Regenerate the CSRF token
    
        return redirect()->route('login')->with('logout', "Anda telah berhasil logout.");
    }
    
    
}
