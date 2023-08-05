<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
    data-scroll="false">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-white active text-capitalize" aria-current="page">
                    {{ str_replace('.', ' ', Route::currentRouteName()) }}</li>
            </ol>
            <h6 class="font-weight-bolder text-white text-capitalize mb-0">
                {{ str_replace('.', ' ',  Route::currentRouteName()) }}</h6>
        </nav>
    </div>
    <div class="container-fluid py-1 px-3 justify-content-end">
        <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <button type="button" class="btn btn-danger mt-3">Logout</button>
        </a>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="padding: 15px">
                <div class="modal-body">Apakah anda yakin untuk logout?</div>
                <div style="margin-right: 10px;">
                    @if (auth()->user())
                    <form action="{{ route('auth.logout') }}" method="post">
                        @csrf
                        <button class="btn btn-danger" style="float: right">Logout</button>
                    </form>
                    @else
                    <h1>Tidak Ada Session</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
    <!--end logout modal-->

</nav>
