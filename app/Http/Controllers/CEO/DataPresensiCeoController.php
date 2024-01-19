<?php

namespace App\Http\Controllers\CEO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Presensi;
use App\Models\User;

class DataPresensiCeoController extends Controller
{
    public function __construct(){
        $this->middleware('ceo');
    }

    public function index(Request $request)
    {
        $tanggalAwal = $request->input('filterTanggalAwal');
        $tanggalAkhir = $request->input('filterTanggalAkhir');
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
            ->get();

        return view('CEO.PresensiKaryawan.index')->with([
            'title' => 'Data Presensi',
            'presensi' => $presensi,
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
            'user' => $user,
        ]);
    }

    public function cetak(Request $request, $tanggalAwal, $tanggalAkhir)
    {
        $search = request()->query('search');
        $presensi = Presensi::whereBetween('tgl_presensi', [$tanggalAwal, $tanggalAkhir])
                            ->when($search, function ($query, $search) {
                                return $query->where('user_id', 'like', '%'.$search.'%');
                            })
                            ->get();
        
        return view('PM.CetakLaporan.index')->with([
            'presensi' => $presensi,
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
        ]);
    }
}
