<!-- forget-password.blade.php -->

@extends('template.head')

<body>
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Reset Password</h4>
                                    <p class="mb-0">Enter your new password</p>
                                </div>
                                <div class="card-body">
                                    <form role="form" action="{{ route('auth.resetpassword') }}" method="post" id="resetForm">
                                        @csrf
                                        <!-- Tambahkan input tersembunyi untuk menyimpan email dari URL -->
                                        <input type="hidden" name="email" value="{{ request('email') }}">
                                        <div class="mb-3">
                                            <input type="password" class="form-control form-control-lg" placeholder="New Password" aria-label="New Password" name="password" id="password">
                                        </div>
                                        <div class="mb-3">
                                            <input type="password" class="form-control form-control-lg" placeholder="Confirm Password" aria-label="Confirm Password" name="password_confirmation" id="password_confirmation">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-3 mb-0">Change Password</button>
                                        </div>
                                        <div class="text-center mt-3">
                                            <a href="{{ route('auth.login') }}">Have Account</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url('https://www.getillustrations.com/packs/plastic-illustrations-scene-builder-pack/scenes/_1x/accounts%20_%20man,%20workspace,%20desk,%20laptop,%20login,%20user_md.png');
                                background-size: cover;">
                                <span class="mask bg-gradient-primary opacity-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @include('template.script')
</body>
<script>
    document.getElementById('resetForm').addEventListener('submit', function (event) {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('password_confirmation').value;

        if (password !== confirmPassword) {
            event.preventDefault();
            alert('Password and Confirm Password must match');
        }
    });
</script>

</html>
