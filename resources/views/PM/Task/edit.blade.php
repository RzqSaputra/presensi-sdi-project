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
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h5 class="font-weight-bolder">Edit Task Karryawan</h5>
                        </div>
                        <div class="card-body px-4 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Nama</label>
                                        <input name="nama" id="nama" class="form-control" type="text"
                                            value="{{$task->user->karyawan->nama}}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Judul</label>
                                        <input name="alamat" id="alamat" class="form-control" type="text"
                                            value="{{$task->judul}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Deskripsi</label>
                                        <input name="alamat" id="alamat" class="form-control" type="text"
                                            value="{{$task->deskripsi}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Tanggal</label>
                                        <input name="alamat" id="alamat" class="form-control" type="text"
                                            value="{{$task->tgl_task}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Waktu Mulai</label>
                                        <input name="alamat" id="alamat" class="form-control" type="text"
                                            value="{{$task->waktu_mulai}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Waktu Selesai</label>
                                        <input name="alamat" id="alamat" class="form-control" type="text"
                                            value="{{$task->waktu_selesai}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Status</label>
                                        <input name="alamat" id="alamat" class="form-control" type="text"
                                            value="{{$task->status}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Foto</label>
                                        <input name="alamat" id="alamat" class="form-control" type="text"
                                            value="">
                                    </div>
                                </div>
                            </div>
                        </div>
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
</body>

</html>