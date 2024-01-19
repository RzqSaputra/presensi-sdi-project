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
        <div class="container-fluid">
            <div class="container-fluid py-2">
                <div class="row">
                    <div class="col-md-8">
                        @if(session()->has('pesan'))
                        <div class="alert alert-success" style="color:white;">
                            {{ session()->get('pesan')}}
                            <div style="float: right">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                        @endif
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="row">
                                    <form action="{{ route('dataPresensi.update', ['id' => $detail->id]) }}"
                                        method="POST">
                                        @csrf
                                        <div class="col">
                                            <button class="btn btn-success btn-sm" id="editButton">Save</button>
                                        </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Nama</label>
                                            <input id="namaInput" class="form-control" type="text" disabled
                                                value="{{$detail->user->karyawan->nama}}">
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">NIP</label>
                                            <input class="form-control" type="email" disabled
                                                value="{{$detail->user->karyawan->nip}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Jabatan</label>
                                            <input class="form-control" type="text" disabled
                                                value="{{$detail->user->karyawan->jabatan->jabatan}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Tanggal
                                                Presensi</label>
                                            <input name="tgl_presensi" id="tgl_presensi" class="form-control"
                                                type="date" required value="{{$detail->tgl_presensi}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input"
                                                class="form-control-label">Status</label><br>
                                            @if ($detail->status == 1)
                                            <input name="ket" id="keterangan" class="form-control" type="text" required
                                                value="Masuk" disabled>
                                            @elseif ($detail->status == 2)
                                            <input name="ket" id="keterangan" class="form-control" type="text" required
                                                value="Izin" disabled>
                                            @elseif ($detail->status == 3)
                                            <input name="ket" id="keterangan" class="form-control" type="text" required
                                                value="Sakit" disabled>
                                            @elseif ($detail->status == 4)
                                            <input name="ket" id="keterangan" class="form-control" type="text" required
                                                value="Alpa" disabled>
                                            @else
                                            <span
                                                class="text-white text-xs font-weight-bold bg-secondary badge rounded-pill">
                                                N/A
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input"
                                                class="form-control-label">Keterangan</label>
                                            <input name="ket" id="keterangan" class="form-control" type="text" required
                                                value="{{$detail->ket}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Jam Masuk</label>
                                            <input name="jam_masuk" id="jam_masuk" class="form-control" type="time"
                                                required value="{{$detail->jam_masuk}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-start">
                                            <label class="form-control-label">
                                                Lokasi Presensi Masuk
                                            </label>
                                        </div>
                                        <a href="https://www.google.com/maps/place?q={{ urlencode($detail->lokasi_masuk) }}"
                                            target="_blank">
                                            <button type="button" class="btn btn-sm btn-primary">Lihat
                                                <i class="fa fa-map-marker"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Jam
                                                Pulang</label>
                                            <input name="jam_pulang" id="jam_pulang" class="form-control" type="time"
                                                required value="{{$detail->jam_pulang}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-start">
                                            <label class="form-control-label">
                                                Lokasi Presensi Pulang
                                            </label>
                                        </div>
                                        <a href="https://www.google.com/maps/place?q={{ urlencode($detail->lokasi_pulang) }}"
                                            target="_blank">
                                            <button type="button" class="btn btn-sm btn-primary">Lihat
                                                <i class="fa fa-map-marker"></i>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-profile mb-4">
                            <a href="{{ asset('storage/presensi/masuk-' . $detail->foto_masuk) }}">
                                <div class="bg-secondary text-center card-img-top"
                                    style="height: 400px; display: flex; align-items: center; justify-content: center;">
                                    <img id="profileImage"
                                        src="{{ asset('storage/presensi/masuk-' . $detail->foto_masuk) }}"
                                        alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </a>
                            <h5 class="font-weight-bolder text-center my-3">Check-in</h5>
                        </div>
                        <div class="card card-profile">
                            <a href="{{ asset('storage/presensi/pulang-' . $detail->foto_pulang) }}">
                                <div class="bg-secondary text-center card-img-top"
                                    style="height: 400px; display: flex; align-items: center; justify-content: center;">
                                    <img id="profileImage"
                                        src="{{ asset('storage/presensi/pulang-' . $detail->foto_pulang) }}"
                                        alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </a>
                            <h5 class="font-weight-bolder text-center my-3">Check-Out</h5>
                        </div>
                    </div>

                </div>
                <!-- End Body -->

                <!-- Footer -->
                @include('template.footer')
                {{-- End Footer --}}

            </div>
    </main>

    <!--   Core JS Files   -->
    @include('template.script')

</html>
