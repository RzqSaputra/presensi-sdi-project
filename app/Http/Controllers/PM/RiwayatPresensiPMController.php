<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Presensi;

class RiwayatPresensiPMController extends Controller
{
    public function __construct()
    {
        $this->middleware('pm');
    }

    public function index()
    {
        $presensi = Presensi::where('user_id', Auth::user()->id)->get();
        return view('PM.RiwayatPresensi.index')->with([
            'title' => 'Riwayat Presensi',
            'presensi' => $presensi,
        ]);
    }

    public function detail($id)
    {
        $detail = Presensi::find($id);
        return view('PM.RiwayatPresensi.detail')->with([
            'detail' => $detail,
            'title'  => 'Detail Presensi',
        ]);
    }
}
