<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register() {
        return view('register');
    }

    public function registrasi(Request $request) {

        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ])->validate();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('login')->with('success', 'registrasi berhasil dilakukan');
    }

    public function login() {
        return view('login');
    }

    // menggunakan middleware untuk membatasi hak akses
    public function masuk(Request $request) {
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ])->validate();

        if (Auth::attempt($request->only('email', 'password'))) {
            // Jika berhasil login
            if (Auth::User()->role == 'admin') {
                return redirect()->intended('admin');
            } else if (Auth::User()->role =='user') {
                return redirect()->intended('dashboard');
            } else {
                return redirect('login')->with('error', 'maaf mungkin email salah atau anda belum mendaftar, silahkan coba lagi');
            }
        } else{
            return redirect()->back->with('error', 'maaf mungkin email salah atau anda belum mendaftar, silahkan coba lagi');
        }

        return redirect()->route('login');
    }
     // end menggunakan middleware untuk membatasi hak akses

    public function logout() {
        Auth::logout();

        return redirect()->route('login');
    }
}
