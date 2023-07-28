<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Karyawan;
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

}
