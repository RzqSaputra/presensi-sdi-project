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
                <form method="POST" action="
                @if(!isset($presensi))
                {{ route('presensi.masuk')}}
                @else
                {{ route('presensi.pulang',$presensi->id)}}
                @endif
                ">
                    @csrf
                    <div class="p-5 bg-white rounded-3">
                        <div class="d-flex justify-content-center">
                            <h5 class="font-weight-bolder me-3 bag">
                                @if(!isset($presensi))
                                Presensi Masuk
                                @else
                                @if(!isset($presensi->jam_pulang ) && $status!="Izin")
                                Presensi Keluar
                                @else
                                Terima Kasih Sudah Melakukan Presensi Hari Ini :)
                                @endif
                                @endif
                            </h5>
                            <br>
                        </div>
                        <small class="d-flex justify-content-center pb-2 text-danger" id="presensi-info"></small>

                        @if(!isset($presensi->jam_pulang) && $status!="Izin")
                        @if(isset($presensi)){{ method_field('PUT') }}@endif
                        <input type="hidden" name="image" class="image-tag">
                        <input type="hidden" name="lokasi" value="" id="lokasi">
                        <div class="text-center">
                            <div id="my_camera" class="bg-secondary mb-3 d-inline-block" style="height:300px; width: 400px">
                            </div>
                            <br />
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="">
                                    <button class="btn btn-primary" type=button onClick="startCamera(this)">Start
                                        Camera</button>
                                    <button id="btn-presensi" class="btn btn-success">Presensi</button>
                                </div>
                            </div>
                            @if (!isset($presensi->jam_masuk))
                            <div class="form-check d-inline-flex">
                                <input class="form-check-input" onchange="showKet()" type="checkbox" value="izin"
                                    name="izin" id="izin">
                                <label class="form-check-label" for="izin">
                                    Izin
                                </label>
                            </div>
                            @endif
                            <div class="col-md-6 offset-3">
                                <textarea class="form-control" id="ket" name="ket" rows="2"
                                    placeholder="Keterangan"></textarea>
                            </div>
                        </div>
                        @endif
                    </div>
                </form>
            </div>
        <!--end container-->

        <!--  Footer -->
        @include('template.footer')
        <!-- End Footer -->
    </main>

    <!--   Core JS Files   -->
    @include('template.script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <script language="JavaScript">
        $('#btn-presensi').hide();
        $('#ket').hide();

        @if(!isset($presensi->jam_masuk))
        let izin;
            
        function currentTime() {
            let date = new Date();
            let hh = date.getHours();
            let hh2 = date.getHours();
            let mm = date.getMinutes();
    
            hh = (hh < 10) ? "0" + hh : hh;
            mm = (mm < 10) ? "0" + mm : mm;

            const masuk = new Date('2020-01-01 08:00');
            let sekarang = new Date('2020-01-01 '+ hh + ":" + mm);

            if (masuk.getTime() < sekarang.getTime()) {
                let late = ((hh2-8 > 0) ? (hh2-=8)  + "Jam " : null) + mm +"Menit"
                document.getElementById("presensi-info").innerHTML = "Telat " + late;
            }

            let t = setTimeout(function () {
                currentTime()
            }, 6000);
        }
        
        currentTime();
        function showKet() {
            izin = !izin;
            if(izin){
                $("#ket").show();
                $("#ket").attr("required","true");
            }else{
                $("#ket").hide();
                $("#ket").removeAttr("required");
            }
        }
        @endif
       
        function startCamera(btn) {
            Webcam.set({
            width: 400,
            height: 300,
            image_format: 'jpeg',
            jpeg_quality: 50
            });
    
            Webcam.attach( '#my_camera' );
            btn.setAttribute('onclick','take_snapshot(this)');
            btn.innerHTML = 'Take Picture';
            $('#btn-presensi').hide();
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position)=>{
                    $('#lokasi').val(position.coords.latitude+","+position.coords.longitude)
                });
            } else { 
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }
        
        function take_snapshot(btn) {
            Webcam.snap( function(data_uri) {
                $(".image-tag").val(data_uri);
                document.getElementById('my_camera').innerHTML = '<img src="'+data_uri+'" />';
            } );
            btn.setAttribute('onclick','startCamera(this)');
            btn.innerHTML = 'Retake'
            $('#btn-presensi').show();
        }
    </script>

</html>