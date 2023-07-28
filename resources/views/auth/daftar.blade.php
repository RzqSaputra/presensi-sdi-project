<!DOCTYPE html>
<html lang="en">
@include('template.head')

<body class="">
    <main class="main-content  pb-6">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
            style="background-image: url('https://images.pexels.com/photos/7450362/pexels-photo-7450362.jpeg?cs=srgb&dl=pexels-dids-7450362.jpg&fm=jpg'); background-position: top;">
            <span class="mask bg-gradient-dark opacity-2"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <h1 class="text-white mb-2 mt-5">Selamat Datang!</h1>
                        <p class="text-lead text-white">Silahkan register!</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-header text-center pt-4">
                            <h5>Register</h5>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" action="{{route('auth.daftar')}}" method="post" novalidate>
                                @csrf
                                <div class="mb-3">
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        placeholder="Nama" name="nama" value="{{old('nama')}}">
                                    @error('nama')
                                    <small class="invalid-feedback px-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="number" class="form-control @error('nip') is-invalid @enderror"
                                        placeholder="NIP" name="nip" value="{{old('nip')}}">
                                    @error('nip')
                                    <small class=" invalid-feedback px-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Email" name="email" value="{{old('email')}}">
                                    @error('email')
                                    <small class="invalid-feedback px-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Password" name="password">
                                    @error('password')
                                    <small class="invalid-feedback px-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        placeholder="Konfirmasi Password" name="password_confirmation">
                                    @error('password_confirmation')
                                    <small class="invalid-feedback px-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Daftar</button>
                                </div>
                                <p class="text-sm mt-3 mb-0">Sudah punya akun? <a href="login"
                                        class="text-dark font-weight-bolder">Masuk</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>