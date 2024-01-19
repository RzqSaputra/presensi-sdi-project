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

        {{-- --------------------------------------- S T A R T - K A R Y A W A N ----------------------------------------}}

        <!--start container-->
        <div class="container-fluid">
            <div class="row">
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
                        <button id="addPegawai" class="btn  bg-gradient-dark" data-bs-toggle="modal"
                            data-bs-target="#addPegawaiModal">Tambah Data</button>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h5 class="font-weight-bolder">Data Karyawan</h5>
                            <div class="col-md-2">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="filterNama"
                                        placeholder="Search By Name">
                                </div>
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
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                NIP</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nama</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Jabatan</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Email</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($karyawan->isEmpty())
                                        <tr>
                                            <td colspan="6" rowspan="4"
                                                class="text-center text-uppercase text-secondary text-sm py-4">
                                                TIDAK ADA DATA KARYAWAN !
                                            </td>
                                        </tr>
                                        @else

                                        @foreach($karyawan as $key => $p)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="px-2 mb-0 text-xs">
                                                            {{ $karyawan->firstItem() + $key }}</h6>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $p->karyawan->nip ?? 'N/A' }}</p>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="text-xs font-weight-bold mb-0">{{$p->karyawan->nama??'N/A'}}</span>
                                            </td>

                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">{{$p->jabatan_id 
                                                    ? $jabatan->find($p->jabatan_id)->jabatan : 'N/A'}}</span>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="text-xs font-weight-bold mb-0">{{$p->email ??' N/A'}}</span>
                                            </td>

                                            <td class="align-middle text-center">
                                                @if ($p->id > 2)
                                                <a href="{{ route('karyawan.profil', ['id' => $p->id]) }}">
                                                    <button class="btn btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#deletePegawai-{{ $p->id }}">
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
                                        Showing {{ $karyawan->count() }} of {{ $karyawan->total() }} entries
                                    </small>
                                    {{ $karyawan->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- --------------------------------------- E N D  - P E G A W A I -----------------------------------------}}


        {{-- ----------------------------------------- S T A R T - A D D -----------------------------------------}}

        <div class="modal fade" id="addPegawaiModal" aria-labelledby="addPegawaiLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPegawaiLabel">Penambahan Data Karyawan</h5>
                        <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('Karyawan.create') }}" method="POST">
                            @csrf
                            <div class='mb-3'>
                                <input type="hidden" name="id" id="id" value="">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="number" name="nip" id="nip" class="form-control" autofocus required>
                                <div id="nip-feedback" class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" id="nama" class="form-control" required>
                                <div id="nama-feedback" class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="jabatan_id" class="form-label">Jabatan</label>
                                <select name="jabatan_id" id="jabatan_id" class="form-select" required>
                                    <option value=""></option>
                                    @foreach($jabatan->where('id', '>', 1) as $j)
                                    <option value="{{ $j->id }}">{{ $j->jabatan }}</option>
                                    @endforeach
                                </select>
                                <div id="jabatan_id-feedback" class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" required>
                                <div id="tgl_lahir-feedback" class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="jenkel" class="form-label">Jenis Kelamin</label>
                                <select name="jenkel" id="jenkel" class="form-select" required>
                                    <option value=""></option>
                                    <option value="1">Laki-laki</option>
                                    <option value="2">Perempuan</option>
                                </select>
                                <div id="jenkel-feedback" class="invalid-feedback"></div>
                            </div>


                            <div class="mb-3">
                                <label for="no_tlp" class="form-label">Telepon</label>
                                <input type="number" name="no_tlp" id="no_tlp" class="form-control" required>
                                <div id="no_tlp-feedback" class="invalid-feedback"></div>
                            </div>

                            <div class='mb-3'>
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamat" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" id="email" class="form-control" required>
                                <div id="email-feedback" class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Password</label>
                                <input type="text" name="email" id="email" class="form-control"
                                    placeholder="Passwrod123" disabled>
                                <div id="email-feedback" class="invalid-feedback"></div>
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


        {{---------------------------------------- E D I T ----------------------------------------}}

        @foreach($karyawan as $p)
        <div class="modal fade" id="editPegawai-{{$p->id}}" aria-labelledby="addPegawaiLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPegawaiLabel">Edit Data Karyawan</h5>
                        <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="update/{{ $p->id }}" method="POST">
                            @csrf
                            <div class='mb-3'>
                                <label for="nip" class="form-label">NIP</label>
                                <input type="number" name="nip" id="nip" class="form-control" required
                                    value="{{ old('nip') ?? optional($p->karyawan)->nip }}">
                                <div id="nip-feedback" class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" id="nama" class="form-control" required
                                    value="{{ old('nama') ?? optional($p->karyawan)->nama }}">
                                <div id="nama-feedback" class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required
                                    value="{{ old('email') ?? $p->email }}">
                                <div id="email-feedback" class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" required
                                    value="{{ old('tgl_lahir') ?? optional($p->karyawan)->tgl_lahir }}">
                                <div id="tgl_lahir-feedback" class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="jenkel" class="form-label">Jenis Kelamin</label>
                                <select name="jenkel" id="jenkel" class="form-control" required>
                                    <option value="1" {{ optional($p->karyawan)->jenkel == 1 ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="2" {{ optional($p->karyawan)->jenkel == 2 ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                                <div id="jenkel-feedback" class="invalid-feedback"></div>
                            </div>


                            <div class="mb-3">
                                <label for="no_tlp" class="form-label">Nomor Telepon</label>
                                <input type="number" name="no_tlp" id="no_tlp" class="form-control" required
                                    value="{{ old('no_tlp') ?? optional($p->karyawan)->no_tlp }}">
                                <div id="no_tlp-feedback" class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="jabatan_id" class="form-label">Jabatan</label>
                                <select name="jabatan_id" id="jabatan_id" class="form-control" required>
                                    @foreach($jabatan->where('id', '>', 1) as $j)
                                    <option value="{{ $j->id }}" {{ $p->jabatan_id == $j->id ? 'selected' : '' }}>
                                        {{ $j->jabatan }}
                                    </option>
                                    @endforeach
                                </select>
                                <div id="jabatan_id-feedback" class="invalid-feedback"></div>
                            </div>

                            <div class='mb-3'>
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea required class="form-control" name="alamat" id="alamat" rows="3">{{ old('alamat') 
                                    ?? optional($p->karyawan)->alamat }}
                                </textarea>
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

        {{----------------------------------- E N D - E D I T  -----------------------------------}}


        {{-------------------------------------- D E L E T E --------------------------------------}}
        @foreach($karyawan as $p)
        @if ($p->karyawan)
        <div class="modal fade" id="deletePegawai-{{ $p->id }}" aria-labelledby="exampleModalLabel{{ $p->id }}"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="padding: 15px">
                    <div class="modal-body">Hapus data {{ $p->karyawan->nama }}?</div>
                    <div style="margin-right: 10px;">
                        <a class="btn btn-danger" href="delete/{{$p->id}}" style="float: right">Hapus</a>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach

        {{----------------------------------- E N D - D E L E T E --------------------------------------}}


        {{-- footer --}}
        @include('template.footer')
        {{-- end footer --}}
        </div>

    </main>
    <!--   Core JS Files   -->
    @include('template.script')

    <script>
        $(document).ready(function () {
            $('#jabatan_id').on('click', function () {
                $('option[value=""]').remove();
            });
        });

        $(document).ready(function () {
            $('#jenkel').on('click', function () {
                $('option[value=""]').remove();
            });
        });

        function validatePassword() {
            var newPassword = document.getElementById('new_password').value;
            var confirmPassword = document.getElementById('confirm_password').value;
            var passwordMismatch = document.getElementById('passwordMismatch');

            if (newPassword !== confirmPassword) {
                passwordMismatch.textContent = 'Password dan Confirm Password tidak cocok.';
                passwordMismatch.style.display = 'block';
                return false; // Mencegah pengiriman form jika password tidak cocok
            } else {
                passwordMismatch.style.display = 'none';
            }

            return true; // Mengizinkan pengiriman form jika password cocok
        }

    </script>

    <script>
        $(document).ready(function () {
            $('#filterNama').on('input', function () {
                var nama = $(this).val().toLowerCase();

                $('tbody tr').each(function () {
                    var rowNama = $(this).find('td:nth-child(3)').text().toLowerCase();

                    if (rowNama.includes(nama)) {
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
