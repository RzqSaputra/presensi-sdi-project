<?php

namespace App\Http\Controllers\pm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CetakLaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('pm');
    }
    
    public function index(Request $request, $tanggalAwal, $tanggalAkhir)
    {
        $search = $request->input('search');
        
        $presensi = Presensi::whereBetween('tgl_presensi', [$tanggalAwal, $tanggalAkhir])
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('user.karyawan', function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%');
                });
            })
            ->get();

        // Generate monthly summaries based on $presensi data
        $monthlySummaries = $presensi->groupBy(function ($date) {
            return Carbon::parse($date->tgl_presensi)->format('Y-m');
        });
        
        // If you want to get only the keys (months)
        $months = $monthlySummaries->keys();

        // If you want to get the count of presensi for each month
        $counts = $monthlySummaries->map->count();

        // Mengambil data yang sudah diklasifikasikan berdasarkan bulan
        $classifiedMasuk = $monthlySummaries->map(function ($entries, $month) use ($counts) {
            return [
                'month' => $month,
                'entries' => $entries,
                'count' => $counts[$month],
                'total_masuk' => $this->calculateTotalMasuk($entries),
            ];
        });
        $classifiedTelat = $monthlySummaries->map(function ($entries, $month) use ($counts) {
            return [
                'month' => $month,
                'entries' => $entries,
                'count' => $counts[$month],
                'total_telat' => $this->calculateTotalTelat($entries),
            ];
        });
        $classifiedIzin = $monthlySummaries->map(function ($entries, $month) use ($counts) {
            return [
                'month' => $month,
                'entries' => $entries,
                'count' => $counts[$month],
                'total_izin' => $this->calculateTotalIzin($entries),
            ];
        });

        $id = $presensi->isEmpty() ? null : $presensi[0]->user_id;
        
        $totalMasuk = Presensi::whereBetween('tgl_presensi', [$tanggalAwal, $tanggalAkhir])
            ->where('status', 1)
            ->select(DB::raw("SEC_TO_TIME(SUM(TIME_TO_SEC(total_masuk))) as total_masuk"))
            ->first()
            ->total_masuk;

        $totalIzin = Presensi::whereBetween('tgl_presensi', [$tanggalAwal, $tanggalAkhir])
            ->where('status', 1)
            ->select(DB::raw("SEC_TO_TIME(SUM(TIME_TO_SEC(total_izin))) as total_izin"))
            ->first()
            ->total_izin;

        $totalTelat = Presensi::whereBetween('tgl_presensi', [$tanggalAwal, $tanggalAkhir])
            ->where('status', 1)
            ->select(DB::raw("SEC_TO_TIME(SUM(TIME_TO_SEC(total_telat))) as total_telat"))
            ->first()
            ->total_telat;

        $search = $request->input('search');
        if(!$search){
            return view('PM.CetakLaporan.index2')->with([
                'presensi' => $presensi,
                'tanggalAwal' => $tanggalAwal,
                'tanggalAkhir' => $tanggalAkhir,
                'search' => $search,
                'id' => $id,
                'monthlySummaries' => $monthlySummaries,
                'classifiedMasuk' => $classifiedMasuk,
                'classifiedIzin' => $classifiedIzin,
                'classifiedTelat' => $classifiedTelat,
                'totalMasuk' => $totalMasuk,
                'totalIzin' => $totalIzin,
                'totalTelat' => $totalTelat,
            ]);
        }
        else {
            return view('PM.CetakLaporan.index')->with([
                'presensi' => $presensi,
                'tanggalAwal' => $tanggalAwal,
                'tanggalAkhir' => $tanggalAkhir,
                'search' => $search,
                'id' => $id,
                'monthlySummaries' => $monthlySummaries,
                'classifiedMasuk' => $classifiedMasuk,
                'classifiedIzin' => $classifiedIzin,
                'classifiedTelat' => $classifiedTelat,
                'totalMasuk' => $totalMasuk,
                'totalIzin' => $totalIzin,
                'totalTelat' => $totalTelat,
            ]);
        }
    }

    // Function to calculate total masuk for given entries
     private function calculateTotalMasuk($entries)
    {
        $totalMinutes = 0;

        foreach ($entries as $entry) {
            // Jika total_masuk tidak null, tambahkan ke totalMinutes
            if ($entry->total_masuk !== null) {
                // Explode string waktu menjadi array jam, menit, dan detik
                $timeParts = explode(':', $entry->total_masuk);

                // Pastikan bahwa semua elemen dalam $timeParts adalah bilangan bulat
                $timeParts = array_map('intval', $timeParts);

                // Konversi array menjadi jumlah menit
                $minutes = $timeParts[0] * 60 + $timeParts[1] + round($timeParts[2] / 60);

                // Tambahkan jumlah menit ke totalMinutes
                $totalMinutes += $minutes;
            }
        }

        return $totalMinutes;
    }

    // Function to calculate total telat for given entries in minutes
    private function calculateTotalTelat($entries)
    {
        $totalMinutes = 0;

        foreach ($entries as $entry) {
            // Jika total_telat tidak null, tambahkan ke totalMinutes
            if ($entry->total_telat !== null) {
                // Explode string waktu menjadi array jam, menit, dan detik
                $timeParts = explode(':', $entry->total_telat);

                // Pastikan bahwa semua elemen dalam $timeParts adalah bilangan bulat
                $timeParts = array_map('intval', $timeParts);

                // Konversi array menjadi jumlah menit
                $minutes = $timeParts[0] * 60 + $timeParts[1] + round($timeParts[2] / 60);

                // Tambahkan jumlah menit ke totalMinutes
                $totalMinutes += $minutes;
            }
        }

        return $totalMinutes;
    }

    // Function to calculate total izin for given entries in minutes
    private function calculateTotalIzin($entries)
    {
        $totalMinutes = 0;

        foreach ($entries as $entry) {
            // Jika total_izin tidak null, tambahkan ke totalMinutes
            if ($entry->total_izin !== null) {
                // Explode string waktu menjadi array jam, menit, dan detik
                $timeParts = explode(':', $entry->total_izin);

                // Pastikan bahwa semua elemen dalam $timeParts adalah bilangan bulat
                $timeParts = array_map('intval', $timeParts);

                // Konversi array menjadi jumlah menit
                $minutes = $timeParts[0] * 60 + $timeParts[1] + round($timeParts[2] / 60);

                // Tambahkan jumlah menit ke totalMinutes
                $totalMinutes += $minutes;
            }
        }

        return $totalMinutes;
    }

    // ...

}
