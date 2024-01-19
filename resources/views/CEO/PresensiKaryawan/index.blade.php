<!DOCTYPE html>
<html lang="en">
@include('Template.head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('css/style.css')}}">

</style>

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>

    <!-- Sidebar -->
    @include('template.sidebar')
    <!-- End Sidebar -->

    <main class="main-content position-relative border-radius-lg ">

        <!-- Navbar -->
        @include('template.navbar')
        <!-- End Navbar -->

        <! ----------------------------------------- V I E W ----------------------------------------->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                    </div>
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="form-group mb-4 ">
                                        <h5 class="font-weight-bolder">Data Presensi Karyawan</h5>
                                    </div>
                                    <form action="{{ route('dataPresensi.karyawan') }}" method="GET" class="mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="form-group me-2">
                                                <input type="date" class="form-control" id="filterTanggalAwal"
                                                    name="filterTanggalAwal" value="{{ $tanggalAwal }}">
                                            </div>
                                            <div class="form-group me-2">
                                                <input type="date" class="form-control" id="filterTanggalAkhir"
                                                    name="filterTanggalAkhir" value="{{ $tanggalAkhir }}">
                                            </div>
                                            <button type="submit" class="btn btn-primary d-done">Filter</button>
                                            <a href="{{ route('dataPresensi.karyawan') }}"
                                                class="btn btn-danger ms-2 d-done">Reset</a>
                                            <button id="exportExcel" class="btn btn-success" style="margin-left: 6px">
                                                <i class="far fa-file-excel"></i> Excel
                                            </button>
                                            @php
                                            $tanggalAwal = now()->toDateString();
                                            $tanggalAkhir = now()->toDateString();
                                            @endphp
                                            <a target="_blank" type="submit" class="btn btn-primary d-don" style="margin-left: 8px " href="{{ route('cetak', 
                                            [
                                                'tanggalAwal' => $tanggalAwal,
                                                'tanggalAkhir' => $tanggalAkhir,
                                            ]) }}">Rekap</a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table id="example" class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center text-xs font-weight-bolder">No</th>
                                                <th class="text-center text-xs font-weight-bolder">Tanggal</th>
                                                <th class="text-center text-xs font-weight-bolder">Nama</th>
                                                <th class="text-center text-xs font-weight-bolder">Masuk</th>
                                                <th class="text-center text-xs font-weight-bolder">Selesai</th>
                                                <th class="text-center text-xs font-weight-bolder">Status</th>
                                                <th class="text-center text-xs font-weight-bolder">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($presensi as $key => $p)
                                            <tr>
                                                <td class="text-sm text-center">{{ $loop->iteration }}</td>
                                                <td class="text-sm text-center">{{ $p->tgl_presensi }}</td>
                                                <td class="text-sm text-center">{{ $p->user->karyawan->nama }}</td>
                                                <td class="text-sm text-center">{{ $p->mulai }}</td>
                                                <td class="text-sm text-center">{{ $p->selesai }}</td>
                                                <td class="text-sm text-center">
                                                    @if ($p->status == 1)
                                                    <span
                                                        class="text-white text-xs font-weight-bold bg-success badge rounded-pill">
                                                        Masuk
                                                    </span>
                                                    @elseif ($p->status == 2)
                                                    <span
                                                        class="text-white text-xs font-weight-bold bg-warning badge rounded-pill">
                                                        Izin
                                                    </span>
                                                    @elseif ($p->status == 3)
                                                    <span
                                                        class="text-white text-xs font-weight-bold bg-info badge rounded-pill">
                                                        Sakit
                                                    </span>
                                                    @elseif ($p->status == 4)
                                                    <span
                                                        class="text-white text-xs font-weight-bold bg-warning badge rounded-pill">
                                                        Telat
                                                    </span>
                                                    @else
                                                    <span
                                                        class="text-white text-xs font-weight-bold bg-secondary badge rounded-pill">
                                                        N/A
                                                    </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{----------------------------------------- E N D  - V I E W -----------------------------------------}}


            <!-- Footer -->
            @include('template.footer')
            <!-- End Footer -->

            </div>
    </main>

    <!-- Core JS Files -->
    @include('template.script')

</body>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function () {
        var table = $('#example').DataTable({
            dom: 'lBfrtip',
        });

        $('#exportExcel').on('click', function () {
            table.button('.buttons-excel').trigger();
        });

        $('.dt-buttons').addClass('d-none');
    });

    $(document).ready(function () {
        $('#user_id').on('click', function () {
            $('option[value=""]').remove();
        });
    });

    $(document).ready(function () {
        $('#status').on('click', function () {
            $('option[value=""]').remove();
        });
    });

    // $(document).ready(function () {
    //     // Memeriksa apakah DataTable sudah diinisialisasi sebelumnya pada elemen dengan ID "example"
    //     if ($.fn.DataTable.isDataTable('#example')) {
    //         // Jika sudah diinisialisasi, hancurkan inisialisasinya sebelum membuat inisialisasi baru
    //         $('#example').DataTable().destroy();
    //     }

    //     // Membuat inisialisasi DataTable baru pada elemen dengan ID "example"
    //     $('#example').DataTable({
    //         language: {
    //             emptyTable: "Tidak ada data presensi hari ini"
    //         }
    //         // Pengaturan lain yang mungkin Anda miliki
    //     });
    // });

</script>

</html>
