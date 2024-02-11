<?php

namespace App\Exports;

use App\Models\Presensi;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;

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
                $presensi = Presensi::whereBetween('tgl_presensi', [$this->tglAwal, $this->tglAkhir])
        ->where('user_id',$this->id)
    ->get();
        $presensi = Presensi::where("user_id",$this->id)->get();
        return view('PM.CetakLaporan.excell', [
            'presensi' => $presensi,
              'tanggalAwal' => $this->tglAwal,
        'tanggalAkhir' => $this->tglAkhir,
        ]);
    }


    
}