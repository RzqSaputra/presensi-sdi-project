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


        <!-- Body -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <!-- Gambar Profil -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal">
                            <div class="bg-secondary text-center card-img-top"
                                style="height: 400px; display: flex; align-items: center; justify-content: center;">
                                <img id="profileImage" src="{{ asset('FotoProfile/' . $presensi->karyawan->foto) }}"
                                    alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </a>

                        <!-- Tombol "Change Profile" untuk membuka modal -->
                        <div class="card-body text-center">
                            <h4>{{ $presensi->karyawan->nama }}</h4>
                            <p>{{ $presensi->karyawan->jabatan->jabatan }}</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#uploadModal-{{ $presensi->karyawan->id }}">Change Profile</button>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="uploadModal-{{ $presensi->karyawan->id }}" tabindex="-1"
                    aria-labelledby="uploadModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="uploadModalLabel">Change Profile</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Form untuk mengunggah gambar -->
                                <form
                                    action="{{ route('karyawan.image', ['id' => $presensi->karyawan->user_id]) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="file" name="image" class="form-control" id="imageInput">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    @if(session()->has('pesan'))
                    <div class="alert alert-success" style="color:white;">
                        {{ session()->get('pesan')}}
                        <div style="float: right">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                
                                <form action="{{route('Karyawan.update', ['id' => $presensi->id])}}" method="POST">
                                    @csrf
                                    <div class="col">
                                    <button class="btn btn-success btn-sm" id="editButton">Save</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">User Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Nama</label>
                                        <input name="nama" id="nama" class="form-control" type="text"
                                            value="{{$presensi->karyawan->nama}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">NIP</label>
                                        <input name="nip" id="nip" class="form-control" type="number"
                                            value="{{$presensi->karyawan->nip}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Jenis Kelamin</label>
                                        <select name="jenkel" id="jenkel" class="form-control" required>
                                            <option value="1"
                                                {{ optional($presensi->karyawan)->jenkel == 1 ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="2"
                                                {{ optional($presensi->karyawan)->jenkel == 2 ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Tanggal Lahir</label>
                                        <input name="tgl_lahir" id="tgl_lahir" class="form-control" type="date"
                                            value="{{$presensi->karyawan->tgl_lahir}}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Jabatan</label>
                                        <select name="jabatan_id" id="jabatan" class="form-control">
                                            @foreach ($jabatan as $j)
                                            <option value="{{ $j->id }}"
                                                {{ $presensi->jabatan_id == $j->id ? 'selected' : '' }}>
                                                {{ $j->jabatan }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">No Telepon</label>
                                        <input name="no_tlp" id="no_tlp" class="form-control" type="number"
                                            value="{{$presensi->karyawan->no_tlp}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Alamat</label>
                                        <input name="alamat" id="alamat" class="form-control" type="text"
                                            value="{{$presensi->karyawan->alamat}}">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Account Information</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email</label>
                                        <input name="email" id="email" class="form-control" type="text"
                                            value="{{$presensi->email}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Password</label><br>
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#editPassword-{{ $presensi->id }}">
                                            <button class="btn btn-info">Change Password</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Body -->

            {{---------------------------------------- P A S S W O R D ----------------------------------------}}

            <div class="modal fade" id="editPassword-{{ $presensi->id }}" aria-labelledby="editPasswordLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="passwordLabel">Change Password</h5>
                            <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('karyawan.password', ['id' => $presensi->id]) }}" method="POST"
                                onsubmit="return validatePassword()">
                                @csrf
                                <div class='mb-3'>
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>

                                <div class='mb-3'>
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password"
                                        class="form-control" required>
                                    <div id="passwordMismatch" class="invalid-feedback"
                                        style="display: none; color: red;">
                                    </div>
                                </div>
                                <div style="float: right">
                                    <button type="submit" class="btn btn-primary mb-2">Update Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            {{----------------------------------- E N D - P A S S W O R D -----------------------------------}}

            <!-- Footer -->
            @include('template.footer')
            {{-- End Footer --}}

        </div>
    </main>
    <!--   Core JS Files   -->
    @include('template.script')

    <script>
        function validatePassword() {
            var newPassword = document.getElementById('password').value;
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
</body>

</html>
