<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.index')->with([
            'title' => 'Login'
        ]);
    }
    public function create()
    {
        return view('auth.daftar')->with([
            'title' => 'Daftar'
        ]);
    }
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama'      => 'required|min:3|max:50',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'nip' => 'required|numeric|unique:App\Models\Pegawai,nip'
        ]);
        User::create([
            'nama' => $validateData['nama'],
            'role' => 'Pegawai',
            'email' => $validateData['email'],
            'password' => Hash::make($validateData['password'])
        ]);
        Pegawai::create([
            'user_id' => User::latest()->first()->id,
            'nip' => trim($request->nip),
        ]);

        $request->session()->flash('success', "Sign Up Success! Please Login");
        return redirect()->route('auth.login');
    }

    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('Dashboard'))->with('success', 'Selamat datang kembali ' . Auth::user()->nama);
        }
        return back()->with('error', 'Email atau Password Salah')->onlyInput('email');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect(route('auth.index'));
    }
}
