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
                                    <h4 class="font-weight-bolder">Forget Password</h4>
                                    <p class="mb-0">Enter your email to reset your password.</p>
                                </div>
                                <div class="card-body">
                                    <form role="form" action="{{ route('auth.forgetpassword') }}" method="post"
                                        id="resetForm">
                                        @csrf
                                        <div class="mb-3">
                                             <small id="emailStatus" style="color: red;"></small> <!-- New element for email status -->
                                            <input type="email" class="form-control form-control-lg" placeholder="Email"
                                                aria-label="Email" name="email" id="email">
                                        </div>
                                        <div class="mb-3">
                                            <input type="number" class="form-control form-control-lg"
                                                placeholder="Nomor Whatsapp" aria-label="wa" name="wa_number"
                                                id="wa_number">
                                        </div>
                                        <div class="text-center">
                                           <button type="button" id="sendResetBtn" onclick="sendResetPassword()" class="btn btn-lg btn-primary btn-lg w-100 mt-3 mb-0" disabled>Send Reset Password</button>
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


      function sendResetPassword() {
        var email = document.getElementById('email').value;
        var waNumber = document.getElementById('wa_number').value;

       var data = {
    target: waNumber,
    message: `Halo ${email}, silahkan menuju link ini http://presensi-sdi-project.test/reset?email=${encodeURIComponent(email)} untuk mereset password kamu`,
    countryCode: '62', // optional
};

        var headers = {
            'Authorization': 'UKy6jvzGsMwAJ1PdbdpD' // Ganti YOUR_TOKEN dengan token yang valid
        };

        fetch('https://api.fonnte.com/send', {
            method: 'POST',
            headers: headers,
            body: new URLSearchParams(data),
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                // Handle the response data here
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle errors here
            });
    }

    
     document.getElementById('resetForm').addEventListener('input', function () {
        // Ambil nilai email dari input
        var email = document.getElementById('email').value;

        // Ambil tombol send reset password
        var sendResetBtn = document.getElementById('sendResetBtn');

        // Ambil elemen untuk menampilkan status email
        var emailStatus = document.getElementById('emailStatus');

        // Lakukan permintaan ke API untuk memeriksa apakah email ada
        fetch('http://presensi-sdi-project.test/api/user')
            .then(response => response.json())
            .then(data => {
                // Cek apakah email ada di API
                var isEmailExist = data.some(user => user.email === email);

                // Set pesan status email dan tampilkan atau sembunyikan
                emailStatus.innerText = isEmailExist ? '' : 'Email not registered in our system.';
                emailStatus.style.display = isEmailExist ? 'none' : 'block';

                // Aktifkan atau nonaktifkan tombol berdasarkan kondisi email
                sendResetBtn.disabled = !isEmailExist;
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle errors here
            });
    });
</script>

</html>
