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

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mt-4">

                    @if (session()->has('msg'))
                    <div class="alert alert-success" style="color:white;">
                        {{ session()->get('msg') }}
                        <div style="float: right">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                    <div class="col-md-12">
                        <div class="card h-100 mb-4">
                            <div class="card-header pb-0 px-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-0 font-weight-bolder text-lg">Task</h6>
                                    </div>
                            </div>
                        </div>
                        <div class="card-body pt-4 p-3">
                            <ul class="list-group">

                                @if ($tasksHarian->isEmpty())
                                <li
                                    class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 mx-2 border-radius-lg">
                                    Tidak ada task untuk anda
                                </li>

                                @endif

                                @foreach ($tasksHarian as $task)
                                <li
                                    class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 mx-2 border-radius-lg">
                                    <div class="d-flex align-items-center">
                                        @if ($task->status == 1)
                                        <div
                                            class="btn btn-icon-only btn-rounded btn-outline-warning mb-0 me-3 btn-lg d-flex align-items-center justify-content-center">
                                            <i class="fas fa-hourglass-end"></i>
                                        </div>
                                        @elseif ($task->status == 2)
                                        <button
                                            class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-lg d-flex align-items-center justify-content-center">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        @endif
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0 text-dark text-md font-weight-bolder">{{ $task->judul }}
                                            </h6>
                                            <span class="text-xs">{{ $task->deskripsi }}</span>
                                            <span class="text-xxs"><i>Created at {{$task->mulai}}</i></span>
                                        </div>
                                    </div>
                                    <div class="ms-auto text-end">
                                        @if($task->status == 1)
                                        
                                        <a href="{{ route('detailtask.lapor', $task->id) }}"
                                            class="btn btn-link text-dark px-3 mb-0">
                                            <i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>
                                            Lapor Kegiatan
                                        </a>

                                        @else
                                        <button class="btn btn-link text-primary px-3 mb-0" data-bs-toggle="modal"
                                            data-bs-target="#viewTask-{{$task->id}}">
                                            <i class="fa fa-eye me-2" aria-hidden="true"></i>
                                            View
                                        </button>
                                        @endif
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>

        <!-- ----------------------------------------- S T A R T - A D D ----------------------------------------->
        {{-- <div class="modal fade" id="addPresensiModal" data-bs-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPresensiLabel">Tambah Task</h5>
                        <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('task.create')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" name="judul" id="judul" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"
                                    required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="jenis" class="form-label">jenis</label>
                                <select name="jenis" id="jenis" class="form-control" required>
                                    <option value="">-- Pilh Jenis --</option>
                                    <option value="1">Harian</option>
                                    <option value="2">Mingguan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="foto" class="form-label">Dokumen</label>
                                <input type="file" name="foto" class="form-control" id="foto">
                            </div>

                            <div style="float: right">
                                <button type="submit" class="btn btn-primary mb-2">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
        <!---------------------------------------------- E N D - A D D -------------------------------------------->


        <!-- ----------------------------------------- S T A R T - E D I T ----------------------------------------->
        {{-- @foreach($tasksHarian as $task)
        <div class="modal fade" id="editTask-{{$task->id}}" data-bs-backdrop="static" data-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPresensiLabel">Edit Task</h5>
                        <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('task.edit', $task->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" name="judul" id="judul" class="form-control" value="{{$task->judul}}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"
                                    required>{{$task->deskripsi}}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="jenis" class="form-label">jenis</label>
                                <select name="jenis" id="jenis" class="form-control" required>
                                    <option value="1" {{ $task->jenis == 1 ? 'selected' : '' }}>Harian</option>
                                    <option value="2" {{ $task->jenis == 2 ? 'selected' : '' }}>Mingguan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <a href="{{ asset('storage/task/'.$task->foto) }}">
                                    <img src="{{ asset('storage/task/'.$task->foto) }}" alt="Task Image"
                                        style="max-width: 50%; height: auto;">
                                </a>
                            </div>

                            <div class="mb-3">
                                <label for="foto" class="form-label">Ganti Foto</label>
                                <input type="file" name="foto" class="form-control" id="imageInput">
                            </div>

                            <div style="float: right">
                                <button type="submit" class="btn btn-primary mb-2">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach --}}
        <!-- ------------------------------------------- E N D - E D I T ------------------------------------------->


        <!-- ----------------------------------------- S T A R T - V I E W ------------------------------------------->
        @foreach($tasksHarian as $task)
        <div class="modal fade" id="viewTask-{{ $task->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center mt-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 6rem;"></i>
                        </div>
                        <hr>
                        <p class="text-center font-weight-bolder h3">{{ $task->judul }} Telah anda selesaikan, Terimakasih atas kontribusi anda</p>
                        <p class="text-center mx-3">{{ $task->deskripsi }} </p>
                        {{-- <a href="{{ asset('storage/task/'.$task->foto) }}">
                            <img src="{{ asset('storage/task/'.$task->foto) }}" alt="Task Image"
                                style="max-width: 100%; height: auto;">
                        </a> --}}
                    </div>
                    <div class="text-end mx-4 mt-2 mb-3">
                        <i>Created at {{$task->mulai}}<br>Completed at {{$task->selesai}}</i>
                    </div>
                    <div class="text-end mx-4 mb-3">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <!-- ------------------------------------------- E N D - V I E W ------------------------------------------->

        <!--Footer -->
        @include('template.footer')
        <!-- End Footer -->

    </main>
    <!-- Core JS Files -->
    @include('template.script')

</body>

</html>
