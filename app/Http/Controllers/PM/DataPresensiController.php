<?php

namespace App\Http\Controllers\PM;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Presensi;
use App\Models\User;

class DataPresensiController extends Controller
{
    public function __construct(){
        $this->middleware('pm');
    }

    public function index(Request $request){
        $tanggalAwal    = $request->input('filterTanggalAwal');
        $tanggalAkhir   = $request->input('filterTanggalAkhir');
        $user           = User::all();
        $presensi       = Presensi::with('user.karyawan')->when($tanggalAwal && $tanggalAkhir, 
        function ($query) use ($tanggalAwal, $tanggalAkhir) {
        return $query->whereBetween('tgl_presensi', 
        [$tanggalAwal, $tanggalAkhir]);})->paginate(5);

        return view('PM.Presensi.index')->with([
            'title'         => 'Data Presensi',
            'presensi'      => $presensi,
            'tanggalAwal'   => $tanggalAwal,
            'tanggalAkhir'  => $tanggalAkhir,
            'user'          => $user,
        ]);
    }

    public function create(Request $request){
        $validator = Validator::Make($request->all(), [
            'user_id'       => 'required|numeric|unique:App\Models\Karyawan,user_id',
            'tgl_presensi'  => 'required',
            'jam_masuk'     => 'required',
            'jam_pulang'    => 'required',
            'ket'           => 'required',
        ]);

        Presensi::create([
            'user_id'           => $request->user_id,
            'status'            => $request->status,
            'tgl_presensi'      => $request->tgl_presensi,
            'jam_masuk'         => $request->jam_masuk,
            'jam_pulang'        => $request->jam_pulang,
            'ket'               => $request->ket,
            'lokasi_masuk'      => 'Sabang Digital Indonesia',
            'lokasi_pulang'     => 'Sabang Digital Indonesia',
        ]);

        session()->flash('pesan',"Penambahan Data berhasil");
        return redirect()->route('dataPresensi');
    }

    public function update(Request $request, $id)
    {
        $detail = Presensi::find($id);
        if ($detail) {
            $detail->tgl_presensi = $request->tgl_presensi;
            $detail->ket = $request->ket;
            $detail->jam_masuk = $request->jam_masuk;
            $detail->jam_pulang = $request->jam_pulang;
            $detail->save();

            session()->flash('pesan', "Perubahan Data {$detail->user->karyawan->nama} berhasil");
        }
        return redirect()->route('dataPresensi.detail', ['id' => $id]);
    }

    public function delete($id){
        $user = Presensi::where('id', $id)->first();
        $user->delete();
        return redirect()->route('dataPresensi')->with('pesan', "Data berhasil dihapus");
    }

    public function detail($id)
    {
        $detail = Presensi::with('user.karyawan')->findOrFail($id);
        return view('PM.Presensi.detail')->with([
            'detail' => $detail,
            'title'  => 'Detail Presensi'
        ]);
    }

    
}
