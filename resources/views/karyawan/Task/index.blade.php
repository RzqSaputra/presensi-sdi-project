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

        <!--start container-->
        <div class="container-fluid">
            <div class="container-fluid mt-3">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between">
                        <h4 class="pb-3 text-white">Task Harian</h4>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#tambahModal">
                            <button class="btn bg-gradient-dark mb-3">Tambah Task</button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="container-fluid" style="margin-left: -20px;">
                <div class="row d-flex justify-content-center">
                    @foreach ($task as $t)
                    <div class="card col-md-2  mb-4" style="word-break: break-all;">
                        <h5 class="card-title mt-4 ms-4">
                            @if ($t->status === 'Proses')
                            {{ $t->judul }}
                            @else
                            <del>{{ $t->judul }}</del>
                            @endif
                        </h5>
                        <div class="card-subtitle mt-1 mx-4">
                            <div class="card-text mb-4">
                                <div class="float-start">
                                    @if ($t->status === 'Proses')
                                    {{ $t->deskripsi }}
                                    @else
                                    <del>{{ $t->deskripsi }}</del>
                                    @endif
                                    <br>
                                    @if ($t->status === 'Proses')
                                    <span class="badge rounded-pill bg-info text-white">
                                        Proses
                                    </span>
                                    @else
                                    <span class="badge rounded-pill bg-success text-white">
                                        Selesai
                                    </span><br>
                                    @endif
                                    <small>Last Updated -
                                        {{ \Carbon\Carbon::parse($t->created_at)->diffForHumans() }}
                                        | Di Buat Pada
                                        {{$t->waktu_mulai}}
                                    </small>
                                </div>
                                <div class="float-end">
                                    <td class="align-middle text-center">
                                        <a href="#" data-bs-toggle="modal" data-bs-target=" #editModal-{{$t->id}}">
                                            <button class="btn btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </a>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $t->id }}">
                                            <button class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </a>
                                    </td>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

<div class="row float-end">
    <p class="mr-5">View More</p>
</div>



            @if (count($task)===0)
            <div class="alert alert-danger p-2">
                <p class="text-white text-center">
                    Tidak ada Task
                </p>
                <div class="text-center">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#tambahModal">
                        <button class="btn bg-gradient-dark mb-3">
                            <i class="fa fa-plus"></i>
                        </button>
                    </a>
                </div>
            </div>
            @endif
            {{-- modal tambah data --}}
            <div class="modal fade" id="tambahModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Task</h5>
                            <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="card card-body p-4">
                            <form action="" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul</label>
                                    <input type="text" class="form-control" id="judul" name="judul">
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" value="deskripsi"
                                        class="form-control @error('deskripsi') is-invalid @enderror"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        {{-- @foreach ($status as $st)
                                                    <option value="{{ $st['value'] }}">{{ $st['label'] }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">
                                    Simpan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end modal tambah data --}}

            {{-- modal edit data --}}
            @foreach($task as $t)
            <div class="modal fade" id="editModal-{{$t->id}}" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit task</h5>
                            <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/task/update/{{ $t->id }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Nama Task</label>
                                    <input type="text" name="judul" id="judul" value="{{ old('judul') ?? $t->judul }}"
                                        class="form-control @error('judul') is-invalid @enderror">
                                    @error('judul')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea type="text" name="deskripsi" id="deskripsi"
                                        value="{{ old('deskripsi') ?? $t->deskripsi }}"
                                        class="form-control @error('deskripsi') is-invalid @enderror">{{$t->deskripsi}}</textarea>
                                    @error('deskripsi')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Keterangan</label>
                                    <select name="status" id="status" class="form-control" value="{{ old('status') }}">
                                        {{-- @foreach ($status as $st)
                                                    <option
                                                        value="{{ $st['value'] }}"
                                        {{  $t->status === $st['value'] ? 'selected' : '' }}>{{ $st['label'] }}
                                        </option>
                                        @endforeach --}}
                                    </select>
                                    @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
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
            {{-- end modal edit data --}}

            {{-- modal delete --}}
            @foreach($task as $t)
            <div class="modal fade" id="deleteModal-{{ $t->id }}" aria-labelledby="exampleModalLabel{{ $t->id }}"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content" style="padding: 15px">
                        <div class="modal-body">Hapus data
                            {{$t->judul }}
                            ?</div>
                        <div style="margin-right: 10px;">
                            <a class="btn btn-danger" href="/task/delete/{{$t->id}}" style="float: right">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            {{-- end modal delete --}}
            <!--end container-->
            {{-- footer --}}
            @include('template.footer')
            {{-- end footer --}}
        </div>
    </main>
    <!-- Core JS Files -->
    @include('template.script')

</body>

</html>
