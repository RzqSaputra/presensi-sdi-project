<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;

class PresensiPdfExport implements FromView
{
    public function exportPdf($tglAwal, $tglAkhir, $id)
    {
        $filename = 'rekap_presensi.pdf';

        $html = view('CetakLaporan.index', [
            'presensi' => Presensi::whereBetween('tgl_presensi', [$tglAwal, $tglAkhir])
                            ->where('user_id', $id)
                            ->get(),

            'totalMasuk' => Presensi::whereBetween('tgl_presensi', [$tglAwal, $tglAkhir])
                ->select(DB::raw("SEC_TO_TIME(SUM(TIME_TO_SEC(total_masuk))) as total_masuk"))
                ->first()
                ->total_masuk,

            
            'tanggalAwal' => $tglAwal,
            'tanggalAkhir' => $tglAkhir,
        ])->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->stream($filename);
    }
}
