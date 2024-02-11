<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PresensiExport;

class ExportController extends Controller
{
    public function export($tglAwal,$tglAkhir,$id) 
    {
        return Excel::download(new PresensiExport($tglAwal,$tglAkhir,$id), 'Rekap Presensi.xlsx');
    }

}
