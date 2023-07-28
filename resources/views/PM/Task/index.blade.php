<!DOCTYPE html>
<html lang="en">
@include('template.head')

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>

    <!-- Sidebar -->
    @include('template.sidebar')
    <!-- End Sidebar -->

    <main class="main-content position-relative border-radius-lg ">

        <!-- Navbar -->
        @include('template.navbar')
        <!-- End Navbar -->

        {{----------------------------------------- V I E W -----------------------------------------}}

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if (session()->has('pesan'))
                    <div class="alert alert-success" style="color:white;">
                        {{ session()->get('pesan') }}
                        <div style="float: right">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-12">
                    {{-- <div class="card-header pb-0">
                        <div class="d-flex justify-content-start">
                            <button id="addPresensi" class="btn  bg-gradient-dark mb-3" data-bs-toggle="modal"
                                data-bs-target="#addPresensiModal">Tambah Data</button>
                        </div>
                    </div> --}}
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-group mb-4 ">
                                    <h5 class="font-weight-bolder">Task Karyawan</h5>
                                </div>
                                <form action="{{ route('taskKaryawan') }}" method="GET" class="mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="form-group me-2">
                                            <input type="text" class="form-control" id="filterNama" name="filterNama"
                                                placeholder="Search By Name">
                                        </div>
                                        <div class="form-group me-2">
                                            <input type="date" class="form-control" id="filterTanggalAwal"
                                                name="filterTanggalAwal" value="">
                                        </div>
                                        <div class="form-group me-2">
                                            <input type="date" class="form-control" id="filterTanggalAkhir"
                                                name="filterTanggalAkhir" value="">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('taskKaryawan') }}" class="btn btn-danger ms-2">Reset</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table id="pegawai-table" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Nama</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tanggal</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Task</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Keterangan</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($task->isEmpty())
                                        <tr>
                                            <td colspan="7" rowspan="4"
                                                class="text-center text-uppercase text-secondary text-sm py-5 font-weight-bold">
                                                Tidak Ada Data Task !
                                            </td>
                                        </tr>
                                        @else

                                        @foreach($task as $key => $p)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="px-2 mb-0 text-xs">
                                                            {{ $loop->iteration }}</h6>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <p class="text-xs font-weight-bold mb-0 text-center ">
                                                    {{ $p->user->karyawan->nama ?? 'N/A' }}</p>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="text-xs font-weight-bold mb-0">{{$p->tgl_task??'N/A'}}</span>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold mb-0">{{$p->judul??'N/A'}}</span>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="text-xs font-weight-bold mb-0">{{$p->deskripsi ??' N/A'}}</span>
                                            </td>

                                            <td class="align-middle text-center">
                                                @if ($p->status == 'Not Started')
                                                <span
                                                    class="text-white text-xs font-weight-bold bg-dark badge rounded-pill">
                                                    Not Started
                                                </span>
                                                @elseif ($p->status == 'In Progress')
                                                <span
                                                    class="text-white text-xs font-weight-bold bg-warning badge rounded-pill">
                                                    In Progress
                                                </span>
                                                @elseif ($p->status == 'Delayed')
                                                <span
                                                    class="text-white text-xs font-weight-bold bg-dark badge rounded-pill">
                                                    Sakit
                                                </span>
                                                @elseif ($p->status == 'Pending')
                                                <span
                                                    class="text-white text-xs font-weight-bold bg-warning badge rounded-pill">
                                                    Alpa
                                                </span>
                                                @elseif ($p->status == 'Done')
                                                <span
                                                    class="text-white text-xs font-weight-bold bg-success badge rounded-pill">
                                                    Alpa
                                                </span>
                                                @elseif ($p->status == 'Cancelled')
                                                <span
                                                    class="text-white text-xs font-weight-bold bg-warning badge rounded-pill">
                                                    Alpa
                                                </span>
                                                @else
                                                <span
                                                    class="text-white text-xs font-weight-bold bg-secondary badge rounded-pill">
                                                    N/A
                                                </span>
                                                @endif
                                            </td>

                                            <td class="align-middle text-center">
                                                <a href="{{ route('taskKaryawan.update', ['id' => $p->id]) }}">
                                                    <button class="btn btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                                {{-- <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#deletePegawai-{{ $p->id }}">
                                                    <button class="btn btn-danger">
                                                        <i class="fa fa-info"></i>
                                                    </button>
                                                </a> --}}
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                {{-- <div class="px-3 page d-flex justify-content-between">
                                    <small style="font-weight: bold">
                                        Showing {{ $karyawan->count() }} of {{ $karyawan->total() }} entries
                                </small>
                                {{ $karyawan->links('pagination::bootstrap-4') }}
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

            {{----------------------------------------- E N D  - V I E W -----------------------------------------}}


            {{-- ----------------------------------------- S T A R T - A D D -----------------------------------------}}

            {{-- <div class="modal fade" id="addPresensiModal" aria-labelledby="addPresensiLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPresensiLabel">Presensi Manual</h5>
                        <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('presensi.createPresensiManual') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="user_id" class="form-label">Nama Karyawan</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    <option value="">Pilih Nama Karyawan</option>
                    @foreach ($user->where('id', '>', 2) as $p)
                    <option value="{{ $p->id }}">{{ $p->karyawan->nama }}</option>
                    @endforeach
                </select>
                <div id="user_idError" class="invalid-feedback"></div>
            </div>

            <div class="mb-3">
                <label for="tgl_presensi" class="form-label">Tanggal Presensi</label>
                <input type="date" name="tgl_presensi" id="tgl_presensi" class="form-control" required>
                <div id="tgl_presensiError" class="invalid-feedback"></div>
            </div>

            <div class="mb-3">
                <label for="jam_masuk" class="form-label">Jam Masuk</label>
                <input type="time" name="jam_masuk" id="jam_masuk" class="form-control" required>
                <div id="jam_masukError" class="invalid-feedback"></div>
            </div>

            <div class="mb-3">
                <label for="jam_pulang" class="form-label">Jam Pulang</label>
                <input type="time" name="jam_pulang" id="jam_pulang" class="form-control" required>
                <div id="jam_pulangError" class="invalid-feedback"></div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="">Status</option>
                    <option value="1">Masuk</option>
                    <option value="2">izin</option>
                    <option value="3">Sakit</option>
                </select>
                <div id="statusError" class="invalid-feedback"></div>
            </div>

            <div class="mb-3">
                <label for="ket" class="form-label">Keterangan</label>
                <input type="text" name="ket" id="ket" class="form-control" required>
                <div id="ketError" class="invalid-feedback"></div>
            </div>

            <div style="float: right">
                <button type="submit" class="btn btn-primary mb-2">Tambah</button>
            </div>
            </form>
        </div>
        </div>
        </div>
        </div> --}}


        {{-- ------------------------------------------- E N D - A D D -------------------------------------------}}


        {{-------------------------------------- D E L E T E --------------------------------------}}
        @foreach($task as $p)
        <div class="modal fade" id="deleteDataPresensi-{{ $p->id }}" aria-labelledby="exampleModalLabel{{ $p->id }}"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="padding: 15px">
                    <div class="modal-body">Hapus data {{$p->user->karyawan->nama}} ?</div>
                    <div style="margin-right: 10px;">
                        <a class="btn btn-danger" href="dataPresensi/delete/{{ $p->id }}" style="float: right">Hapus</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach


        {{----------------------------------- E N D - D E L E T E --------------------------------------}}

        <!-- Footer -->
        @include('template.footer')
        {{-- End Footer --}}

        </div>
    </main>

    <!--   Core JS Files   -->
    @include('template.script')

</body>

<script>
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

    $(document).ready(function () {
        $('#filterNama').on('input', function () {
            var inputNama = $(this).val().toLowerCase();

            $('#dataabsensi tbody tr').each(function () {
                var nama = $(this).find('td:eq(3)').text().toLowerCase();

                if (nama.includes(inputNama)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });

</script>

</html>
