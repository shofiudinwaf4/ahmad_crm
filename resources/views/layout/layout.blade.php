<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}?v={{ time() }}">
</head>

<!-- Header/Navbar untuk Semua Ukuran Layar (Selalu Expanded) -->
<nav class="navbar navbar-expand navbar-light header-navbar">
    <div class="container-fluid">
        <!-- Tombol Toggle Sidebar untuk Mobile -->
        <button class="btn btn-outline-secondary d-md-none me-2" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
            <i class="bi bi-list"></i>
        </button>
        <!-- Brand/Title -->
        <a class="navbar-brand" href="#">Dashboard Admin</a>
        <!-- Elemen di Kanan: Nama Admin dan Logout (Selalu Terlihat) -->
        <div class="d-flex align-items-center ms-auto">
            <span class="me-3 d-none d-sm-inline">Selamat datang, <strong>{{ $profile->name }}</strong></span>
            <!-- Sembunyi di layar sangat kecil jika perlu -->
            <a href="/logout" class="btn d-none d-sm-inline btn-outline-danger">Logout <i
                    class="bi bi-box-arrow-right"></i></a>
        </div>
    </div>
</nav>

<!-- Sidebar untuk Desktop -->
<div class="sidebar d-none d-md-block">
    <div class="p-3">
        <h5>Dashboard Menu</h5>
        @include('layout.sidebar')
    </div>
</div>

<!-- Offcanvas Sidebar untuk Mobile -->
<div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="sidebarOffcanvas"
    aria-labelledby="sidebarOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">Dashboard Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @include('layout.sidebar') </div>
</div>
<div class="content">
    <div class="container-fluid">
        <h1>{{ $title }}</h1>
        @yield('content')
    </div>
</div>


<!-- Bootstrap JS (optional, for interactive components) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="{{ asset('js/my_script.js') }}"></script>
@stack('scripts')

</body>

</html>
