@extends('layouts.app')

@section('title', 'Statistik - SAFETRACK')

@push('styles')
    @vite(['resources/css/statistik.css'])
@endpush

@section('content')
    <section class="statistik-section page-statistik py-5">
        <div class="page-title-wrapper">
            <h2 class="page-title">
                Statistik Daerah Rawan Kecelakaan di Kabupaten Lumajang Tahun 2022-2025
            </h2>

            <!-- KPI Card Wrapper -->
            <div class="kpi-wrapper mb-5">
                <div class="kpi-card">
                    <div class="kpi-color bg-red-500"></div>
                    <h5>Total Kejadian</h5>
                    <p>{{ $totalKejadian ?? 0 }}</p>
                </div>
                <div class="kpi-card">
                    <div class="kpi-color bg-yellow-400"></div>
                    <h5>Total Korban</h5>
                    <p>{{ $totalKorban ?? 0 }}</p>
                </div>
                <div class="kpi-card">
                    <div class="kpi-color bg-red-600"></div>
                    <h5>Jumlah Meninggal Dunia</h5>
                    <p>{{ $totalMeninggal ?? 0 }}</p>
                </div>
                <div class="kpi-card">
                    <div class="kpi-color bg-green-500"></div>
                    <h5>Kecamatan Risiko Tertinggi</h5>
                    <p>{{ $kecamatanTertinggi ?? '-' }}</p>
                </div>
            </div>

            <div class="charts-wrapper">
                <!-- Grafik 1 -->
                <div class="chart-container">
                    <h5 class="text-center mb-3">Jumlah Kejadian Kecelakaan per Kecamatan</h5>
                    <canvas id="chartKejadian"></canvas>
                </div>

                <!-- Grafik 2 -->
                <div class="chart-container">
                    <h5 class="text-center mb-0">Distribusi Zona Rawan Berdasarkan Cluster</h5>
                    <canvas id="chartCluster"></canvas>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = {!! json_encode($labels) !!};
        const dataKejadian = {!! json_encode($dataKejadian) !!};
        const clusterCounts = {!! json_encode($clusterCounts) !!};
        const clusterColors = ['#00b050', '#fff200', '#ff0000'];

        // =============================
        // Grafik Batang: Jumlah Kejadian
        // =============================
        new Chart(document.getElementById('chartKejadian'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Kejadian',
                    data: dataKejadian,
                    backgroundColor: '#1976d2',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Kecamatan'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Jumlah Kejadian'
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        // =============================
        // Pie Chart: Distribusi Cluster
        // =============================
        new Chart(document.getElementById('chartCluster'), {
            type: 'pie',
            data: {
                labels: [
                    'Zona Rawan Ringan (Cluster 0)',
                    'Zona Rawan Sedang (Cluster 1)',
                    'Zona Rawan Berat (Cluster 2)'
                ],
                datasets: [{
                    data: [
                        clusterCounts[0] || 0,
                        clusterCounts[1] || 0,
                        clusterCounts[2] || 0
                    ],
                    backgroundColor: clusterColors,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endpush
