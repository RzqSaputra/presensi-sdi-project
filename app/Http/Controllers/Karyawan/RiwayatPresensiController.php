<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Presensi;

class RiwayatPresensiController extends Controller
{
    public function __construct()
    {
        $this->middleware('karyawan');
    }

    public function index()
    {
        $presensi = Presensi::where('user_id', Auth::user()->id)->get();
        return view('Karyawan.RiwayatPresensi.index')->with([
            'title' => 'Riwayat Presensi',
            'presensi' => $presensi,
        ]);
    }

    public function detail($id)
    {
        $detail = Presensi::find($id);
        return view('Karyawan.RiwayatPresensi.detail')->with([
            'detail' => $detail,
            'title'  => 'Detail Presensi',
        ]);
    }
}
