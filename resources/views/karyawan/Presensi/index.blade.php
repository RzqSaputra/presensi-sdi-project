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
        <div class="container-fluid px-auto">
                <div class="p-5 bg-white rounded-3">
                    <div class="d-flex justify-content-center">
                        <h5 class="font-weight-bolder me-3 bag">
                            @if (!$presensi)
                            <p class="text-center font-weight-bolder h4 mb-3">Presensi Masuk</p>
                            <form method="POST" action="{{ route('presensi.masuk')}}" enctype="multipart/form-data">
                                @csrf
                                <small class="d-flex justify-content-center pb-2 text-danger" id="presensi-info"></small>
                                <input type="hidden" name="lokasi" value="" id="lokasi">
                                <input type="hidden" name="my_camera" class="image-tag">
                                <div class="text-center">
                                    <div id="my_camera" class="bg-secondary mb-3 d-inline-block" style="height:300px; width: 400px">
                                    </div>
                                    <br />
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="">
                                            <button class="btn btn-primary" type="button" onClick="startCamera(this)">Start Camera</button>
                                            <button id="btn-presensi" class="btn btn-success">Presensi</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            @elseif (strtotime($presensi->mulai) == strtotime($presensi->selesai) && ($presensi->status == 1 || $presensi->status == 4))
                            Presensi Pulang
                            <form method="POST" action="{{ route('presensi.pulang', $presensi->id)}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="lokasi" value="" id="lokasi">
                                <input type="hidden" name="my_camera" class="image-tag">
                                <div class="text-center">
                                    <div id="my_camera" class="bg-secondary mb-3 d-inline-block" style="height:300px; width: 400px">
                                    </div>
                                    <br />
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="">
                                            <button class="btn btn-primary" type="button" onClick="startCamera(this)">Start Camera</button>
                                            <button id="btn-presensi" class="btn btn-success">Presensi</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            @elseif (strtotime($presensi->selesai) < strtotime('16:00:00') && $presensi->status == 2)
                            Presensi Masuk
                            <form method="POST" action="{{ route('presensi.masuk')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="lokasi" value="" id="lokasi">
                                <div class="text-center">
                                    <div id="my_camera" class="bg-secondary mb-3 d-inline-block" style="height:300px; width: 400px">
                                    </div>
                                    <br />
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="">
                                            <button class="btn btn-primary" type="button" onClick="startCamera(this)">Start Camera</button>
                                            <button id="btn-presensi" class="btn btn-success">Presensi</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            @elseif ($presensi->status == 3)
                            Kami menantikan hari di mana Anda akan kembali berada di tengah-tengah kami dengan
                            semangat yang segar.
                            @else
                            "Terima kasih atas presensi Anda hari ini. Semoga Anda tetap sehat dan produktif."
                        @endif
                    </h5>
                    <br>
                </div>
            </div>
        </div>
        <!--end container-->

        <!--  Footer -->
        @include('template.footer')
        <!-- End Footer -->
    </main>

    <!--   Core JS Files   -->
    @include('template.script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <script>
        $('#btn-presensi').hide();
        $('#ket').hide();

        function currentTime() {
            let date = new Date();
            let hh = date.getHours();
            let hh2 = date.getHours();
            let mm = date.getMinutes();

            hh = (hh < 10) ? "0" + hh : hh;
            mm = (mm < 10) ? "0" + mm : mm;

            const masuk = new Date('2020-01-01 07:30');
            let sekarang = new Date('2020-01-01 ' + hh + ":" + mm);

            if (masuk.getTime() < sekarang.getTime()) {
                let late = ((hh2 - 8 > 0) ? (hh2 -= 8) + "Jam " : null) + mm + "Menit"
                document.getElementById("presensi-info").innerHTML = "Telat " + late;
            }

            let t = setTimeout(function () {
                currentTime()
            }, 6000);
        }

        currentTime();

        function startCamera(btn) {
            Webcam.set({
                width: 400,
                height: 300,
                image_format: 'jpeg',
                jpeg_quality: 50
            });

            Webcam.attach('#my_camera');
            btn.setAttribute('onclick', 'take_snapshot(this)');
            btn.innerHTML = 'Take Picture';
            $('#btn-presensi').hide();
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    $('#lokasi').val(position.coords.latitude + "," + position.coords.longitude)
                });
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function take_snapshot(btn) {
            Webcam.snap(function (data_uri) {
                $(".image-tag").val(data_uri);
                document.getElementById('my_camera').innerHTML = '<img src="' + data_uri + '" />';
            });
            btn.setAttribute('onclick', 'startCamera(this)');
            btn.innerHTML = 'Retake'
            $('#btn-presensi').show();
        }

        var url = window.location.pathname;
        var filename = url.substring(url.lastIndexOf('/') + 1);
        if (filename === 'presensi' || filename === 'sakit' || filename === 'izin') {
            $('#collapseThree').addClass('show');
            $('#collapseThree').addClass('in');
        } else {
            $('#collapseThree').removeClass('show');
            $('#collapseThree').removeClass('in');
        }

    </script>
</body>

</html>
