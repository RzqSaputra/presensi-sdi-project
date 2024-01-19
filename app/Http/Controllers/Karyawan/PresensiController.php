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
        $presensi = Presensi::where('user_id', Auth::user()->id)->latest('id')->
        where('tgl_presensi', $today)->first();
        $status = $presensi->status ?? "status";
        return view('Karyawan.Presensi.index')->with([
            'title' => 'Presensi',
            'presensi' => $presensi,
            'status' => $status,
        ]);
    }

    public function masuk(Request $request)
    {
        $isLate = false;
        $img = $request->my_camera;
        $folderPath = "storage/presensi/masuk-";
        $fileName = uniqid() . '.png';
        
        $explodedData = explode(",", $img);
        $imageData = isset($explodedData[1]) ? base64_decode($explodedData[1]) : null;
        $filePath = $folderPath . $fileName;

        file_put_contents($filePath, $imageData);

        $tglPresensi = now()->format('Y-m-d');

        // Cek apakah sudah pernah absen sebelumnya pada tanggal yang sama
        $presensiSebelumnya = Presensi::where('user_id', Auth::user()->id)
            ->where('tgl_presensi', $tglPresensi)
            ->orderBy('id', 'asc') // Urutkan berdasarkan ID (status pertama kali)
            ->first();

        if ($presensiSebelumnya) {
            // Jika ada data absen pertama, gunakan status dari data tersebut
            $status = $presensiSebelumnya->status;
            $status = $isLate ? 4 : 1;
        } else {
            // Jika tidak ada, hitung total telat berdasarkan waktu masuk yang diinginkan
            $desiredStartTime = now()->setTime(7, 30);
            $actualStartTime = now();
            $timeDifference = $actualStartTime->diffInMinutes($desiredStartTime);
            $isLate = $timeDifference > 0;
            $status = $isLate ? 4 : 1;
        }

        $data = [
            'user_id' => Auth::user()->id,
            'status' => $status,
            'tgl_presensi' => $tglPresensi,
            'mulai' => now()->format('H:i:s'),
            'selesai' => now()->format('H:i:s'),
            'foto_masuk' => $fileName,
            'foto_pulang' => $fileName,
            'lokasi_masuk' => $request->lokasi,
            'lokasi_pulang' => $request->lokasi,
            'ket' => $request->ket,
        ];

        // Mengosongkan total telat jika sudah ada di data sebelumnya
        if ($presensiSebelumnya && $presensiSebelumnya->total_telat) {
            $data['total_telat'] = null;
        } else {
            // Jika tidak ada total telat pada data sebelumnya, hitung dan masukkan ke data baru
            $totalTelat = $isLate ? sprintf('%02d:%02d:00', floor($timeDifference / 60), $timeDifference % 60) : null;
            $data['total_telat'] = $totalTelat;
        }

        $selesai = Presensi::where('user_id', Auth::user()->id)
            ->latest('id')
            ->where('tgl_presensi', now()->format('Y-m-d'))
            ->first();

        // Update waktu selesai pada presensi sebelumnya jika status adalah 2
        if ($selesai && $selesai->status === 2) {
            $selesai->update(['selesai' => now()->format('H:i:s')]);
        }
        // dd($request->all());
        Presensi::create($data);

        return redirect(route('presensi.karyawan'));
    }


    public function pulang(Request $request, $presensiId)
    {
        $isLate = false;
        $img = $request->my_camera;
        $folderPath = "storage/presensi/pulang-";
        $fileName = uniqid() . '.png';

        $explodedData = explode(",", $img);
        $imageData = isset($explodedData[1]) ? base64_decode($explodedData[1]) : null;
        $filePath = $folderPath . $fileName;

        file_put_contents($filePath, $imageData);

        $lokasi = $request->lokasi;

        // Ambil data presensi berdasarkan ID
        $presensi = Presensi::findOrFail($presensiId);

        // Cek apakah sudah pernah absen sebelumnya pada tanggal yang sama
        $presensiPertama = Presensi::where('user_id', Auth::user()->id)
            ->where('tgl_presensi', $presensi->tgl_presensi)
            ->orderBy('id', 'asc')
            ->first();

        if ($presensiPertama) {
            // Jika ada data absen pertama, gunakan status pertama kali
            $status = $presensiPertama->status;
            $status = $isLate ? 4 : 1;
        } else {
            // Jika tidak ada, gunakan status yang ada di presensi saat ini
            $status = $presensi->status;
        }

        $updateData = [
            'selesai' => now()->format('H:i:s'),
            'foto_pulang' => $fileName,
            'lokasi_pulang' => $lokasi,
            'status' => $status, // Gunakan status yang diambil dari kondisi di atas
        ];

        $presensi->update($updateData);

        return redirect(route('presensi.karyawan'));
    }


    public function sakit()
    {
        return view('Karyawan.Presensi.sakit')->with([
            'title' => 'Presensi Sakit'
        ]);
    }

    public function uploadsakit(Request $request)
    {
    $files = $request->file('file');
    $folderPath = "sakit/";

    $user = Auth::user();

    foreach ($files as $file) {
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs($folderPath, $fileName);

        $data = [
            'user_id' => $user->id,
            'status' => 3,
            'tgl_presensi' => now()->format('Y-m-d'),
            'mulai' => '00:00:00',
            'selesai' => '00:00:00',
            'lokasi_masuk' => $request->lokasi,
            'lokasi_pulang' => $request->lokasi,
            'file' => $fileName,
            'ket' => $request->ket,
        ];
        Presensi::create($data);
    }
    return redirect()->route('presensi.karyawan');
    }

    public function izin()
    {
        return view('Karyawan.Presensi.izin')->with([
            'title' => 'Presensi Izin'
        ]);
    }

    public function uploadizin(Request $request)
    {
        $files = $request->file('file');
        $keterangan = $request->keterangan;
        $mulai = $request->mulai;
        $selesai = $request->selesai;
        $lokasi = $request->lokasi;

        foreach ($files as $file) {
            $namaFile = $file->getClientOriginalName();
            
            $file->storeAs('izin', $namaFile);
            
            $data = [
                'user_id' => Auth::user()->id,
                'status' => 2,
                'tgl_presensi' => now()->format('Y-m-d'),
                'mulai' => now()->format('H:i:s'),
                'selesai' => $selesai,
                'foto_masuk' => $namaFile,
                'foto_pulang' => $namaFile,
                'lokasi_masuk' => $request->lokasi,
                'lokasi_pulang' => $request->lokasi,
                'ket' => $keterangan,
            ];

            $presensiSebelumnya = Presensi::where('user_id', Auth::user()->id)
                ->whereIn('status', [1, 4])
                ->latest('id')
                ->where('tgl_presensi', now()->format('Y-m-d'))
                ->first();

            if ($presensiSebelumnya) {
                $presensiSebelumnya->update(['selesai' => now()->format('H:i:s')]);
                Presensi::create($data);
            } else {
                Presensi::create($data);
            }
        }
        return redirect()->route('presensi.karyawan');
    }
}
