<?php

namespace App\Http\Controllers\pm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\ExcelExport;
use App\Models\Presensi;
use Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
class CetakLaporanController extends Controller
{
    public function __construct(){
        $this->middleware('pm');
    }
    
    public function index(Request $request, $tanggalAwal, $tanggalAkhir){
        // dd(Auth::user()->id)->get();
        $search = $request->input('search');
        $presensi = Presensi::whereBetween('tgl_presensi', [$tanggalAwal, $tanggalAkhir])
        ->when($search, function ($query) use ($search) {
            return $query->whereHas('user.karyawan', function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            });
    })
    ->get();
    $id = $presensi[0]->user_id;
    // $presensis = Presensi::where("user_id",Auth::user()->id)->get();

    return view('PM.CetakLaporan.index')->with([
        'presensi' => $presensi,
        'tanggalAwal' => $tanggalAwal,
        'tanggalAkhir' => $tanggalAkhir,
        'search' => $search,
        'id' => $id
    ]);
}




}
