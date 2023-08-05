<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="/">
            <img src="/img/logo.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-0 font-weight-bold">Sabang Digital Indonesia</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class=" w-full" id="sidenav-collapse-main">
        <ul class="navbar-nav" id="menu">
            <li class="nav-item">
                <a class="nav-link" href="/">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            @if (Auth::user()->jabatan_id == 3)
            {{-- Karyawan Menu --}}
            <li class="nav-item">
                <a class="nav-link" href="{{route('presensi.karyawan')}}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-badge text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Presensi</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('riwayatPresensi')}}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-badge text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Riwayat Presensi</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('task')}}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-collection text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Task</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="{{route('profilKaryawan')}}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profil</span>
                </a>
            </li>
            {{-- End Karyawan Menu --}}
            @else
            {{-- PM Menu --}}
            <li class="nav-item">
                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                    aria-expanded="false" aria-controls="collapseTwo">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-app text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Master Data</span>
                </a>
                <ul class="collapse flex-column ms-1" style="list-style: none; margin-top:-10px;" id="collapseTwo"
                    data-bs-parent="#menu">
                    <li style="margin-left: -30px;">
                        <a href="{{route('jabatan')}}" class="nav-link">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center d-flex align-items-center justify-content-center">
                                <i class="ni ni-app text-danger text-sm opacity-10"></i>
                            </div>
                            <span class="d-none nav-link d-sm-inline">Jabatan</span>
                        </a>
                    </li>
                    <li style="margin-left: -30px; margin-top:-20px;">
                        <a href="{{route('karyawan')}}" class="nav-link">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center d-flex align-items-center justify-content-center">
                                <i class="ni ni-app text-danger text-sm opacity-10"></i>
                            </div>
                            <span class="d-none nav-link d-sm-inline">Karyawan</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('dataPresensi')}}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-badge text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Presensi Karyawan</span>
                </a>
            </li>
           <li class="nav-item">
                <a class="nav-link" href="{{ route('taskKaryawan') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tag text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Task</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('profilPM')}}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</aside>
