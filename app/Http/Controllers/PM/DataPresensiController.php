<?php

namespace App\Http\Controllers\PM;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Presensi;
use App\Models\User;

class DataPresensiController extends Controller
{
    public function __construct(){
        $this->middleware('pm');
    }

    public function index(Request $request)
    {
        $tanggalAwal = $request->input('filterTanggalAwal');
        $tanggalAkhir = $request->input('filterTanggalAkhir');
        $search = $request->input('search');
        $user = User::all();

        // Ambil tanggal hari ini dengan timezone default (asumsikan database menggunakan timezone yang sama)
        $tanggalHariIni = \Carbon\Carbon::now()->format('Y-m-d');

        $presensi = Presensi::with('user.karyawan')
        ->when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
            return $query->whereBetween('tgl_presensi', [$tanggalAwal, $tanggalAkhir]);
        })
        ->when(!$tanggalAwal && !$tanggalAkhir, function ($query) use ($tanggalHariIni) {
            // Filter berdasarkan tanggal hari ini jika tidak ada rentang tanggal yang ditentukan
            return $query->whereDate('tgl_presensi', $tanggalHariIni);
        })
        ->when($search, function ($query) use ($search) {
            // Filter berdasarkan pencarian nama karyawan
            return $query->whereHas('user.karyawan', function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            });
        })->get();


        return view('PM.PresensiKaryawan.index')->with([
            'title' => 'Data Presensi',
            'presensi' => $presensi,
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
            'search' => $search,
            'user' => $user,
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
            'mulai'             => $request->mulai,
            'selesai'           => $request->selesai,
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
            $detail->mulai = $request->mulai;
            $detail->selesai = $request->selesai;
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
        return view('PM.PresensiKaryawan.detail')->with([
            'detail' => $detail,
            'title'  => 'Detail Presensi'
        ]);
    }

    
}
