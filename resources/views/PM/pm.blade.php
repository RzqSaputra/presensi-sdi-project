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
        {{-- end navbar --}}


        {{-- ----------------------------------------- S T A R T - A D M I N -----------------------------------------}}

        <!--start container-->
        <div class="container-fluid py-4">

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
                            <h6>Data Poject Manager</h6>
                            {{-- <button id="addAdmin" class="btn  bg-gradient-dark mb-3" data-bs-toggle="modal"
                                data-bs-target="#addAdminModal">Tambah Data</button> --}}
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
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                                Email</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pm as $key => $p)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="px-2 mb-0 text-xs">{{$pm->firstItem()+$key}}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold mb-0">{{$p->email}}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold mb-0">Project Manager</span>
                                            </td>
                                            {{-- <td class="align-middle text-center">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target=" #editAdmin-{{$p->id}}">
                                            <button class="btn btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            </a>

                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#editPassword-{{ $p->id }}">
                                                <button class="btn btn-secondary">
                                                    <i class="fa fa-key"></i></button>
                                            </a>

                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#deleteAdmin-{{ $p->id }}">
                                                <button class="btn btn-danger">
                                                    <i class="fa fa-trash"></i></button>
                                            </a>
                                            </td> --}}
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                                <div class="px-3 page d-flex justify-content-between">

                                    <small style="font-weight: bold">
                                        Showing
                                        {{$pm->firstItem()}}
                                        to
                                        {{$pm->lastItem()}}
                                        of
                                        {{$pm->total()}}
                                        entries
                                    </small>
                                    {{$pm->links('pagination::bootstrap-4')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ----------------------------------------- E N D  - A D M I N -----------------------------------------}}


        {{-- ----------------------------------------- S T A R T - A D D -----------------------------------------}}

        <div class="modal fade" id="addAdminModal" aria-labelledby="addAdminLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAdminLabel">Pendaftaran Admin</h5>
                        <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pm.createPm') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" id="nama" class="form-control" autofocus required>
                                <div id="nama" class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                                <div id="email" class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                                <div id="password" class="invalid-feedback"></div>
                            </div>

                            <div style="float: right">
                                <button type="submit" class="btn btn-primary mb-2">Daftar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- ------------------------------------------- E N D - A D D -------------------------------------------}}


        {{-- ----------------------------------------- S T A R T - E D I T -----------------------------------------}}

        @foreach($pm as $p)
        <div class="modal fade" id="editAdmin-{{$p->id}}" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Pegawai</h5>
                        <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="admin/update/{{ $p->id }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Admin</label>
                                <input required type="text" name="nama" id="nama" required
                                    value="{{ old('nama') ?? $p->nama }}"
                                    class="form-control @error('nama') is-invalid @enderror">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input required type="text" name="email" id="email" required
                                    value="{{ old('email') ?? $p->email }}"
                                    class="form-control @error('email') is-invalid @enderror">
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


        {{---------------------------------------- P A S S W O R D ----------------------------------------}}

        @foreach($pm as $p)
        <div class="modal fade" id="editPassword-{{ $p->id }}" aria-labelledby="passwordLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="passwordLabel">Edit Password</h5>
                        <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="admin/passwordupdate/{{ $p->id }}" method="POST">
                            @csrf
                            <div class='mb-3'>
                                <label for="password" class="form-label">New Password</label>
                                <input type="text" name="password" id="password" class="form-control" required>
                                <div id="password" class="invalid-feedback"></div>
                            </div>

                            <div style="float: right">
                                <button type="submit" class="btn btn-primary mb-2">Update Password</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        {{----------------------------------- E N D - P A S S W O R D -----------------------------------}}



        {{-- ---------------------------------------- S T A R T - D E L E T E -----------------------------------------}}

        <!-- Delete Modal-->
        @foreach($pm as $p)
        <div class="modal fade" id="deleteAdmin-{{ $p->id }}" aria-labelledby="exampleModalLabel{{ $p->id }}"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="padding: 15px">
                    <div class="modal-body">Hapus data {{$p->nama }} ?</div>
                    <div style="margin-right: 10px;">
                        <a class="btn btn-danger" href="admin/delete/{{$p->id}}" style="float: right">Hapus</a>
                    </div>
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

    <script src="/js/admin.js"></script>
</body>

</html>
