<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan</title>
</head>
<body>
    <h1>Laporan Presensi</h1>
   {{-- <a target="_blank" href="{{ route('export.excell', ['tanggalAwal' => $tanggalAwal, 'tanggalAkhir' => $tanggalAkhir]) }}">klass</a> --}}
    <p>Rekap Data Presensi dari tanggal {{$tanggalAwal}} - {{$tanggalAkhir}}</p>
    <table border="2px solid black" id="example" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Total Kerja</th>
                <th>Total Izin</th>
                <th>Total Telat</th>
                <th>Status Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @php
            $totalMasuk = Carbon\Carbon::createFromTime(0, 0, 0);
            $totalIzin = Carbon\Carbon::createFromTime(0, 0, 0);
            $totalTelat = Carbon\Carbon::createFromTime(0, 0, 0);
            @endphp

            @foreach($presensi as $key => $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->tgl_presensi }}</td>
                <td>{{ $p->user->karyawan->nama }}</td>
                <td>
                    @php
                    $waktuKerja = $p->total_masuk ? Carbon\Carbon::parse($p->total_masuk) :
                    Carbon\Carbon::createFromTime(0, 0, 0);
                    $totalMasuk =
                    $totalMasuk->addHours($waktuKerja->hour)->addMinutes($waktuKerja->minute)->addSeconds($waktuKerja->second);
                    @endphp
                    {{ $waktuKerja->format('H:i:s') }}
                </td>
                <td>
                    @php
                    $waktuKerja = $p->total_izin ? Carbon\Carbon::parse($p->total_izin) :
                    Carbon\Carbon::createFromTime(0, 0, 0);
                    $totalIzin =
                    $totalIzin->addHours($waktuKerja->hour)->addMinutes($waktuKerja->minute)->addSeconds($waktuKerja->second);
                    @endphp
                    {{ $waktuKerja->format('H:i:s') }}
                </td>
                <td>
                    @php
                    $waktuKerja = $p->total_telat ? Carbon\Carbon::parse($p->total_telat) :
                    Carbon\Carbon::createFromTime(0, 0, 0);
                    $totalTelat =
                    $totalTelat->addHours($waktuKerja->hour)->addMinutes($waktuKerja->minute)->addSeconds($waktuKerja->second);
                    @endphp
                    {{ $waktuKerja->format('H:i:s') }}
                </td>
                <td>
                    @if ($p->status == 1)
                    Masuk
                    @elseif ($p->status == 2)
                    Izin
                    @elseif ($p->status == 3)
                    Sakit
                    @elseif ($p->status == 4)
                    Telat
                    @else
                    N/A
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>Total Masuk: {{ $totalMasuk->hour }} Jam {{ $totalMasuk->minute }} Menit</p>
    <p>Total Izin: {{ $totalIzin->hour }} Jam {{ $totalIzin->minute }} Menit</p>
    <p>Total Telat: {{ $totalTelat->hour }} Jam {{ $totalTelat->minute }} Menit</p>

    {{-- <a href="{{ route('exportView', ['tanggalAwal' => $tanggalAwal, 'tanggalAkhir' => $tanggalAkhir]) }}">
        <button>Export to Excel</button>
    </a> --}}

</body>
</html>
