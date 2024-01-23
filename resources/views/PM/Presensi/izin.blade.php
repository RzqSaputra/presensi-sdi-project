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

        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4">Input File Izin</h5>
                            <form method="POST" action="{{route('presensiPM.uploadizin')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="lokasi" value="" id="lokasi">
                                <div class="form-group">
                                    <label for="file">Pilih File:</label>
                                    <input type="file" class="form-control" name="file[]" id="file" multiple>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan:</label>
                                    <textarea class="form-control" name="keterangan" id="keterangan"
                                        ></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mulai">Mulai</label>
                                            <input type="time" class="form-control" name="mulai" id="mulai" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="selesai">Selesai</label>
                                            <input type="time" class="form-control" name="selesai" id="selesai"
                                                value="16:00" step="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End container-->

        <!--  Footer -->
        @include('Template.footer')
        <!-- End Footer -->
    </main>

    <!--   Core JS Files   -->
    @include('template.script')
    <script>
        var jamAwalInput = document.getElementById('mulai');

        function getCurrentTime() {
            var now = new Date();
            var hours = now.getHours().toString().padStart(2, '0');
            var minutes = now.getMinutes().toString().padStart(2, '0');
            var seconds = now.getSeconds().toString().padStart(2, '0');
            return hours + ':' + minutes + ':' + seconds;
        }

        // Fungsi untuk memperbarui nilai input jam_awal setiap detik
        function updateJamAwal() {
            jamAwalInput.value = getCurrentTime();
        }

        // Panggil fungsi updateJamAwal setiap detik (1000ms)
        setInterval(updateJamAwal, 1000);

        // Panggil updateJamAwal untuk pertama kali
        updateJamAwal();

        var url = window.location.pathname;
        var filename = url.substring(url.lastIndexOf('/') + 1);
        if (filename === 'masuk' || filename === 'sakit' || filename == 'izin') {
            $('#collapseThree').addClass('show');
            $('#collapseThree').addClass('in');
        } else {
            $('#collapseThree').removeClass('show');
            $('#collapseThree').removeClass('in');
        }

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                $('#lokasi').val(position.coords.latitude + "," + position.coords.longitude);
            });
        }
    </script>
</body>

</html>
