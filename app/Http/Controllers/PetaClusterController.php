<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class PetaClusterController extends Controller
{
    public function index()
    {
        $geojsonPath = public_path('data/hasil_klaster.geojson');

        if (!File::exists($geojsonPath)) {
            abort(404, 'GeoJSON tidak ditemukan');
        }

        // baca hanya untuk statistik & tabel
        $geojsonData = json_decode(File::get($geojsonPath), true);
        $features = $geojsonData['features'] ?? [];

        $zonaBerat = 0;
        $zonaSedang = 0;
        $zonaRingan = 0;

        $tabelData = collect($features)->map(function ($feature) use (&$zonaBerat, &$zonaSedang, &$zonaRingan) {
            $p = $feature['properties'] ?? [];
            $clusterRanked = isset($p['cluster_ranked']) ? (int) $p['cluster_ranked'] : 0;

            if ($clusterRanked === 2) {
                $zonaBerat++;
                $tingkat = 'Berat';
            } elseif ($clusterRanked === 1) {
                $zonaSedang++;
                $tingkat = 'Sedang';
            } else {
                $zonaRingan++;
                $tingkat = 'Ringan';
            }

return [
    'kecamatan' => $p['KECAMATAN'] ?? $p['kecamatan'] ?? '-',

    'jumlah_meninggal_dunia' => (int) ($p['jumlah_meninggal_dunia'] ?? 0),
    'jumlah_luka_berat' => (int) ($p['jumlah_luka_berat'] ?? 0),
    'jumlah_luka_ringan' => (int) ($p['jumlah_luka_ringan'] ?? 0),

    'total_korban' => (int) (
        $p['total_korban']
        ?? (($p['jumlah_meninggal_dunia'] ?? 0)
        + ($p['jumlah_luka_berat'] ?? 0)
        + ($p['jumlah_luka_ringan'] ?? 0))
    ),

    'jumlah_kejadian' => (int) ($p['jumlah_kejadian'] ?? 0),
    'tingkat_kecelakaan' => $tingkat,
    'cluster_ranked' => $clusterRanked,
];

        });

        return view('pages.peta-cluster', [
            'tabelData' => $tabelData,
            'totalLokasi' => $tabelData->count(),
            'zonaBerat' => $zonaBerat,
            'zonaSedang' => $zonaSedang,
            'zonaRingan' => $zonaRingan,
        ]);
    }
}
