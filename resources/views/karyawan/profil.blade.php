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
            <div class="col-12">
                @if(session()->has('pesan'))
                <div class="alert alert-success" style="color:white;">
                    {{ session()->get('pesan')}}
                    <div style="float: right">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                @endif
            </div>

            <div class="row">

                <div class="col-md-12">
                    <form action="{{ route('PUpdate',Auth::user()->id) }}" method="POST" enctype="multipart/form-data"
                        id="PegawaiInfoForm">
                        @csrf
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        @if (!Auth::user()->pegawai->foto == '')
                                        <img class="profile-user-img img-fluid img-circle pegawai_image"
                                            src="/users/images/{{Auth::user()->pegawai->foto}}" alt="profil pegawai"
                                            width="225" style="border-radius: .5rem;">
                                        @else
                                        <center>
                                        <div class="bg-secondary text-center"
                                            style="width: 225px;height: 225px;border-radius: .5rem">
                                        </div>
                                        </center>
                                        @endif
                                    </div>
                                    <h3 class="profile-username text-center">{{Auth::user()->nama}}</h3>
                                    <p class="text-muted text-center">Pegawai</p>
                                    <input type="file" name="file" id="file" style="opacity: 0;height:1px;display:none">
                                    <a href="javascript:void(0)" class="btn btn-primary btn-block "
                                        id="change_picture_btn"><b>Ubah Profil</b></a>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama" class="form-control-label">Nama</label>
                                            <input class="form-control" type="text" value="{{ Auth::user()->nama }}"
                                                name="nama">
                                            <span class="text-danger error-text nama_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nip" class="form-control-label">NIP</label>
                                            <input class="form-control" type="number"
                                                value="{{ Auth::user()->pegawai->nip }}" name="nip">
                                            <span class="text-danger error-text nip_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tgl_lahir" class="form-control-label">Tanggal
                                                Lahir</label>
                                            <input class="form-control" type="date"
                                                value="{{ Auth::user()->pegawai->tgl_lahir }}" name="tgl_lahir">
                                            <span class="text-danger error-text tgl_lahir_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="j_k" class="form-control-label">Jenis
                                                Kelamin</label>
                                            <select class="form-control" name="j_k" id="j_k">
                                                <option value="0" disabled>-- Pilih Jenis Kelamin --</option>
                                                <option value="1" {{Auth::user()->jk == 1 ?'selected':null}}>Laki-laki
                                                </option>
                                                <option value="2" {{Auth::user()->jk == 2 ?'selected':null}}>Perempuan
                                                </option>
                                            </select>
                                            <span class="text-danger error-text j_k_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">no Hp</label>
                                            <input class="form-control" type="tel"
                                                value="{{ Auth::user()->pegawai->no_tlp }}" name="no_tlp">
                                            <span class="text-danger error-text no_tlp_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-control-label">Email</label>
                                            <input class="form-control" type="text" value="{{ Auth::user()->email }}"
                                                name="email">
                                            <span class="text-danger error-text email_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Alamat</label>
                                            <textarea class="form-control" name="alamat" id="alamat" 
                                                rows="3">{{ Auth::user()->pegawai->alamat }}</textarea>
                                            <span class="text-danger error-text alamat_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">Update</button>
                            </div>
                        </div>
                    </form>

                    <form action="{{route('profil.updatePassword')}}" method="POST" enctype="multipart/form-data"
                        id="PegawaiInfoForm">
                        {{-- @method('PUT') --}}
                        @csrf
                        <div class="card my-3">
                            <p class="m-3 text-dark">Ubah Kata Sandi</p>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="current_password" class="form-control-label">Kata Sandi Saat Ini</label>
                                            <input class="form-control" type="password"
                                                name="current_password">
                                                @error('current_password')
                                                <span class="text-danger error-text">{{$message}}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password" class="form-control-label">Kata Sandi Baru</label>
                                            <input class="form-control" type="password"
                                                name="password">
                                                @error('password')
                                                <span class="text-danger error-text">{{$message}}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation" class="form-control-label">Konfirmasi Password</label>
                                            <input class="form-control" type="password"
                                                name="password_confirmation">
                                                @error('password_confirmation')
                                                <span class="text-danger error-text">{{$message}}</span>
                                                @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">Ubah Kata Sandi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <!--end container-->
        {{-- footer --}}
        @include('template.footer')
        {{-- end footer --}}
        </div>
    </main>
    <!--   Core JS Files   -->
    @include('template.script')
    <script src="{{asset('/plugins\ijaboCropTool\ijaboCropTool.min.js')}}"></script>

    <script>
    $.ajaxSetup({
            headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $(document).on('click','#change_picture_btn', function(){
            $('#file').click();
        });
        $('#file').ijaboCropTool({
                preview : '.pegawai_image',
                setRatio:1,
                allowedExtensions: ['jpg', 'jpeg','png'],
                buttonsText:['CROP','QUIT'],
                buttonsColor:['#30bf7d','#ee5155', -15],
                processUrl:'{{ route("crop") }}',
                withCSRF:['_token','{{ csrf_token() }}'],
                onSuccess:function(message, element, status){
                    alert(message);
                },
                onError:function(message, element, status){
                alert(message);
                }
            });   
    </script>

</body>

</html>