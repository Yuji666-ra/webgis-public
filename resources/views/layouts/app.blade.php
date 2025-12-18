<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SAFETRACK - Sistem Monitoring Daerah Rawan Kecelakaan')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/logo-map.png') }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Global CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CSS Khusus Halaman -->
    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- ========== NAVBAR ========== -->
    <nav class="navbar navbar-expand-lg shadow-sm custom-navbar fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center fw-bold text-light" href="{{ url('/') }}">
                <img src="{{ asset('assets/logo-map.png') }}" alt="Logo WebGIS" height="50" class="me-2">
                <span>SAFETRACK</span>
            </a>

            <button class="navbar-toggler border-0 bg-transparent" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="{{ url('/') }}"
                            class="nav-link {{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
                    <li class="nav-item"><a href="{{ url('/peta-cluster') }}"
                            class="nav-link {{ request()->is('peta-cluster') ? 'active' : '' }}">Peta Risiko</a></li>
                    <li class="nav-item"><a href="{{ url('/statistik') }}"
                            class="nav-link {{ request()->is('statistik') ? 'active' : '' }}">Statistik</a></li>
                    <li class="nav-item"><a href="{{ url('/about') }}"
                            class="nav-link {{ request()->is('about') ? 'active' : '' }}">Tentang</a></li>
                    <li class="nav-item"><a href="{{ url('/contact') }}"
                            class="nav-link {{ request()->is('contact') ? 'active' : '' }}">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ========== KONTEN HALAMAN ========== -->
    <main class="content-offset">
        @yield('content')
    </main>

    <!-- ========== FOOTER ========== -->
    <footer class="footer-section">
        <div class="footer-inner text-center">
            <small>© {{ date('Y') }} Sistem Monitoring Daerah Rawan Kecelakaan — All Rights Reserved.</small>
        </div>
    </footer>


    <button id="backToTop" class="back-to-top">
        <i class="bi bi-arrow-up"></i>
    </button>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Navbar & Back to Top Script -->
    <script>
        const navbar = document.querySelector('.custom-navbar');
        const backToTop = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);

            if (backToTop) {
                backToTop.classList.toggle('show', window.scrollY > 200);
            }
        });

        if (backToTop) {
            backToTop.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    </script>

    @stack('scripts')
</body>

</html>
