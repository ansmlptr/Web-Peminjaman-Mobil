<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Cantik Car Rent</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="{{ asset('assets/img/kaiadmin/favicon.ico') }}"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="{{ asset('template/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ], 
          urls: ["{{ asset('template/assets/css/fonts.min.css') }}"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/kaiadmin.min.css') }}" />

    <!-- Custom DataTables Override CSS -->
    <style>
      /* DataTables Consistent Styling Override */
      .dataTables_wrapper {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
      }
      .dataTables_filter, 
      .dataTables_length, 
      .dataTables_info, 
      .dataTables_paginate {
        background: transparent !important;
        border: none !important;
        color: inherit !important;
      }
      .dataTables_filter input {
        background: rgba(255,255,255,0.1) !important;
        border: 1px solid rgba(255,255,255,0.2) !important;
        color: inherit !important;
        border-radius: 4px !important;
      }
      .dataTables_filter input:focus {
        background: rgba(255,255,255,0.15) !important;
        border-color: rgba(255,255,255,0.3) !important;
        outline: none !important;
      }
      .card-body {
        background: inherit !important;
      }
      .table-responsive {
        background: transparent !important;
      }
      .table {
        background: transparent !important;
      }
      .table thead th {
        background: inherit !important;
        border-color: rgba(255,255,255,0.1) !important;
      }
      .table tbody td {
        background: inherit !important;
        border-color: rgba(255,255,255,0.1) !important;
      }
      /* Pagination styling */
      .dataTables_paginate .paginate_button {
        background: transparent !important;
        border: none !important;
        color: inherit !important;
      }
      .dataTables_paginate .paginate_button:hover {
        background: rgba(255,255,255,0.1) !important;
        border: none !important;
      }
      .dataTables_paginate .paginate_button.current {
        background: rgba(255,255,255,0.2) !important;
        border: none !important;
      }
    </style> 
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
              <img  
                src="{{ asset('template/assets/img/kaiadmin/logo_light.svg') }}"
                alt="navbar brand"
                class="navbar-brand"
                height="20"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-item {{ request()->routeIs('admin.katalog.*') ? 'active' : '' }}">
                <a href="{{ route('admin.katalog.index') }}">
                  <i class="fas fa-car"></i>
                  <p>Kelola Katalog Mobil</p>
                </a>
              </li>
              <li class="nav-item {{ request()->routeIs('admin.booking.*') ? 'active' : '' }}">
                <a href="{{ route('admin.booking.index') }}">
                  <i class="fas fa-calendar-check"></i>
                  <p>Kelola Pesanan</p>
                </a>
              </li>
              <li class="nav-item {{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}">
                <a href="{{ route('admin.pembayaran.index') }}">
                  <i class="fas fa-credit-card"></i>
                  <p>Kelola Pembayaran</p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="index.html" class="logo">
                <img 
                  src="{{ asset('template/assets/img/kaiadmin/logo_light.svg') }}"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item">
                  <span class="navbar-text me-3">
                    <span class="op-7">Hi,</span>
                    <span class="fw-bold">{{ Auth::user()->name ?? 'Admin' }}</span>
                  </span>
                </li>
                <li class="nav-item">
                  <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm" style="border: none; background: none;">
                      <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                  </form>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>
        
        <!-- Main Content -->
        <div class="container">
          <div class="page-inner">
            @yield('content')
          </div>
        </div>
      </div>


    </div>

    @include('admin.layout.script')
  </body>
</html>