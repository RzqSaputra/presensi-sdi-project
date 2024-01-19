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

    public function index(Request $request, $tanggalAwal, $tanggalAkhir)
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
