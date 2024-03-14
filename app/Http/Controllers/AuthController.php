<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
class AuthController extends Controller
{

    public function index()
    {
        return view('auth.index')->with([
            'title' => 'Login'
        ]);
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

    public function forget()
    {
         return view('auth.forget')->with([
            'title' => 'Ubah Password'
        ]); 
    }

    public function forgetpassword(Request $request)
    {
        // Setup data untuk dikirim
    $data = [
        'target' => '085348558783',
        'message' => 'test message',
        'countryCode' => '62', // optional
    ];

    // Setup header dengan Authorization token
    $headers = [
        'Authorization' => 'UKy6jvzGsMwAJ1PdbdpD', // Ganti YOUR_TOKEN dengan token yang valid
    ];

    // Kirim permintaan ke API menggunakan HTTP client Laravel
    $response = Http::post('https://api.fonnte.com/send', $data, $headers);

    // Tampilkan hasil respons dari API
    return $response->body();
    }

    



       public function reset(Request $request)
    {
        // Ambil email dari URL
        $email = $request->query('email');

        // Validasi apakah email ada di dalam URL
        if (!$email) {
            return redirect()->route('auth.login')->with('error', 'Invalid reset link.');
        }

        return view('auth.resetpassword')->with([
            'title' => 'Reset Password',
            'email' => $email, // Mengirim email ke blade
        ]);
    }

    public function test()
    {
        $userList = User::all();

        // Menggunakan helper response untuk mengembalikan data dalam format JSON
        return response()->json($userList);
    }

       public function resetpassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:1|confirmed',
        ]);

        // Ambil data dari input
        $email = $request->input('email');
        $password = $request->input('password');

        // Cari pengguna berdasarkan email
        $user = User::where('email', $email)->first();

        // Validasi apakah pengguna ditemukan
        if (!$user) {
            return redirect()->route('auth.login')->with('error', 'Invalid reset link.');
        }

        // Update password pengguna
        $user->password = Hash::make($password);
        $user->save();

        // Redirect atau lakukan tindakan lain setelah reset password
        return redirect()->route('auth.login')->with('success', 'Password has been reset successfully.');
    }
}
