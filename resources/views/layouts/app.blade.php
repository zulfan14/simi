<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIMI</title>

  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/avatar/simi_logo.png') }}">

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  
  <!-- Select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <!-- Datatable Jquery -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.4.1/css/dataTables.dateTime.min.css">

  <!-- Start GA -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
  </script>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="mr-auto form-inline">
          <ul class="mr-3 navbar-nav"></ul>
          <div class="search-element">
          </div>
        </form>
        <ul class="navbar-nav navbar-right">

        <li class="dropdown dropdown-list-toggle">
          <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg {{ count($notifications) > 0 ? 'beep' : '' }}">
              <i class="far fa-bell"></i>
          </a>
          <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Notifications</div>
              <div class="dropdown-list-content dropdown-list-icons">
                  @forelse ($notifications as $notification)
                      <a href="{{ route('notification.read', $notification->id) }}" class="dropdown-item dropdown-item-unread">
                          <div class="text-white dropdown-item-icon bg-primary">
                              <i class="fas fa-info-circle"></i>
                          </div>
                          <div class="dropdown-item-desc">
                              {{ $notification->message }}
                              <div class="time text-primary">{{ $notification->created_at->diffForHumans() }}</div>
                          </div>
                      </a>
                  @empty
                      <div class="p-3 text-center text-muted">
                          Tidak ada notifikasi.
                      </div>
                  @endforelse
              </div>
              <div class="text-center dropdown-footer">
                  <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
          </div>
        </li>



          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png')}}" class="mr-1 rounded-circle">
            <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="/ubah-password" class="dropdown-item has-icon">
                <i class="fa fa-sharp fa-solid fa-lock"></i> Ubah Password
              </a>
              <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                Swal.fire({
                                    title: 'Konfirmasi Keluar',
                                    text: 'Apakah Anda yakin ingin keluar?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ya, Keluar!'
                                  }).then((result) => {
                                    if (result.isConfirmed) {
                                      document.getElementById('logout-form').submit();
                                    }
                                  });">
                               <i class="fas fa-sign-out-alt"></i> {{ __('Keluar') }}
                              </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                  </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">

          <div class="sidebar-brand">
            <img alt="image" src="{{ asset('assets/img/avatar/simi_logo.png')}}" style="width: 85px !important; float:left; margin-left: 15px;">
            <!-- <a href="/" style="font-size: 40px !important; color: brown;">SIMI</a> -->
          </div>

          <ul class="sidebar-menu"> 
            @if (auth()->user()->role->role === 'user')
              <li class="sidebar-item">
                <a class="nav-link {{ Request::is('/') || Request::is('dashboard') ? 'active' : '' }}" href="/">
                  <i class="fas fa-fire"></i> <span class="align-middle">Dashboard</span>
                </a>
              </li>
  
              <li class="menu-header">LAPORAN</li>
              <li><a class="nav-link {{ Request::is('laporan-stok') ? 'active' : '' }}" href="laporan-stok"><i class="fa fa-sharp fa-reguler fa-file"></i><span>Stok</span></a></li>
              <li><a class="nav-link {{ Request::is('laporan-barang-masuk') ? 'active' : '' }}" href="laporan-barang-masuk"><i class="fa fa-regular fa-file-import"></i><span>Barang Masuk</span></a></li>
              <li><a class="nav-link {{ Request::is('laporan-barang-keluar') ? 'active' : '' }}" href="laporan-barang-keluar"><i class="fa fa-sharp fa-regular fa-file-export"></i><span>Barang Keluar</span></a></li>
            
              <li class="menu-header">MANAJEMEN USER</li>
              <li><a class="nav-link {{ Request::is('aktivitas-user') ? 'active' : '' }}" href="aktivitas-user"><i class="fa fa-solid fa-list"></i><span>Aktivitas User</span></a></li>
            @endif

            @if (auth()->user()->role->role === 'superadmin')
              <li class="sidebar-item">
                  <a class="nav-link {{ Request::is('/') || Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
                      <i class="fas fa-fire"></i> <span class="align-middle">Dashboard</span>
                  </a>
              </li>

              <li class="menu-header">DATA MASTER</li>
              <li class="dropdown">
                  <a href="#" class="nav-link has-dropdown {{ Request::is('barang') || Request::is('jenis-barang') || Request::is('satuan-barang') ? 'active' : '' }}" data-toggle="dropdown"><i class="fas fa-thin fa-cubes"></i><span>Data Barang</span></a>
                  <ul class="dropdown-menu">
                      <li><a class="nav-link {{ Request::is('barang') ? 'active' : '' }}" href="{{ route('barang.index') }}"><i class="fa fa-solid fa-circle fa-xs"></i> Nama Barang</a></li>
                      <li><a class="nav-link {{ Request::is('jenis-barang') ? 'active' : '' }}" href="{{ route('jenis-barang.index') }}"><i class="fa fa-solid fa-circle fa-xs"></i> Jenis</a></li>
                      <!-- <li><a class="nav-link {{ Request::is('satuan-barang') ? 'active' : '' }}" href="{{ route('satuan-barang.index') }}"><i class="fa fa-solid fa-circle fa-xs"></i> Satuan</a></li> -->
                  </ul>
              </li>

              <li><a class="nav-link {{ Request::is('direktorat') ? 'active' : '' }}" href="{{ route('direktorat.index') }}"><i class="fa fa-sharp fa-reguler fa-file"></i><span>Data Direktorat</span></a></li>

              <li class="menu-header">LAPORAN</li>
              <li><a class="nav-link {{ Request::is('laporan-stok') ? 'active' : '' }}" href="{{ route('laporan.kondisi_barang')}}"><i class="fa fa-sharp fa-reguler fa-file"></i><span>Berdasarkan Kondisi Barang</span></a></li>
              <li><a class="nav-link {{ Request::is('laporan-barang-masuk') ? 'active' : '' }}" href="#"><i class="fa fa-regular fa-file-import"></i><span>Berdasarkan Tanggal</span></a></li>
              <li><a class="nav-link {{ Request::is('laporan.penyusutan') ? 'active' : '' }}" href="{{ route('laporan.penyusutan') }}"><i class="fa fa-sharp fa-regular fa-file-export"></i><span>Penyusutan Stok</span></a></li>
              <li><a class="nav-link {{ Request::is('amprahan') ? 'active' : '' }}" href="{{ route('amprahan.index') }}"><i class="fa fa-sharp fa-regular fa-file-export"></i><span>Amprahan</span></a></li>

              <li class="menu-header">MANAJEMEN USER</li>
              <li><a class="nav-link {{ Request::is('data-pengguna') ? 'active' : '' }}" href="{{ route('data-pengguna.index') }}"><i class="fa fa-solid fa-users"></i><span>Data Pengguna</span></a></li>
              <li><a class="nav-link {{ Request::is('hak-akses') ? 'active' : '' }}" href="{{ route('hak-akses.index') }}"><i class="fa fa-solid fa-user-lock"></i><span>Hak Akses/Role</span></a></li>
              <li><a class="nav-link {{ Request::is('aktivitas-user') ? 'active' : '' }}" href="{{ route('aktivitas-user.index') }}"><i class="fa fa-solid fa-list"></i><span>Aktivitas User</span></a></li>
          @endif

            
            @if (auth()->user()->role->role === 'admin')
            <li class="sidebar-item">
              <a class="sidebar-link nav-link {{ Request::is('/') || Request::is('dashboard') ? 'active' : '' }}" href="/">
                <i class="fas fa-fire"></i> <span class="align-middle">Dashboard</span>
              </a>
            </li>

              <li class="menu-header">DATA MASTER</li>
              <li class="dropdown">
                <a href="#" class="nav-link has-dropdown {{ Request::is('barang') || Request::is('jenis-barang') || Request::is('satuan-barang') ? 'active' : '' }}" data-toggle="dropdown"><i class="fas fa-thin fa-cubes"></i><span>Data Barang</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link {{ Request::is('barang') ? 'active' : '' }}" href="/barang"><i class="fa fa-solid fa-circle fa-xs"></i> Nama Barang</a></li>
                  <li><a class="nav-link {{ Request::is('jenis-barang') ? 'active' : '' }}" href="/jenis-barang"><i class="fa fa-solid fa-circle fa-xs"></i> Jenis</a></li>
                  <!-- <li><a class="nav-link {{ Request::is('satuan-barang') ? 'active' : '' }}" href="/satuan-barang"><i class="fa fa-solid fa-circle fa-xs"></i> Satuan</a></li> -->
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="nav-link has-dropdown {{ Request::is('supplier')  || Request::is('customer') ? 'active' : '' }}" data-toggle="dropdown"><i class="fa fa-sharp fa-solid fa-building"></i><span>Perusahaan</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link {{ Request::is('supplier') ? 'active' : '' }}" href="/supplier"><i class="fa fa-solid fa-circle fa-xs"></i> Supplier</a></li>
                  <li><a class="nav-link {{ Request::is('customer') ? 'active' : '' }}" href="/customer"><i class="fa fa-solid fa-circle fa-xs"></i> Customer</a></li>
                </ul>
              </li>

              <li class="menu-header">TRANSAKSI</li>
              <li><a class="nav-link {{ Request::is('barang-masuk') ? 'active' : '' }}" href="barang-masuk"><i class="fa fa-solid fa-arrow-right"></i><span>Barang Masuk</span></a></li>
              <li><a class="nav-link {{ Request::is('barang-keluar') ? 'active' : '' }}" href="barang-keluar"><i class="fa fa-sharp fa-solid fa-arrow-left"></i> <span>Barang Keluar</span></a></li>
            
              <li class="menu-header">LAPORAN</li>
              <li><a class="nav-link {{ Request::is('laporan-stok') ? 'active' : '' }}" href="laporan-stok"><i class="fa fa-sharp fa-reguler fa-file"></i><span>Stok</span></a></li>
              <li><a class="nav-link {{ Request::is('laporan-barang-masuk') ? 'active' : '' }}" href="laporan-barang-masuk"><i class="fa fa-regular fa-file-import"></i><span>Barang Masuk</span></a></li>
              <li><a class="nav-link {{ Request::is('laporan-barang-keluar') ? 'active' : '' }}" href="laporan-barang-keluar"><i class="fa fa-sharp fa-regular fa-file-export"></i><span>Barang Keluar</span></a></li>
              
            @endif
          </ul>

        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">

            @yield('content')
          <div class="section-body">
          </div>
        </section>
      </div>
      <!-- <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2023 
        </div>
        <div class="footer-right">
          
        </div>
      </footer> -->
    </div>
  </div>


  
  <!-- General JS Scripts -->
<script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('assets/modules/popper.js') }}"></script>
<script src="{{ asset('assets/modules/tooltip.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/modules/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/stisla.js') }}"></script>

<!-- JS Libraries -->
  
<!-- Select2 Jquery -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>

<!-- Page Specific JS File -->
  
<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

<!-- Datatables Jquery -->
<script type="text/javascript" src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<!-- Sweet Alert -->
@include('sweetalert::alert')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Day Js Format -->
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>

@stack('scripts')

<script>
  $(document).ready(function() {
    var currentPath = window.location.pathname;

    $('.nav-link a[href="' + currentPath + '"]').addClass('active');
  });
</script>

  
</body>
</html>
