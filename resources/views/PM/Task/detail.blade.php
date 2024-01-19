<!DOCTYPE html>
<html lang="en">
@include('template.head')
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

        <!----------------------------------------- S T A R T - K A R Y A W A N ---------------------------------------->

        <!-- Start Container -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if (session()->has('msg'))
                    <div class="alert alert-success" style="color:white;">
                        {{ session()->get('msg') }}
                        <div style="float: right">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif
                    <button class="btn btn-dark" type="button"
                        onclick="printJS({ 
                            printable: 'printJS-form', 
                            type: 'html',
                        })">
                        <i class="fa fa-print"></i> Print
                    </button>
                    <div class="card mb-4" id="printJS-form">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h5 class="font-weight-bolder">{{ $task->judul }}</h5>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">

                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-xs font-weight-bolder">No</th>
                                            <th class="text-center text-xs font-weight-bolder">Kegiatan</th>
                                            <th class="text-center text-xs font-weight-bolder">Mulai</th>
                                            <th class="text-center text-xs font-weight-bolder">Selesai</th>
                                            <th class="text-center text-xs font-weight-bolder">Keterangan</th>
                                            <th class="text-center text-xs font-weight-bolder">Bukti</th>
                                            <th class="text-center text-xs font-weight-bolder">Status</th>
                                            <th class="text-center text-xs font-weight-bolder">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($detailtask as $t)
                                        <tr>
                                            <td class="text-sm text-center">{{ $loop->iteration }}</td>
                                            <td class="text-sm text-center">{{ $t->kegiatan }}</td>
                                            <td class="text-sm text-center">{{ $t->mulai }}</td>
                                            <td class="text-sm text-center">{{ $t->selesai ?? 'Belum Selesai'}}</td>
                                            <td class="text-sm text-center">{{ $t->ket ?? 'N/A'}}</td>
                                            <td class="text-sm text-center">
                                                @if($t->bukti)
                                                <a href="{{ asset('storage/task/' . $t->bukti) }}">
                                                    <img src="{{ asset('storage/task/' . $t->bukti) }}" alt="Bukti"
                                                        style="max-width: 150px; max-height: 150px;">
                                                </a>
                                                @else
                                                N/A
                                                @endif
                                            </td>
                                            <td class="text-sm text-center">
                                                @if ($t->status == 1)
                                                <span
                                                    class="text-white text-xs font-weight-bold bg-warning badge rounded-pill">
                                                    In Progress
                                                </span>
                                                @elseif ($t->status == 2)
                                                <span
                                                    class="text-white text-xs font-weight-bold bg-primary badge rounded-pill">
                                                    Pengajuan
                                                </span>
                                                @elseif ($t->status == 3)
                                                <span
                                                    class="text-white text-xs font-weight-bold bg-success badge rounded-pill">
                                                    Approve
                                                </span>
                                                @elseif ($t->status == 4)
                                                <span
                                                    class="text-white text-xs font-weight-bold bg-warning badge rounded-pill">
                                                    Revisi
                                                </span>
                                                @elseif ($t->status == 5)
                                                <span
                                                    class="text-white text-xs font-weight-bold bg-danger badge rounded-pill">
                                                    Dibatalkan
                                                </span>
                                                @endif
                                            </td>
                                            <td class="text-sm text-center col-md-2">
                                                @if($t->status == 2)
                                                <button class="btn btn-link text-success text-gradient px-3 mb-0"
                                                    data-bs-toggle="modal" data-bs-target="#confirmSelesai-{{$t->id}}">
                                                    <i class="fa fa-check me-2"></i>
                                                    Terima
                                                </button>
                                                <button class="btn btn-link text-danger text-gradient px-3 mb-0"
                                                    data-bs-toggle="modal" data-bs-target="#confirmBatal-{{$t->id}}">
                                                    <i class="fa fa-exclamation-circle me-2"></i>
                                                    Revisi
                                                </button>
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

        <!-- ----------------------------------------- S T A R T - A D D ----------------------------------------->
        <div class="modal fade" id="addPresensiModal" data-bs-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPresensiLabel">Tambah Laporan Kegiatan</h5>
                        <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('detailtask.create', ['task_id' => $task->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="kegiatan" class="form-label">Kegiatan</label>
                                <textarea name="kegiatan" id="kegiatan" class="form-control" rows="4"
                                    required></textarea>
                            </div>

                            <div style="float: right">
                                <button type="submit" class="btn btn-primary mb-2">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!---------------------------------------------- E N D - A D D -------------------------------------------->

        <!---------------------------------------------- S T A R T - S E L E S A I -------------------------------------------->
        @foreach ($detailtask as $task)
        <div class="modal fade" id="confirmSelesai-{{$task->id}}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content p-3">
                    <div class="modal-body font-weight-bolder">
                        Apakah anda yakin menerima task ini ?
                    </div>
                    <div class="d-flex justify-content-end mx-2">
                        <button class="btn btn-danger mx-1 mt-2" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('taskKaryawan.done', $task->id ) }}" method="POST">
                            @csrf
                            <button class="btn btn-success mx-1 mt-2">
                                Ya, Terima
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <!---------------------------------------------- E N D - S E L E S A I -------------------------------------------->

        <!---------------------------------------------- S T A R T - R E V I S I -------------------------------------------->
        @foreach ($detailtask as $task)
        <div class="modal fade" id="confirmBatal-{{$task->id}}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content p-3">
                    <div class="modal-body font-weight-bolder">
                        Berikan Masukan dan Alasan Anda !
                    </div>
                    <form action="{{ route('taskKaryawan.revisi', $task->id ) }}" method="POST">
                        @csrf
                        <textarea type="text" name="ket" id="ket" class="form-control col-md-12" required></textarea>
                        <button class="btn btn-danger mx-1 mt-2" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-success mx-1 mt-2">
                            Ya, Revisi
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
        <!---------------------------------------------- E N D - R E V I S I -------------------------------------------->

        <!-- Footer -->
        @include('template.footer')
        <!-- End Footer -->
        </div>

    </main>
    <!--   Core JS Files   -->
    @include('template.script')
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="print.js"></script>
</body>

</html>
