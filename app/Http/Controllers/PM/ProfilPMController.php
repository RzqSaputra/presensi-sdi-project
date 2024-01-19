<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Presensi;
use App\Models\Jabatan;
use App\Models\User;

class ProfilPMController extends Controller
{
    public function __construct(){
        $this->middleware('pm');
    }

    public function index(Request $request){
        $presensi = Auth::user()->load('karyawan');
        $jabatan = Jabatan::where('id', '>', 1)->get();
        return view('PM.Profil.index')->with([
            'title' => 'Profile Project Manager',
            'presensi' => $presensi,
            'jabatan' => $jabatan,
        ]);
    }

    public function update(Request $request)
    {
        $userId = Auth::id();
        
        User::where('id', $userId)
            ->update([
                'email' => $request->email,
                'jabatan_id' => $request->jabatan_id,
            ]);

        Karyawan::where('user_id', $userId)
            ->update([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'jenkel' => $request->jenkel,
                'tgl_lahir' => $request->tgl_lahir,
                'jabatan_id' => $request->jabatan_id,
                'no_tlp' => $request->no_tlp,
                'alamat' => $request->alamat,
            ]);

        session()->flash('pesan', "Perubahan Data {$request->nama} berhasil");
        return redirect()->route('profilPM');
    }

    public function password(Request $request)
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        session()->flash('pesan', "Perubahan Password berhasil");
        return redirect()->route('profilPM');
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
