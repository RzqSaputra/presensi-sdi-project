<?php

namespace App\Exports;

use App\Models\Presensi;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PresensiExport implements FromView
{
    protected $id;
    protected $tglAwal;
    protected $tglAkhir;
 

 function __construct($tglAwal,$tglAkhir,$id) {
        $this->id = $id;
        $this->tglAwal = $tglAwal;
        $this->tglAkhir = $tglAkhir;
      
 }    
    public function view(): View
    {
        $totalMasuk = Presensi::whereBetween('tgl_presensi', [$this->tglAwal, $this->tglAkhir])
            ->select(DB::raw("SEC_TO_TIME(SUM(TIME_TO_SEC(total_masuk))) as total_masuk"))
            ->first()
            ->total_masuk;

        $totalIzin = Presensi::whereBetween('tgl_presensi', [$this->tglAwal, $this->tglAkhir])
            ->select(DB::raw("SEC_TO_TIME(SUM(TIME_TO_SEC(total_izin))) as total_izin"))
            ->first()
            ->total_izin;

        $totalTelat = Presensi::whereBetween('tgl_presensi', [$this->tglAwal, $this->tglAkhir])
            ->select(DB::raw("SEC_TO_TIME(SUM(TIME_TO_SEC(total_telat))) as total_telat"))
            ->first()
            ->total_telat;

        $presensi = Presensi::whereBetween('tgl_presensi', [$this->tglAwal, $this->tglAkhir])
            ->where('user_id',$this->id)
            ->get();


        return view('PM.CetakLaporan.excell', [
            'presensi' => $presensi,
            'tanggalAwal' => $this->tglAwal,
            'tanggalAkhir' => $this->tglAkhir,
            'totalMasuk' => $totalMasuk,
            'totalIzin' => $totalIzin,
            'totalTelat' => $totalTelat,
        ]);
    }

}