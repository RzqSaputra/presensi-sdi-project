<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\User;

class ProfilKaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware('karyawan');
    }

    public function index()
    {
        $presensi = Auth::user()->load('karyawan');
        return view('Karyawan.Profil.index')->with([
            'title' => 'Profil Karyawan',
            'presensi' =>$presensi,
            'presensi' =>$presensi,
        ]);
    }

    public function update(Request $request)
    {
        $userId = Auth::id();
        
        User::where('id', $userId)
            ->update([
                'email' => $request->email,
            ]);

        Karyawan::where('user_id', $userId)
            ->update([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'jenkel' => $request->jenkel,
                'tgl_lahir' => $request->tgl_lahir,
                'no_tlp' => $request->no_tlp,
                'alamat' => $request->alamat,
            ]);

        session()->flash('pesan', "Perubahan Data {$request->nama} berhasil");
        return redirect()->route('profilKaryawan');
    }

    public function password(Request $request)
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        session()->flash('pesan', "Perubahan Password berhasil");
        return redirect()->route('profilKaryawan');
    }

    public function image(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            
            $image = $request->file('image'); // Mengambil file gambar dari form upload
            $imageName = time() . '.' . $image->getClientOriginalExtension();  // Generate nama unik untuk gambar berdasarkan timestamp
            $image->move(public_path('storage/profile'), $imageName);  // Memindahkan file gambar ke folder yang diinginkan

            
            $user_id = Auth::id(); // Mendapatkan ID pengguna yang sedang terautentikasi
            $karyawan = Karyawan::where('user_id', $user_id)->first(); // Mencari data Karyawan yang sesuai dengan user_id terautentikasi

            // Jika data Karyawan ditemukan, perbarui field foto
            if ($karyawan) {
                $karyawan->foto = $imageName;
                $karyawan->save();
            }
        }
        return redirect()->back()->with('pesan', 'Gambar berhasil diunggah.');
    }
}
