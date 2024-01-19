<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan</title>
</head>

<body>
    <h1>Laporan Presensi</h1>
    <p>Tanggal Awal: {{ $tanggalAwal }}</p>
    <p>Tanggal Akhir: {{ $tanggalAkhir }}</p>
    <table border="2px solid black">
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
            @foreach($presensi as $key => $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->tgl_presensi }}</td>
                <td>{{ $p->user->karyawan->nama }}</td>
                <td>Null</td>
                <td>Null</td>
                <td>
                    @php
                    $waktu = Carbon\Carbon::parse($p->total_telat);
                    $jam = $waktu->hour;
                    $menit = $waktu->minute;
                    @endphp
                    {{ $jam }} Jam {{ $menit }} Menit
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
</body>

</html>
