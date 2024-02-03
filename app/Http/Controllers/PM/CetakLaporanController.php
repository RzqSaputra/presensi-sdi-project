<?php

namespace App\Http\Controllers\pm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use Carbon;
class CetakLaporanController extends Controller
{
    public function __construct(){
        $this->middleware('pm');
    }
    
    public function index(Request $request, $tanggalAwal, $tanggalAkhir){
        $search = $request->input('search');
        $presensi = Presensi::whereBetween('tgl_presensi', [$tanggalAwal, $tanggalAkhir])
        ->when($search, function ($query) use ($search) {
            return $query->whereHas('user.karyawan', function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            });
    })->get();

    return view('PM.CetakLaporan.index')->with([
        'presensi' => $presensi,
        'tanggalAwal' => $tanggalAwal,
        'tanggalAkhir' => $tanggalAkhir,
        'search' => $search,
    ]);
}


}
