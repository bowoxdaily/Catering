<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function Login (Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
    
            // Cek peran (role) dari user
            if ($user->role == 'admin') {
                return redirect()->route('admin');
            } elseif ($user->role == 'user') {
                return redirect()->route('user');
            }
        }

        return redirect()->route('login')->with('error', 'Email atau Password Salah ! ');
    
    }

    public function pagelogin(){
        return view('auth.login');
    }

    public function regist(){
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:5',
        
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'user'
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil');
    }

    

}
