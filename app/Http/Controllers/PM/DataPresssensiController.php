<?php

namespace App\Http\Controllers\PM;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\Karyawan;
use App\Models\User;
use Carbon\Carbon;


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

    public function createPresensiManual(Request $request){
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
        return redirect()->route('data.Presensi');
    }

    public function deletePresensi($id){
        $user = Presensi::where('id', $id)->first();
        $user->delete();
        return redirect()->route('data.Presensi')->with('pesan', "Data berhasil dihapus");
    }

    public function detailPresensi($id)
    {
        $detail = Presensi::with('user.karyawan')->findOrFail($id);
        return view('pm.presensi.detailPresensi')->with([
            'detail' => $detail,
            'title'  => 'Detail Presensi'
        ]);
    }

   public function updateDetailPresensi(Request $request, $id)
    {
        $detail = Presensi::find($id);
        if ($detail) {
            $detail->ket = $request->ket;
            $detail->save();

            session()->flash('pesan', "Perubahan Data {$detail->user->karyawan->nama} berhasil");
        }
        return redirect()->route('detail.Presensi', ['id' => $id]);
    }

    // ----------------------------------------- E N D  - P R E S E N S I --------------------------------------------//
}