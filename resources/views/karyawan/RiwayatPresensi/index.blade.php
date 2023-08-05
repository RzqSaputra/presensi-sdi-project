<!DOCTYPE html>
<html lang="en">
@include('Template.head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('css/style.css')}}">

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>

    <!-- Sidebar -->
    @include('template.sidebar')
    <!-- End Sidebar -->

    <main class="main-content position-relative border-radius-lg ">

        <!-- Navbar -->
        @include('template.navbar')
        <!-- End Navbar -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if (session()->has('msg'))
                    <div class="alert alert-success" style="color:white;">
                        {{ session()->get('msg') }}
                        <div style="float: right">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-12">
                    @if(session()->has('pesan'))
                    <div class="alert alert-success" style="color:white;">
                        {{ session()->get('pesan')}}
                        <div style="float: right">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>

                    @endif

                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h5 class="font-weight-bolder">Riwayat Presensi</h5>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table id="example" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-xs font-weight-bolder">No</th>
                                            <th class="text-center text-xs font-weight-bolder">Tanggal</th>
                                            <th class="text-center text-xs font-weight-bolder">Jam Masuk</th>
                                            <th class="text-center text-xs font-weight-bolder">Jam Pulang</th>
                                            <th class="text-center text-xs font-weight-bolder">Status</th>
                                            <th class="text-center text-xs font-weight-bolder">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($presensi->isEmpty())
                                        <tr>
                                            <td colspan="6" rowspan="4"
                                                class="text-center text-uppercase text-secondary text-sm py-4 text-sm py-5 font-weight-bold">
                                                Tidak Ada Riwayat Presensi !
                                            </td>
                                        </tr>

                                        @else

                                        @foreach($presensi as $key => $p)
                                        <tr>
                                            <td class="col-md-1 text-sm text-center">{{$loop->iteration}}</td>
                                            <td class="col-md-3 text-sm text-center">{{$p->tgl_presensi}}</td>
                                            <td class="col-md-2 text-sm text-center">{{$p->jam_masuk}}</td>
                                            <td class="col-md-2 text-sm text-center">{{$p->jam_pulang ?? 'Belum Presensi Pulang'}}</td>
                                            <td class="col-md-2 text-sm text-center">
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
                                                    class="text-white text-xs font-weight-bold bg-danger badge rounded-pill">
                                                    Alpa
                                                </span>
                                                @else
                                                <span
                                                    class="text-white text-xs font-weight-bold bg-secondary badge rounded-pill">
                                                    N/A
                                                </span>
                                                @endif
                                            </td>
                                            <td class="col-md-2 text-center">
                                                <a href="{{ route('riwayatPresensi.detail',['id' => $p->id])}}">
                                                    <button class="btn btn-primary">
                                                        <i class="fa fa-info"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end container-->

        {{-- footer --}}
        @include('template.footer')
        {{-- end footer --}}

        </div>
    </main>
    <!--   Core JS Files   -->
    @include('template.script')

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script>
        new DataTable('#example');
    </script>
</body>
</html>
