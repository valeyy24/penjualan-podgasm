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
        // 1. Validasi Input (Tambahkan role ke validasi)
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:customer,branch', // Pastikan input cuma boleh customer atau branch
        ]);

        try {
            // 2. Simpan ke Database
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => $request->role, // MENGAMBIL NILAI DARI RADIO BUTTON
            ]);

            // 3. Otomatis Login
            Auth::login($user);

            // 4. Redirect sesuai Role
            if ($user->role == 'branch') {
                return redirect('/branch/dashboard')->with('success', 'Selamat bergabung sebagai Partner Cabang!');
            }

            return redirect('/')->with('success', 'Selamat datang di Podgasm!');

        } catch (\Exception $e) {
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

            $user = Auth::user(); // Ambil data user yang login

            // 1. Cek kalau dia Admin
            if ($user->role == 'admin') {
                return redirect()->intended('admin/dashboard');
            } 
            
            // 2. Cek kalau dia Branch / Cabang
            if ($user->role == 'branch') {
                return redirect()->intended('branch/dashboard');
            }

            // 3. Sisanya (Customer) dilempar ke Home
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