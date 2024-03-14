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

        <!-- Start Container-->
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4">Input File Sakit</h5>
                            {{-- <form method="POST" enctype="multipart/form-data" action="{{route('presensiPM.uploadsakit')}}">
                                @csrf
                                <input type="hidden" name="lokasi" value="" id="lokasi">
                                <div class="form-group">
                                    <label for="file">Pilih File:</label>
                                    <input type="file" class="form-control" name="file[]" id="file" multiple required>
                                </div>
                                <div class="form-group">
                                    <label for="ket">Keterangan:</label>
                                    <textarea class="form-control" name="ket" id="ket"
                                        required></textarea>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Unggah</button>
                                </div>
                            </form> --}}

                            <form method="POST" enctype="multipart/form-data" action="{{ route('presensiPM.uploadsakit') }}">
    @csrf
    <input type="hidden" name="lokasi" value="" id="lokasi">

    <div class="form-group">
        <label for="file">Pilih File (Maksimal 2MB):</label>
        <input type="file" class="form-control" name="file[]" id="file" multiple accept=".pdf, .doc, .docx" required>
        <!-- Note: accept attribute restricts the file types that can be selected -->
    </div>

    <div class="form-group">
        <label for="ket">Keterangan:</label>
        <textarea class="form-control" name="ket" id="ket" required></textarea>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">Unggah</button>
    </div>
</form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Container-->

        <!--  Footer -->
        @include('Template.footer')
        <!-- End Footer -->

    </main>

    <!--   Core JS Files   -->
    @include('template.script')

    <script>
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                $('#lokasi').val(position.coords.latitude + "," + position.coords.longitude);
            });
        }

        var url = window.location.pathname;
        var filename = url.substring(url.lastIndexOf('/') + 1);
        if (filename === 'masuk' || filename === 'sakit' || filename === 'izin') {
            $('#collapseThree').addClass('show');
            $('#collapseThree').addClass('in');
        } else {
            $('#collapseThree').removeClass('show');
            $('#collapseThree').removeClass('in');
        }

    </script>
</body>

</html>
