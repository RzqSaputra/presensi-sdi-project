<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



use App\Models\Karyawan;

class ProjectManagerController extends Controller
{
    
    public function __construct(){
        $this->middleware('pm');
    }

    // -------------------------------------------- S T A R T  - P R O F I L E----------------------------------------------//



   

    public function updatePassword(Request $request)
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        session()->flash('pesan', "Perubahan Password berhasil");
        return redirect()->route('profile');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Mengambil file gambar dari form upload
            $image = $request->file('image');

            // Generate nama unik untuk gambar berdasarkan timestamp
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Memindahkan file gambar ke folder yang diinginkan
            $image->move(public_path('FotoProfile'), $imageName);

            // Mendapatkan ID pengguna yang sedang terautentikasi
            $user_id = Auth::id();

            // Mencari data Karyawan yang sesuai dengan user_id terautentikasi
            $karyawan = Karyawan::where('user_id', $user_id)->first();

            // Jika data Karyawan ditemukan, perbarui field foto
            if ($karyawan) {
                $karyawan->foto = $imageName;
                $karyawan->save();
            }
        }

        return redirect()->back()->with('pesan', 'Gambar berhasil diunggah.');
    }


    


    // ------------------------------------------------ E N D  - P R O F I L E ------------------------------------------------//

}
