<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Dashboard') - Peminjaman Buku</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
  @stack('styles')
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
    data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

    {{-- ===================== SIDEBAR ===================== --}}
    <aside class="left-sidebar">
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
            <img src="{{ asset('assets/images/logos/logo.svg') }}" alt="logo" width="180">
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <iconify-icon icon="solar:close-circle-line-duotone" class="fs-8"></iconify-icon>
          </div>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
          <ul id="sidebarnav">

            {{-- Label --}}
            <li class="nav-small-cap">
              <iconify-icon icon="solar:minus-cirlce-line-duotone" class="nav-small-cap-icon fs-4"></iconify-icon>
              <span class="hide-menu">Menu Utama</span>
            </li>

            {{-- Dashboard --}}
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                href="{{ route('dashboard') }}" aria-expanded="false">
                <iconify-icon icon="solar:home-smile-angle-bold-duotone" class="fs-6"></iconify-icon>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>

            {{-- Buku --}}
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('user.buku.*') ? 'active' : '' }}"
                href="{{ route('user.buku.index') }}" aria-expanded="false">
                <iconify-icon icon="solar:book-bold-duotone" class="fs-6"></iconify-icon>
                <span class="hide-menu">Daftar Buku</span>
              </a>
            </li>

            {{-- Transaksi --}}
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('user.transaksi.*') ? 'active' : '' }}"
                href="{{ route('user.transaksi.index') }}" aria-expanded="false">
                <iconify-icon icon="solar:document-text-bold-duotone" class="fs-6"></iconify-icon>
                <span class="hide-menu">Peminjaman Saya</span>
              </a>
            </li>

            {{-- Hanya tampil jika admin --}}
            @if(auth()->user()->role === 'admin')
            <li class="nav-small-cap">
              <iconify-icon icon="solar:minus-cirlce-line-duotone" class="nav-small-cap-icon fs-4"></iconify-icon>
              <span class="hide-menu">Manajemen</span>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}"
                href="{{ route('admin.buku.index') }}" aria-expanded="false">
                <iconify-icon icon="solar:library-bold-duotone" class="fs-6"></iconify-icon>
                <span class="hide-menu">Kelola Buku</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}"
                href="{{ route('admin.transaksi.index') }}" aria-expanded="false">
                <iconify-icon icon="solar:clipboard-list-bold-duotone" class="fs-6"></iconify-icon>
                <span class="hide-menu">Kelola Peminjaman</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('admin.anggota.*') ? 'active' : '' }}"
                href="{{ route('admin.anggota.index') }}" aria-expanded="false">
                <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="fs-6"></iconify-icon>
                <span class="hide-menu">Kelola Anggota</span>
              </a>
            </li>
            @endif

          </ul>
        </nav>
      </div>
    </aside>

    {{-- ===================== MAIN WRAPPER ===================== --}}
    <div class="body-wrapper">

      {{-- ===================== HEADER / NAVBAR ===================== --}}
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <iconify-icon icon="solar:hamburger-menu-line-duotone" class="fs-6"></iconify-icon>
              </a>
            </li>
          </ul>

          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

              {{-- Nama User --}}
              <li class="nav-item">
                <span class="nav-link text-dark fw-semibold">
                  <iconify-icon icon="solar:user-circle-bold-duotone" class="me-1 fs-6"></iconify-icon>
                  {{ auth()->user()->nama }}
                </span>
              </li>

              {{-- Logout --}}
              <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="btn btn-outline-danger btn-sm ms-2">
                    <iconify-icon icon="solar:logout-2-bold-duotone" class="me-1"></iconify-icon>
                    Logout
                  </button>
                </form>
              </li>

            </ul>
          </div>
        </nav>
      </header>

      {{-- ===================== CONTENT ===================== --}}
      <div class="container-fluid">
        @yield('content')
      </div>

    </div>
  </div>

  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset('assets/js/app.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  @stack('scripts')
</body>

</html>