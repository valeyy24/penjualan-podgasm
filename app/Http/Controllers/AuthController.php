<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // Wajib ada password_confirmation di form
        ]);

        try {
            // 2. Simpan ke Database
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'customer', // Default role untuk pembeli B2C
            ]);

            // 3. Otomatis Login setelah daftar
            Auth::login($user);

            // 4. Redirect ke halaman utama atau dashboard
            return redirect('/')->with('success', 'Selamat datang di Podgasm! Akun berhasil dibuat.');

        } catch (\Exception $e) {
            // Jika gagal, munculkan errornya di layar (Sangat membantu saat coding)
            return back()->withErrors(['msg' => 'Gagal mendaftar: ' . $e->getMessage()]);
        }
    }

    public function showLogin()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Jika admin ke dashboard, jika customer ke home
            if (Auth::user()->role == 'admin') {
                return redirect()->intended('admin/dashboard');
            }
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}