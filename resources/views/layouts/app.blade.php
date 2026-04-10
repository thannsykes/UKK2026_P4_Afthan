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
          <a href="#" class="text-nowrap logo-img">
            <img src="{{ asset('assets/images/logos/logo.svg') }}" alt="logo" width="180">
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <iconify-icon icon="solar:close-circle-line-duotone" class="fs-8"></iconify-icon>
          </div>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
          <ul id="sidebarnav">

            {{-- ===== MENU ADMIN ===== --}}
            @if(auth()->user()->role === 'admin')

            <li class="nav-small-cap">
              <iconify-icon icon="solar:minus-cirlce-line-duotone" class="nav-small-cap-icon fs-4"></iconify-icon>
              <span class="hide-menu">Admin</span>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                href="{{ route('admin.dashboard') }}">
                <iconify-icon icon="solar:home-smile-angle-bold-duotone" class="fs-6"></iconify-icon>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('admin.anggota.*') ? 'active' : '' }}"
                href="{{ route('admin.anggota.index') }}">
                <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="fs-6"></iconify-icon>
                <span class="hide-menu">CRUD Anggota</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('admin.petugas.*') ? 'active' : '' }}"
                href="{{ route('admin.petugas.index') }}">
                <iconify-icon icon="solar:user-id-bold-duotone" class="fs-6"></iconify-icon>
                <span class="hide-menu">CRUD Petugas</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}"
                href="{{ route('admin.buku.index') }}">
                <iconify-icon icon="solar:book-bold-duotone" class="fs-6"></iconify-icon>
                <span class="hide-menu">CRUD Buku</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}"
                href="{{ route('admin.kelas.index') }}">
                <iconify-icon icon="solar:buildings-bold-duotone" class="fs-6"></iconify-icon>
                <span class="hide-menu">CRUD Kelas</span>
              </a>
            </li>

            {{-- ===== MENU PETUGAS ===== --}}
            @elseif(auth()->user()->role === 'petugas')

            <li class="nav-small-cap">
              <iconify-icon icon="solar:minus-cirlce-line-duotone" class="nav-small-cap-icon fs-4"></iconify-icon>
              <span class="hide-menu">Petugas</span>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}"
                href="{{ route('petugas.dashboard') }}">
                <iconify-icon icon="solar:home-smile-angle-bold-duotone" class="fs-6"></iconify-icon>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('petugas.transaksi.*') ? 'active' : '' }}"
                href="{{ route('petugas.transaksi.index') }}">
                <iconify-icon icon="solar:clipboard-list-bold-duotone" class="fs-6"></iconify-icon>
                <span class="hide-menu">Transaksi Peminjaman</span>
              </a>
            </li>

            {{-- ===== MENU ANGGOTA ===== --}}
            @else

            <li class="nav-small-cap">
              <iconify-icon icon="solar:minus-cirlce-line-duotone" class="nav-small-cap-icon fs-4"></iconify-icon>
              <span class="hide-menu">Anggota</span>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('anggota.dashboard') ? 'active' : '' }}"
                href="{{ route('anggota.dashboard') }}">
                <iconify-icon icon="solar:home-smile-angle-bold-duotone" class="fs-6"></iconify-icon>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('anggota.buku.*') ? 'active' : '' }}"
                href="{{ route('anggota.buku.index') }}">
                <iconify-icon icon="solar:book-bold-duotone" class="fs-6"></iconify-icon>
                <span class="hide-menu">Daftar Buku</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('anggota.history') ? 'active' : '' }}"
                href="{{ route('anggota.history') }}">
                <iconify-icon icon="solar:document-text-bold-duotone" class="fs-6"></iconify-icon>
                <span class="hide-menu">History Peminjaman</span>
              </a>
            </li>

            @endif

          </ul>
        </nav>
      </div>
    </aside>

    {{-- ===================== MAIN WRAPPER ===================== --}}
    <div class="body-wrapper">

      {{-- ===================== HEADER ===================== --}}
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" href="javascript:void(0)">
                <iconify-icon icon="solar:hamburger-menu-line-duotone" class="fs-6"></iconify-icon>
              </a>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

              {{-- Badge Role --}}
              <li class="nav-item me-2">
                @php
                  $roleBadge = match(auth()->user()->role) {
                    'admin'   => 'danger',
                    'petugas' => 'info',
                    default   => 'primary',
                  };
                @endphp
                <span class="badge bg-{{ $roleBadge }}">{{ ucfirst(auth()->user()->role) }}</span>
              </li>

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
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <iconify-icon icon="solar:check-circle-bold" class="me-1"></iconify-icon>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif
        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <iconify-icon icon="solar:danger-bold" class="me-1"></iconify-icon>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

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