<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan</title>
</head>
<body>
    <h1>Laporan Presensi</h1>
   <a target="_blank" href="{{ route('export.excell', ['tanggalAwal' => $tanggalAwal, 'tanggalAkhir' => $tanggalAkhir,'id'=>$id]) }}"><button>Excel</button></a>
   <a target="_blank" href="{{ route('exportPdf', ['tanggalAwal' => $tanggalAwal, 'tanggalAkhir' => $tanggalAkhir,'id'=>$id]) }}"><button>Pdf</button></a>


    <p>Tanggal Awal: {{ $tanggalAwal }}</p>
    <p>Tanggal Akhir: {{ $tanggalAkhir }}</p>
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
            @foreach($presensi as $key => $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->tgl_presensi }}</td>
                <td>{{ $p->user->karyawan->nama }}</td>
                <td>
                    @php
                    $waktuKerja = $p->total_masuk ? Carbon\Carbon::parse($p->total_masuk) :
                    Carbon\Carbon::createFromTime(0, 0, 0);
                    @endphp
                    {{ $waktuKerja->format('H:i:s') }}
                </td>
                <td>
                    @php
                    $waktuKerja = $p->total_izin ? Carbon\Carbon::parse($p->total_izin) :
                    Carbon\Carbon::createFromTime(0, 0, 0);
                    @endphp
                    {{ $waktuKerja->format('H:i:s') }}
                </td>
                <td>
                    @php
                    $waktuKerja = $p->total_telat ? Carbon\Carbon::parse($p->total_telat) :
                    Carbon\Carbon::createFromTime(0, 0, 0);
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

        <p>Total Masuk = {{$totalMasuk}}</p>
        <p>Total Izin = {{$totalIzin}}</p>
        <p>Total Telat = {{$totalTelat}}</p>

      <div>
        <canvas id="myChart" class="poppins" width="400" height="200"></canvas>
      </div>

</body>
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun','Jul','Agu', 'Sep', 'Okt', 'Nov', 'Des'],
      datasets: [{
    label: 'Masuk',
    data: [
        @foreach ($classifiedMasuk as $item)
            {{ $item['total_masuk'] }},
        @endforeach
    ],
    borderWidth: 1
},{
        label: 'Izin',
        data: [
           @foreach ($classifiedIzin as $item)
            {{ $item['total_izin'] }},
        @endforeach
        ],
        borderWidth: 1
      },
    {
        label: 'Telat',
        data: [
          @foreach ($classifiedTelat as $item)
            {{ $item['total_telat'] }},
        @endforeach
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
{{-- @foreach ($classifiedMasuk as $item)
   
   {{ $item['total_masuk'] }}

@endforeach
 {{dd($classifiedMasuk,$classifiedIzin,$classifiedTelat);}} --}}

</html>
