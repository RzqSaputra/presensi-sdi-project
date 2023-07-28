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
                    <div class="container-fluid py-4">
                        <div class="col-6">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                <button class="btn bg-gradient-dark mb-3">Tambah Task</button>
                            </a>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header pb-0">
                                        <h6>Task Mingguan</h6>
                                    </div>
                                    <div class="card-body px-0 pt-0 pb-2">
                                        <div class="table-responsive p-0">
                                            <table class="table align-items-center mb-0">
                                                <thead>
                                                    <tr>
                                                        <th
                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            No</th>
                                                        <th
                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Nama Task</th>
                                                        <th
                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                                            Mulai Task</th>
                                                        <th
                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Selesai Task</th>
                                                        <th
                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Keterangan</th>
                                                        <th
                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $no = 1;
                                                    ?>
                                                    @foreach($taskM as $key => $t)
                                                    @if($t->user_id === $usr_id )
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div class="d-flex flex-column justify-content-center">
                                                                    <h6 class="px-2 mb-0 text-xs">{{$no++}}</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="align-middle text-center text-sm">
                                                            <span class="text-xs font-weight-bold mb-0">{{$t->task_mingguan }}</span>
                                                        </td>
                                                        <td class="align-middle text-center text-sm">
                                                            <span class="text-xs font-weight-bold mb-0">{{$t->waktu_mulai}}</span>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <span
                                                                class="text-secondary text-xs font-weight-bold">{{$t->waktu_selesai}}</span>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            @if ($t->status === 'Proses')
                                                                <span class= "badge rounded-pill bg-info text-white">
                                                                    Proses
                                                                </span>
                                                            @elseif($t->status === 'Sudah')
                                                                <span class="badge rounded-pill bg-success text-white">
                                                                    Sudah
                                                                </span>
                                                            @else
                                                            <span class="badge rounded-pill bg-danger text-white">
                                                                Belum
                                                            </span>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target=" #editModal-{{$t->id}}">
                                                                <button class="btn btn-warning">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                            </a>
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal-{{ $t->id }}">
                                                                <button class="btn btn-danger">
                                                                    <i class="fa fa-trash"></i></button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @else
                                                    @endif
                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{-- <small class="px-3" style="font-weight: bold">
                                                Showing
                                                {{$taskM->firstItem()}}
                                                to
                                                {{$taskM->lastItem()}}
                                                of
                                                {{$taskM->total()}}
                                                entries
                                            </small> --}}
                                            {{-- <style>
                                                .page .page-item.active .page-link {
                                                    color: white;
                                                }
                                            </style>
                                            
                                            <div class="page"
                                                style="float: right; font-weight:bold; margin-right: 50px; margin-top: 20px;">
                                                {{$taskM->links('pagination::bootstrap-4')}}
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <!--end container-->
        {{-- modal tambah data --}}
        <div class="modal fade" id="tambahModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Task</h5>
                        <button class="btn-close bg-danger" type="button" data-bs-dismiss="modal"
                            aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pegawai.tambahTaskMingguan'); }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="task_mingguan" class="form-label">Nama Task</label>
                                <input required type="text" name="task_mingguan" id="task_mingguan" value="{{ old('task_mingguan') }}"
                                    class="form-control @error('task_mingguan') is-invalid @enderror">
                                @error('task_mingguan')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="waktu_mulai" class="form-label">Mulai Task</label>
                                <input required type="date" name="waktu_mulai" id="waktu_mulai"
                                    value="{{ old('waktu_mulai') }}"
                                    class="form-control @error('waktu_mulai') is-invalid @enderror">
                                @error('waktu_mulai')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="waktu_selesai" class="form-label">Selesai Task</label>
                                <input required type="date" name="waktu_selesai" id="waktu_selesai"
                                    value="{{ old('waktu_selesai') }}"
                                    class="form-control @error('waktu_selesai') is-invalid @enderror">
                                @error('waktu_selesai')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">status</label>
                                <select name="status" id="status" class="form-control" value="{{ old('status') }}">
                                    <option disabled>-- Pilih status --</option>
                                    @foreach ($status as $st)
                                    <option value="{{ $st['value'] }}">{{ $st['label'] }}</option>
                                    @endforeach
                                </select>
                                @error('cabang')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div style="float: right">
                                <button type="submit" class="btn btn-primary mb-2">Tambah Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- end modal tambah data --}}

        {{-- modal edit data --}}
        @foreach($taskM as $t)
        <div class="modal fade" id="editModal-{{$t->id}}" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit task</h5>
                        <button class="btn-close bg-danger" type="button"
                            data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/taskM/update/{{ $t->id }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="task_mingguan" class="form-label">Nama Task</label>
                                <input type="text" name="task_mingguan" id="task_mingguan"
                                    value="{{ old('task_mingguan') ?? $t->task_mingguan }}"
                                    class="form-control @error('task_mingguan') is-invalid @enderror">
                                @error('task_mingguan')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="waktu_mulai" class="form-label">Mulai Task</label>
                                <input type="date" name="waktu_mulai" id="waktu_mulai"
                                    value="{{ old('waktu_mulai') ?? $t->waktu_mulai }}"
                                    class="form-control @error('waktu_mulai') is-invalid @enderror">
                                @error('waktu_mulai')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="waktu_selesai" class="form-label">Selesai Task</label>
                                <input type="date" name="waktu_selesai" id="waktu_selesai"
                                    value="{{ old('waktu_selesai') ?? $t->waktu_selesai }}"
                                    class="form-control @error('waktu_selesai') is-invalid @enderror">
                                @error('waktu_selesai')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Keterangan</label>
                                <select name="status" id="status" class="form-control" value="{{ old('status') }}">
                                    <option disabled>--- Pilih Keterangan ---</option>
                                    @foreach ($status as $st)
                                    <option
                                        value="{{ $st['value'] }}"
                                        {{  $t->status === $st['value'] ? 'selected' : '' }}>{{ $st['label'] }}</option>
                                    @endforeach
                                </select>
                                @error('cabang')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div style="float: right">
                                <button type="submit"
                                    class="btn btn-primary mb-2">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        {{-- end modal edit data --}}

        {{-- modal delete --}}
            @foreach($taskM as $t)
            <div class="modal fade" id="deleteModal-{{ $t->id }}"
                aria-labelledby="exampleModalLabel{{ $t->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content" style="padding: 15px">
                        <div class="modal-body">Hapus data {{$t->task_mingguan }} ?</div>
                        <div style="margin-right: 10px;">
                            <a class="btn btn-danger" href="/taskM/delete/{{$t->id}}"
                                style="float: right">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        {{-- end modal delete --}}

        {{-- footer --}}
        @include('template.footer')
        {{-- end footer --}}
        </div>
    </main>
    <!--   Core JS Files   -->
    @include('template.script')

</body>

</html>
