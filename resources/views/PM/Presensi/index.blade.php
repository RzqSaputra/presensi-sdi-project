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
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-start">
                            <button id="addPresensi" class="btn  bg-gradient-dark mb-3" data-bs-toggle="modal"
                                data-bs-target="#addPresensiModal">Tambah Data</button>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-group mb-4 ">
                                    <h5 class="font-weight-bolder">Data Presensi Karyawan</h5>
                                </div>
                                <form action="{{ route('dataPresensi') }}" method="GET" class="mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="form-group me-2">
                                            <input type="text" class="form-control" id="filterNama" name="filterNama"
                                                placeholder="Search By Name">
                                        </div>
                                        <div class="form-group me-2">
                                            <input type="date" class="form-control" id="filterTanggalAwal"
                                                name="filterTanggalAwal" value="{{ $tanggalAwal }}">
                                        </div>
                                        <div class="form-group me-2">
                                            <input type="date" class="form-control" id="filterTanggalAkhir"
                                                name="filterTanggalAkhir" value="{{ $tanggalAkhir }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('dataPresensi') }}" class="btn btn-danger ms-2">Reset</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table id="dataabsensi" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Tanggal</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                NIP</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nama</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($presensi->isEmpty())
                                        <tr>
                                            <td colspan="6" rowspan="4"
                                                class="text-center text-uppercase text-secondary text-sm py-5 font-weight-bold">
                                                Tidak ada data presensi !
                                            </td>
                                        </tr>
                                        @else
                                        @foreach($presensi as $key => $p)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="px-2 mb-0 text-xs">
                                                            {{ $presensi->firstItem() + $key }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{$p->tgl_presensi??'N/A'}}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{$p->user->karyawan->nip??'N/A'}}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{$p->user->karyawan->nama??'N/A'}}
                                                </span>
                                            </td>

                                            <td class="align-middle text-center">
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
                                            <td class="align-middle text-center">
                                                <a href="{{ route('dataPresensi.detail', ['id' => $p->id]) }}">
                                                    <button class="btn btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#deleteDataPresensi-{{ $p->id }}">
                                                    <button class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div class="px-3 page d-flex justify-content-between">
                                    <small style="font-weight: bold">
                                        Showing {{ $presensi->count() }} of {{ $presensi->total() }} entries
                                    </small>
                                    {{ $presensi->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{----------------------------------------- E N D  - V I E W -----------------------------------------}}


        {{-- ----------------------------------------- S T A R T - A D D -----------------------------------------}}

        <div class="modal fade" id="addPresensiModal" aria-labelledby="addPresensiLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPresensiLabel">Presensi Manual</h5>
                        <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('dataPresensi.create') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="user_id" class="form-label">Nama Karyawan</label>
                                <select name="user_id" id="user_id" class="form-select" required>
                                    <option value="">Pilih Nama Karyawan</option>
                                    @foreach ($user->where('id', '>', 1) as $p)
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
        </div>


        {{-- ------------------------------------------- E N D - A D D -------------------------------------------}}


        {{-------------------------------------- D E L E T E --------------------------------------}}
        @foreach($presensi as $p)
        <div class="modal fade" id="deleteDataPresensi-{{ $p->id }}" aria-labelledby="exampleModalLabel{{ $p->id }}"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="padding: 15px">
                    <div class="modal-body">Hapus data {{$p->user->karyawan->nama}} ?</div>
                    <div style="margin-right: 10px;">
                        <a class="btn btn-danger" href="delete/{{ $p->id }}" style="float: right">Hapus</a>
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
