<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fas fa-envelope-open-text me-2"></i>SIMAS</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ asset('img/logo_fst.jpeg') }}" alt=""
                    style="width: 40px; height: 40px;">
                <div
                    class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                </div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                <span>Master</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="{{ url('/') }}" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }} "><i
                    class="fa fa-tachometer-alt me-2"></i>Dashboard</a>

            <a href="{{ url('dashboard/suratmasuk') }}"
                class="nav-item nav-link {{ (Request::is('dashboard/suratmasuk*') ? 'active' : '' || Request::is('dashboard/diteruskan*') || Request::is('dashboard/disposisi*')) ? 'active' : '' }}"><i
                    class="fa fa-envelope me-2"></i>Surat Masuk</a>

            <a href="{{ url('dashboard/suratkeluar') }}"
                class="nav-item nav-link {{ Request::is('dashboard/suratkeluar*') ? 'active' : '' }}"><i
                    class="far fa-envelope me-2"></i>Surat Keluar</a>

            <a href="{{ url('dashboard/arsip_disposisi') }}"
                class="nav-item nav-link {{ Request::is('dashboard/arsip_disposisi*') ? 'active' : '' }}"><i
                    class="fas fa-envelope-open-text me-2"></i>Disposisi Arsip</a>

            @can('kasubag')
                <a href="{{ url('/dashboard/user') }}"
                    class="nav-item nav-link {{ Request::is('dashboard/user*') ? 'active' : '' }}"><i
                        class="fas fa-users me-2"></i>User</a>
            @endcan

            @can('kasubag')
                <a href="{{ url('/dashboard/informasi') }}"
                    class="nav-item nav-link {{ Request::is('dashboard/informasi*') ? 'active' : '' }}"><i
                        class="far fa-newspaper me-2"></i>Informasi</a>
            @endcan

            @can('non_kasubag')
                <a href="{{ url('/dashboard/pengguna') }}"
                    class="nav-item nav-link {{ Request::is('dashboard/pengguna') ? 'active' : '' }}"><i
                        class="bi bi-file-earmark-text-fill me-2"></i>Surat dari KSBG</a>

                <a href="{{ url('pengguna/disposisi3') }}"
                    class="nav-item nav-link {{ Request::is('pengguna/disposisi3*') ? 'active' : '' }}"><i
                        class="fas fa-envelope-open me-2"></i>Lanjutan Disposisi</a>


                <a href="{{ url('pengguna/arsipdisposisi') }}"
                    class="nav-item nav-link {{ Request::is('pengguna/arsipdisposisi*') ? 'active' : '' }}"><i
                        class="fas fa-envelope-open me-2"></i>Arsip Disposisi</a>
            @endcan

    </nav>
</div>
