<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PresensiExport;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
    public function export($tglAwal,$tglAkhir,$id) 
    {
        return Excel::download(new PresensiExport($tglAwal,$tglAkhir,$id), 'Rekap Presensi.xlsx');
    }

   public function exportPdf($tglAwal, $tglAkhir, $id)
    {
        $filename = 'rekap_presensi.pdf';

         $html = view('PM.CetakLaporan.pdf', [
        'presensi' => Presensi::whereBetween('tgl_presensi', [$tglAwal, $tglAkhir])
            ->where('user_id', $id)
            ->get(),
        'tanggalAwal' => $tglAwal,
        'tanggalAkhir' => $tglAkhir,
        
        'totalMasuk' => Presensi::whereBetween('tgl_presensi', [$tglAwal, $tglAkhir])
            ->select(DB::raw("SEC_TO_TIME(SUM(TIME_TO_SEC(total_masuk))) as total_masuk"))
            ->first()
            ->total_masuk,
        'totalIzin' => Presensi::whereBetween('tgl_presensi', [$tglAwal, $tglAkhir])
            ->select(DB::raw("SEC_TO_TIME(SUM(TIME_TO_SEC(total_izin))) as total_izin"))
            ->first()
            ->total_izin,
        'totalTelat' => Presensi::whereBetween('tgl_presensi', [$tglAwal, $tglAkhir])
            ->select(DB::raw("SEC_TO_TIME(SUM(TIME_TO_SEC(total_telat))) as total_telat"))
            ->first()
            ->total_telat,
    ])->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();

        return $dompdf->stream($filename);
    }
}
