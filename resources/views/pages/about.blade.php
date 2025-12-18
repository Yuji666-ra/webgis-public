@extends('layouts.app')

@section('title', 'Tentang - SAFETRACK')

@push('styles')
    @vite(['resources/css/about.css'])
@endpush

@section('content')

    <section class="about-section bg-light">

        {{-- ======= PAGE TITLE ======= --}}
        <div class="page-title-wrapper">
            <h2 class="page-title">Tentang SAFETRACK</h2>
        </div>

        <div class="container">

            {{-- ======= DESCRIPTION ======= --}}
            <div class="row justify-content-center mb-5 mt-4">
                <div class="col-md-9">
                    <p class="description">
                        <strong>SAFETRACK</strong> adalah Sistem informasi geografis pemetaan daerah rawan
                        kecelakaan yang dikembangkan sebagai bagian dari penelitian terkait
                        keselamatan lalu lintas di Kabupaten Lumajang.
                        Sistem ini memanfaatkan data kecelakaan lalu lintas yang diperoleh dari
                        Unit Satlantas Polres Lumajang untuk menampilkan pola kerawanan, titik kecelakaan,
                        serta analisis spasial yang dapat digunakan sebagai dasar pengambilan keputusan oleh instansi
                        terkait.
                    </p>
                </div>
            </div>

            {{-- ======= 3 INFORMATION CARDS ======= --}}
            <div class="row text-center mt-4">

                <div class="col-md-4 mb-4">
                    <div class="about-card shadow-sm h-100">
                        <h5 class="fw-bold text-primary mb-2">🎯 Tujuan Sistem</h5>
                        <p class="text-secondary mb-0">
                            Menyediakan pemetaan interaktif titik rawan kecelakaan berdasarkan
                            data resmi Satlantas Polres Lumajang.
                        </p>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="about-card shadow-sm h-100">
                        <h5 class="fw-bold text-success mb-2">📊 Manfaat Analisis</h5>
                        <p class="text-secondary mb-0">
                            Membantu pemerintah, kepolisian, dan masyarakat memahami pola risiko
                            sehingga upaya pencegahan bisa lebih terarah.
                        </p>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="about-card shadow-sm h-100">
                        <h5 class="fw-bold text-warning mb-2">🛂 Sumber Data</h5>
                        <p class="text-secondary mb-0">
                            Seluruh data yang ditampilkan dalam WebGIS ini berasal dari
                            Unit Satlantas Polres Lumajang dan diolah dalam bentuk analisis spasial.
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </section>

@endsection
