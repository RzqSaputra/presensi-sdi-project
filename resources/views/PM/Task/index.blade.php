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
                                                name="filterTanggalAwal" value="{{ $tanggalAwal }}">
                                        </div>
                                        <div class="form-group me-2">
                                            <input type="date" class="form-control" id="filterTanggalAkhir"
                                                name="filterTanggalAkhir" value="{{ $tanggalAkhir }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('taskKaryawan') }}" class="btn btn-danger ms-2">Reset</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0" >
                                <table id="task" class="table align-items-center mb-0">
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

                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="text-xs font-weight-bold mb-0">{{$p->user->karyawan->nama??'N/A'}}</span>
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
                                                    Delayed
                                                </span>
                                                @elseif ($p->status == 'Pending')
                                                <span
                                                    class="text-white text-xs font-weight-bold bg-warning badge rounded-pill">
                                                    Pending
                                                </span>
                                                @elseif ($p->status == 'Done')
                                                <span
                                                    class="text-white text-xs font-weight-bold bg-success badge rounded-pill">
                                                    Done
                                                </span>
                                                @elseif ($p->status == 'Cancelled')
                                                <span
                                                    class="text-white text-xs font-weight-bold bg-warning badge rounded-pill">
                                                    Cancelled
                                                </span>
                                                @else
                                                <span
                                                    class="text-white text-xs font-weight-bold bg-secondary badge rounded-pill">
                                                    N/A
                                                </span>
                                                @endif
                                            </td>
                                            @if($p->status == 'Done')
                                            <td class="align-middle text-center">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#staticBackdrop-{{$p->id}}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </td>
                                            @else
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold mb-0">
                                                    Not Done
                                                </span>
                                            </td>
                                            @endif 
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{----------------------------------------- E N D  - V I E W -----------------------------------------}}


                {{-- ----------------------------------------- S T A R T - E D I T -----------------------------------------}}

                @foreach($task as $p)
                <div class="modal fade" id="staticBackdrop-{{$p->id}}" data-bs-backdrop="static"
                    data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Task Karyawan</h5>
                                <button type="button" class="btn-close bg-danger mx-1" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class='mb-3'>
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" disabled
                                        value="{{ old('nama') ?? optional($p->user->karyawan)->nama }}">
                                </div>
                                <div class='mb-3'>
                                    <label for="judul" class="form-label">Judul</label>
                                    <input type="text" name="judul" id="judul" class="form-control" required
                                        value="{{ old('judul') ?? optional($p)->judul }}">
                                </div>
                                <div class='mb-3'>
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control" required>{{ old('deskripsi') ?? optional($p)->deskripsi }}
                                    </textarea>
                                </div>
                                <div class='mb-3'>
                                    <label for="tgl_task" class="form-label">Tanggal</label>
                                    <input type="date" name="tgl_task" id="tgl_task" class="form-control" required
                                        value="{{ old('tgl_task') ?? optional($p)->tgl_task }}">
                                </div>
                                <div class='mb-3'>
                                    <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                    <input type="time" name="waktu_mulai" id="waktu_mulai" class="form-control" required
                                        value="{{ old('waktu_mulai') ?? optional($p)->waktu_mulai }}">
                                </div>
                                <div class='mb-3'>
                                    <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                                    <input type="time" name="waktu_selesai" id="waktu_selesai" class="form-control"
                                        required value="{{ old('waktu_selesai') ?? optional($p)->waktu_selesai }}">
                                </div>
                                <div class='mb-3'>
                                    <label for="status" class="form-label">Status</label>
                                    <input type="text" name="status" id="status" class="form-control" disabled
                                        value="{{ old('status') ?? optional($p)->status }}">
                                </div>
                                <div class='mb-3'>
                                    <label for="status" class="form-label">Foto Task</label>
                                    <img src="{{ asset('FotoProfile/' . $p->foto) }}" alt="Foto Task"
                                        class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- ------------------------------------------- E N D - E D I T -------------------------------------------}}


                {{-------------------------------------- D E L E T E --------------------------------------}}
                {{-- @foreach($task as $p)
            <div class="modal fade" id="deleteDataPresensi-{{ $p->id }}"
                aria-labelledby="exampleModalLabel{{ $p->id }}"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content" style="padding: 15px">
                        <div class="modal-body">Hapus data {{$p->user->karyawan->nama}} ?</div>
                        <div style="margin-right: 10px;">
                            <a class="btn btn-danger" href="dataPresensi/delete/{{ $p->id }}"
                                style="float: right">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach --}}


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

            $('#task tbody tr').each(function () {
                var nama = $(this).find('td:eq(1)').text().toLowerCase();

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
