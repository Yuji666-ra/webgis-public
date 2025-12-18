@extends('layouts.app')

@section('title', 'Kontak - SAFETRACK')

@push('styles')
    @vite(['resources/css/contact.css'])
@endpush

@section('content')
    <section class="contact-section py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark">Hubungi Kami</h2>
                <p class="text-secondary">
                    Laporkan kejadian kecelakaan atau kondisi jalan berbahaya melalui formulir berikut.
                </p>
            </div>

            <div class="row justify-content-center align-items-center">
                <!-- Form Kontak -->
                <div class="col-md-6">
                    <form class="p-4 bg-white rounded-4 shadow-sm">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" placeholder="Masukkan nama Anda">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="nama@email.com">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label fw-semibold">Pesan</label>
                            <textarea class="form-control" id="message" rows="4" placeholder="Tulis pesan Anda di sini..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">Kirim Pesan</button>
                    </form>
                </div>

                <!-- Info Kontak -->
                <div class="col-md-5 mt-4 mt-md-0">
                    <div class="bg-white p-4 rounded-4 shadow-sm">
                        <h5 class="fw-bold text-dark mb-3">Informasi Kontak</h5>
                        <p class="text-secondary mb-2">
                            <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                            Jl. Raya Lumajang No.123, Jawa Timur, Indonesia
                        </p>
                        <p class="text-secondary mb-2">
                            <i class="bi bi-envelope-fill text-primary me-2"></i>
                            support@safetrack.id
                        </p>
                        <p class="text-secondary">
                            <i class="bi bi-telephone-fill text-success me-2"></i>
                            +62 812-3456-7890
                        </p>
                        <hr>
                        <h6 class="fw-bold text-dark mb-2">Jam Operasional</h6>
                        <p class="text-secondary mb-0">Senin - Jumat: 08.00 - 16.00 WIB</p>
                        <p class="text-secondary">Sabtu & Minggu: Tutup</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
