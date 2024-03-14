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
                <div class="col-12">
                    <div class="card-header pb-0 mt-2">
                        <div class="d-flex justify-content-start">
                            <button id="addPresensi" class="btn  bg-gradient-dark mb-3" data-bs-toggle="modal"
                                data-bs-target="#addPresensiModal">Tambah Data</button>
                        </div>
                    </div>
                     @if (session()->has('msg'))
                    <div class="alert alert-success" style="color:white;">
                        {{ session()->get('msg') }}
                        <div style="float: right">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif
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
                            <div class="table-responsive p-0">
                                <table id="task" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Judul Task</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nama Karyawan</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Mulai</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Selesai</th>
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
                                                <span class="text-xs font-weight-bold mb-0">{{$p->judul??'N/A'}}</span>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="text-xs font-weight-bold mb-0">{{$p->user->karyawan->nama??'N/A'}}</span>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold mb-0">{{$p->mulai??'N/A'}}</span>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="text-xs font-weight-bold mb-0">{{$p->selesai??'N/A'}}</span>
                                            </td>

                                            <td class="text-sm text-center">
                                                @if ($p->status == 1)
                                                <span
                                                    class="text-white text-xs font-weight-bold bg-warning badge rounded-pill">
                                                    Proses
                                                </span>
                                                @else
                                                <span
                                                    class="text-white text-xs font-weight-bold bg-success badge rounded-pill">
                                                    Selesai
                                                </span>
                                                @endif
                                            </td>
                                            
                                            <td class="text-sm text-center">
                                                @if ($p->status!=2)
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#selesaiTask-{{ $p->id }}">
                                                    <button class="btn btn-success">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </a>   
                                                @endif
                                                
                                                <a href="{{ route('taskKaryawan.detail', ['id' => $p->id]) }}">
                                                    <button class="btn btn-primary">
                                                        <i class="fa fa-info"></i>
                                                    </button>
                                                </a>
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#editTask-{{ $p->id }}">
                                                    <button class="btn btn-warning">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#deleteTask-{{ $p->id }}">
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
                                <h5 class="modal-title" id="addPresensiLabel">Task Karyawan</h5>
                                <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('taskKaryawan.create') }}" method="POST">
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
                                        <label for="judul" class="form-label">Judul Task</label>
                                        <input type="text" name="judul" id="judul" class="form-control" required>
                                        <div id="judulError" class="invalid-feedback"></div>
                                    </div>

                                    <div style="float: right">
                                        <button type="submit" class="btn btn-primary mb-2">Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!--------------------------------------------- E N D - A D D ------------------------------------------->


                {{-- ----------------------------------------- S T A R T - E D I T -----------------------------------------}}

                @foreach($task as $p)
                <div class="modal fade" id="editTask-{{$p->id}}" data-bs-backdrop="static" data-bs-keyboard="false"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Edit Task Karyawan</h5>
                                <button type="button" class="btn-close bg-danger mx-1" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('taskKaryawan.update', ['id' => $p->id]) }}" method="POST">
                                    @csrf
                                    {{-- <div class='mb-3'>
                                        <label for="user_id" class="form-label">Nama Karyawan</label>
                                        <select name="user_id" id="user_id" class="form-select" required>
                                            @foreach ($user->where('id', '>', 1) as $user)
                                            <option value="{{ $p->user }}" @if($user->id == optional($p->user)->id)
                                                selected @endif>{{ $user->karyawan->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}

                                    <div class='mb-3'>
                                        <label for="user_id" class="form-label">Nama Karyawan</label>
                                        <select name="user_id" id="user_id" class="form-select" required>
                                            @foreach ($user->where('id', '>', 1) as $singleUser)
                                                <option value="{{ $singleUser->id }}" @if($singleUser->id == optional($p->user)->id) selected @endif>
                                                    {{ $singleUser->karyawan->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class='mb-3'>
                                        <label for="judul" class="form-label">Judul</label>
                                        <input type="text" name="judul" id="judul" class="form-control" required
                                            value="{{ old('judul', $p->judul) }}">
                                    </div>

                                    <div class='mb-3'>
                                        <label for="mulai" class="form-label">Mulai</label>
                                        <input type="date" name="mulai" id="mulai" class="form-control" required
                                            value="{{ old('mulai', $p->mulai) }}">
                                    </div>

                                    <div class='mb-3'>
                                        <label for="selesai" class="form-label">Selesai</label>
                                        <input type="date" name="selesai" id="selesai" class="form-control" required
                                            value="{{ old('selesai', $p->selesai) }}">
                                    </div>

                                    <div class='mb-3'>
                                        <label for="status" class="form-label">Status</label>
                                        <input type="text" name="status" id="status" class="form-control"
                                            value="{{ old('status', $p->status) }}">
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach


                {{-- ------------------------------------------- E N D - E D I T -------------------------------------------}}


                {{-------------------------------------- S E L E S A I --------------------------------------}}
                @foreach($task as $p)
                <div class="modal fade" id="selesaiTask-{{ $p->id }}" aria-labelledby="exampleModalLabel{{ $p->id }}"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content" style="padding: 15px">
                            <div class="modal-body">Yakin Menyelesaikan Task <b>{{$p->judul}}</b> ?</div>
                            <div style="margin-right: 10px;">
                                <form action="{{ route('taskKaryawan.selesai', $p->id ) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-success mx-1 mt-2" style="float: right">
                                        Ya, Selesai
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                {{----------------------------------- E N D - S E L E S A I --------------------------------------}}

                {{-------------------------------------- D E L E T E --------------------------------------}}
                @foreach($task as $p)
                <div class="modal fade" id="deleteTask-{{ $p->id }}" aria-labelledby="exampleModalLabel{{ $p->id }}"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content" style="padding: 15px">
                            <div class="modal-body">Hapus Task {{$p->user->karyawan->nama}} ?</div>
                            <div style="margin-right: 10px;">
                                <a class="btn btn-danger" href="{{ route('taskKaryawan.delete', ['id' => $p->id]) }}"
                                    style="float: right">Hapus</a>
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
