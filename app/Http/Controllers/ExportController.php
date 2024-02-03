<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ViewExport;

class ExportController extends Controller
{
    public function exportView($tanggalAwal, $tanggalAkhir)
    {
        return Excel::download(new ViewExport($tanggalAwal, $tanggalAkhir), 'exported_data.xlsx');
    }
}
