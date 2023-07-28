<!DOCTYPE html>
<html lang="en">
@include('template.head')

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    {{-- sidebar --}}
    @include('template.sidebar')
    {{-- end sidebar --}}
    <main class="main-content position-relative border-radius-lg ">

        <!-- Navbar -->
        @include('template.navbar')
        <!-- End Navbar -->


        {{-- ----------------------------------------- S T A R T - J A B A T A N -----------------------------------------}}

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

                    <div class="d-flex justify-content-start">
                        <button id="addAdmin" class="btn  bg-gradient-dark mb-3" data-bs-toggle="modal"
                            data-bs-target="#addAdminModal">Tambah Data</button>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h5 class="font-weight-bolder">Data Jabatan</h5>
                            <div class="col-md-2">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="filterJabatan"
                                        placeholder="Search Jabatan">
                                </div>
                            </div>

                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table id="admin-table" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Jabatan</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($jabatan->isEmpty())
                                        <tr>
                                            <td colspan="6" rowspan="4"
                                                class="text-center text-uppercase text-secondary text-sm py-4 text-sm py-5 font-weight-bold">
                                                TIDAK ADA DATA JABATAN !
                                            </td>
                                        </tr>

                                        @else

                                        @foreach($jabatan as $key => $p)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="px-2 mb-0 text-xs">{{ $jabatan->firstItem() + $key }}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold mb-0">{{$p->jabatan}}</span>
                                            </td>

                                            <td class="align-middle text-center">
                                                @if ($p->id > 2)
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#editJabatan-{{$p->id}}">
                                                    <button class="btn btn-warning">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>

                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#deleteJabatan-{{ $p->id }}">
                                                    <button class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>

                                </table>
                                <div class="px-3 page d-flex justify-content-between">
                                    <small style="font-weight: bold">
                                        Showing {{$jabatan->total()}} of {{$jabatan->total()}} entries
                                    </small>
                                    {{ $jabatan->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ----------------------------------------- E N D  - J A B A T A N -----------------------------------------}}


        {{-- ----------------------------------------- S T A R T - A D D -----------------------------------------}}

        <div class="modal fade" id="addAdminModal" aria-labelledby="addJabatanLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addJabatanLabel">Tambah Jabatan</h5>
                        <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('jabatan.create') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text" name="jabatan" id="jabatan" class="form-control" autofocus required>
                                <div id="jabatan" class="invalid-feedback"></div>
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


        {{-- ----------------------------------------- S T A R T - E D I T -----------------------------------------}}

        @foreach($jabatan as $p)
        <div class="modal fade" id="editJabatan-{{$p->id}}" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Pegawai</h5>
                        <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="update/{{ $p->id }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input required type="text" name="jabatan" id="jabatan" required
                                    value="{{ old('jabatan') ?? $p->jabatan }}"
                                    class="form-control @error('jabatan') is-invalid @enderror">
                            </div>

                            <div style="float: right">
                                <button type="submit" class="btn btn-primary mb-2">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        {{-- ------------------------------------------- E N D - E D I T -------------------------------------------}}


        {{-- ---------------------------------------- S T A R T - D E L E T E -----------------------------------------}}

        @foreach($jabatan as $p)
        <div class="modal fade" id="deleteJabatan-{{ $p->id }}" aria-labelledby="exampleModalLabel{{ $p->id }}"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="padding: 15px">
                    <div class="modal-body">Hapus data {{$p->jabatan }} ?</div>
                    <div style="margin-right: 10px;">
                        <a class="btn btn-danger" href="delete/{{$p->id}}" style="float: right">Hapus</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        {{-- ------------------------------------------- E N D - D E L E T -------------------------------------------}}

        <!--end container-->
        {{-- footer --}}
        @include('template.footer')
        {{-- end footer --}}
        </div>
    </main>
    <!--   Core JS Files   -->
    @include('template.script')

    <script>
        $(document).ready(function () {
            $('#filterJabatan').on('input', function () {
                var jabatan = $(this).val().toLowerCase();

                $('tbody tr').each(function () {
                    var rowJabatan = $(this).find('td:nth-child(2)').text().toLowerCase();

                    if (rowJabatan.includes(jabatan)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });

        var url = window.location.pathname;
        var filename = url.substring(url.lastIndexOf('/') + 1);
        if (filename === 'karyawan' || filename === 'jabatan') {
            $('#collapseTwo').addClass('show');
            $('#collapseTwo').addClass('in');
        } else {
            $('#collapseTwo').removeClass('show');
            $('#collapseTwo').removeClass('in');
        }

    </script>
</body>

</html>
