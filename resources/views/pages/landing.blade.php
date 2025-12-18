@extends('layouts.app')

@section('title', 'Beranda - SAFETRACK')

@push('styles')
    @vite('resources/css/landing.css')
@endpush


@section('content')

    <div class="landing-page">

        {{-- ======= HERO SECTION ======= --}}
        <section class="landing-hero">
            <div class="overlay"></div>

            <div class="hero-content text-center">
                <h1 class="fw-bold">Sistem Monitoring Daerah Rawan Kecelakaan</h1>
                <p class="lead">
                    Visualisasi zona risiko berbasis WebGIS untuk mendukung analisis keselamatan lalu lintas.
                </p>

                <a href="{{ url('/peta-cluster') }}" class="btn btn-hero mt-3">
                    Lihat Peta Risiko
                </a>
            </div>
        </section>

        {{-- ======= FITUR UTAMA ======= --}}
        <section class="landing-features">
            <div class="container">
                <h2 class="text-center mb-3">Fitur Utama Sistem</h2>
                <p class="section-desc text-center">
                    Sistem ini menyediakan rangkaian fitur visualisasi untuk memahami kondisi rawan kecelakaan di Kabupaten
                    Lumajang.
                </p>

                <div class="row g-4 justify-content-center">

                    <div class="col-md-4">
                        <div class="landing-feature-card h-100">
                            <h4 class="fw-bold mb-2 text-center">Peta Risiko Interaktif</h4>
                            <p class="text-center m-0">
                                Menampilkan zona risiko kecelakaan berdasarkan hasil klasterisasi yang divisualisasikan
                                dalam warna berbeda.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="landing-feature-card h-100">
                            <h4 class="fw-bold mb-2 text-center">Statistik Data Kecelakaan</h4>
                            <p class="text-center m-0">
                                Grafik dan rangkuman statistik untuk membantu memahami tren kecelakaan dari tahun ke tahun.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="landing-feature-card h-100">
                            <h4 class="fw-bold mb-2 text-center">Informasi Klaster</h4>
                            <p class="text-center m-0">
                                Detail kategori risiko pada setiap kecamatan untuk memudahkan identifikasi daerah rawan.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- ======= ABOUT SECTION ======= --}}
        <section class="landing-about">
            <div class="container">
                <h2 class="text-center mb-4">Tentang Sistem</h2>

                <p class="text-center mx-auto">
                    <strong>SAFETRACK</strong> adalah sistem WebGIS yang digunakan untuk menampilkan peta risiko kecelakaan
                    lalu lintas di
                    Kabupaten Lumajang.
                    Sistem ini memvisualisasikan hasil pengelompokan tingkat kerawanan berdasarkan beberapa fitur seperti
                    jumlah korban meninggal,
                    luka berat, luka ringan, dan total korban kecelakaan.
                </p>
            </div>
        </section>

        {{-- ======= CONTACT SECTION ======= --}}
        <section class="landing-emergency">
            <div class="container">
                <h2 class="text-center mb-4 fw-bold">Kontak Darurat & Lembaga Pendukung</h2>
                <p class="section-desc text-center">
                    Hubungi instansi berikut untuk mendapatkan bantuan cepat terkait kecelakaan lalu lintas di Kabupaten
                    Lumajang.
                </p>

                <div class="row justify-content-center g-4">

                    <!-- Dinas Perhubungan -->
                    <div class="col-md-5 col-lg-3">
                        <div class="landing-em-card h-100 text-center">
                            <img src="{{ asset('assets/dishub-logo.png') }}" alt="Dishub Lumajang">
                            <h5 class="fw-bold">Dinas Perhubungan Lumajang</h5>
                            <p class="mb-1">☎️ (0334) 875435</p>
                            <p class="mb-0">📍 Jl. Gubernur Suryo No. 12, Lumajang</p>
                        </div>
                    </div>

                    <!-- Polres -->
                    <div class="col-md-5 col-lg-3">
                        <div class="landing-em-card h-100 text-center">
                            <img src="{{ asset('assets/polda-logo.png') }}" alt="Polres Lumajang">
                            <h5 class="fw-bold">Kepolisian Resor Lumajang</h5>
                            <p class="mb-1">☎️ (0334) 881110</p>
                            <p class="mb-0">📍 Jl. Alun-Alun Timur No.1, Lumajang</p>
                        </div>
                    </div>

                    <!-- Satlantas -->
                    <div class="col-md-5 col-lg-3">
                        <div class="landing-em-card h-100 text-center">
                            <img src="{{ asset('assets/korps-lantas.png') }}" alt="Satlantas Lumajang">
                            <h5 class="fw-bold">Satlantas Polres Lumajang</h5>
                            <p class="mb-1">☎️ (0334) 880221</p>
                            <p class="mb-0">📍 Jl. PB Sudirman No.25, Lumajang</p>
                        </div>
                    </div>

                    <!-- RSUD -->
                    <div class="col-md-5 col-lg-3">
                        <div class="landing-em-card h-100 text-center">
                            <img src="{{ asset('assets/rsud-logo.png') }}" alt="RSUD Lumajang">
                            <h5 class="fw-bold">RSUD dr. Haryoto Lumajang</h5>
                            <p class="mb-1">☎️ (0334) 881005</p>
                            <p class="mb-0">📍 Jl. Panjaitan No.2, Lumajang</p>
                        </div>
                    </div>

                    <!-- Jasa Raharja Cabang Probolinggo -->
                    <div class="col-md-5 col-lg-3">
                        <div class="landing-em-card h-100 text-center">
                            <img src="{{ asset('assets/jr-logo.png') }}" alt="Jasa Raharja Probolinggo">
                            <h5 class="fw-bold">Jasa Raharja</h5>
                            <p class="mb-1">☎️ (+62) 822-5166-1650</p>
                            <p class="mb-0">📍 Jl. Soekarno-Hatta No.128B, Kademangan, Probolinggo</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </div>

@endsection
