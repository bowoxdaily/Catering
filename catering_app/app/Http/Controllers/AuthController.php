<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();

            // Cek peran (role) dari user
            if ($user->role == 'admin') {
                return response()->json([
                    'message' => 'Login berhasil',
                    'redirect_url' => route('admin'),
                    'user' => $user
                ], 200);
            } elseif ($user->role == 'user') {
                return response()->json([
                    'message' => 'Login berhasil',
                    'redirect_url' => route('user'),
                    'user' => $user
                ], 200);
            }
        }

        return response()->json([
            'message' => 'Email atau Password Salah!',
        ], 401);
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
        'role' => 'admin'
    ]);

    // Return response JSON
    return response()->json([
        'message' => 'Registrasi berhasil',
        'user' => $user,
        'redirect_url' => route('login'),
    ], 201);
}


    

}
