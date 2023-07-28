<script src="/assets/js/core/popper.min.js"></script>
<script src="/assets/js/core/bootstrap.min.js"></script>
<script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>

<script>
  var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }

    setTimeout(function() {
            $('.alert-success').fadeOut('slow');
        }, 1000);
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{asset('/assets/js/argon-dashboard.min.js?v=2.0.4')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
<script>
  $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
</script>
<script src="{{mix('js/main.js')}}"></script>

<script>
  // Mengambil referensi ke elemen ikon toggler dan sidenav
const iconNavbarSidenav = document.getElementById('iconNavbarSidenav');
const sidenavTogglerInner = iconNavbarSidenav.querySelector('.sidenav-toggler-inner');

// Menambahkan event listener untuk menangkap klik pada ikon toggler
iconNavbarSidenav.addEventListener('click', function() {
  // Di sini, Anda dapat menambahkan logika untuk membuka/menutup sidenav
  // Misalnya, jika sidenav tersembunyi, maka buka, dan sebaliknya.
  
  // Contoh sederhana:
  sidenavTogglerInner.classList.toggle('active'); // Menerapkan atau menghapus kelas 'active' untuk memberikan tampilan visual ketika sidenav dibuka.

  // Anda juga dapat menambahkan logika untuk memanipulasi sidenav atau elemen lainnya sesuai dengan kebutuhan Anda.
});

</script>