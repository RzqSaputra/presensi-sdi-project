<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\Karyawan;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function __construct()
    {
        $this->middleware('karyawan');
    }

    public function index()
    {
        $today = Carbon::now()->toDateString();
        $presensi = Presensi::where('user_id', Auth::user()->id)->where('tgl_presensi', $today)->first();
        $status = $presensi->status ?? "status";
        return view('Karyawan.Presensi.index')->with([
            'title' => 'Presensi',
            'presensi' => $presensi,
            'status' => $status,
        ]);
    }


    public function masuk(Request $request)
    {
        $img = $request->image;
        $folderPath = "presensi/masuk-";

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';

        $file = $folderPath . $fileName;
        Storage::put($file, $image_base64);
        $status = 1;

        if ($request->izin) {
            $status = 2;
        }
        
        $lokasi = $request->lokasi;
        
        $data = [
            'user_id' => Auth::user()->id,
            'status' => $status,
            'tgl_presensi' => date('Y-m-d'),
            'jam_masuk' => date('h:i:s'),
            'foto_masuk' => $fileName,
            'lokasi_masuk' => $lokasi,
            'ket' => $request->ket,
        ];
        Presensi::create($data);
        return redirect(route('presensi.karyawan'));
    }


    public function pulang(Request $request, Presensi $presensi)
    {
        $img = $request->image;
        $folderPath = "presensi/pulang-";
        $lokasi = $request->lokasi;


        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';

        $file = $folderPath . $fileName;
        Storage::put($file, $image_base64);


        Presensi::where('id', $presensi->id)->update([
            'jam_pulang' => date('h:i:s'),
            'foto_pulang' => $fileName,
            'lokasi_pulang' => $lokasi,
        ]);
        return redirect(route('presensi.karyawan'));
    }

}
