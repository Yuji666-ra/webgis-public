<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function index()
{
    // Default SAFE VALUE (hosting gratis friendly)
    $labels = [];
    $dataKejadian = [];
    $clusterCounts = [0, 0, 0];

    $totalKejadian = 0;
    $totalKorban = 0;
    $totalMeninggal = 0;
    $kecamatanTertinggi = '-';
    $maxKejadian = 0;

    try {
        $geojsonPath = public_path('data/hasil_klaster.geojson');

        if (!File::exists($geojsonPath)) {
            // fallback aman
            return view('pages.statistik', compact(
                'labels',
                'dataKejadian',
                'clusterCounts',
                'totalKejadian',
                'totalKorban',
                'totalMeninggal',
                'kecamatanTertinggi'
            ));
        }

        $geojsonData = json_decode(File::get($geojsonPath), true);
        $features = $geojsonData['features'] ?? [];

        foreach ($features as $feature) {
            $props = $feature['properties'] ?? [];

            $kecamatan = $props['KECAMATAN'] ?? 'Tidak Diketahui';
            $jumlahKejadian = (int) ($props['jumlah_kejadian'] ?? 0);

            $labels[] = $kecamatan;
            $dataKejadian[] = $jumlahKejadian;

            // Cluster
            $cluster = isset($props['cluster_ranked'])
                ? (int) $props['cluster_ranked']
                : null;

            if (in_array($cluster, [0, 1, 2], true)) {
                $clusterCounts[$cluster]++;
            }

            // KPI
            $totalKejadian += $jumlahKejadian;
            $totalKorban += (int) ($props['total_korban'] ?? 0);
            $totalMeninggal += (int) ($props['jumlah_meninggal_dunia'] ?? 0);

            if ($jumlahKejadian > $maxKejadian) {
                $maxKejadian = $jumlahKejadian;
                $kecamatanTertinggi = $kecamatan;
            }
        }

    } catch (\Throwable $e) {
        // DIAM DI VIEW, JANGAN CRASH
    }

    return view('pages.statistik', [
        'labels' => $labels,
        'dataKejadian' => $dataKejadian,
        'clusterCounts' => $clusterCounts,
        'totalKejadian' => $totalKejadian,
        'totalKorban' => $totalKorban,
        'totalMeninggal' => $totalMeninggal,
        'kecamatanTertinggi' => $kecamatanTertinggi,
    ]);
}
}
