<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClusteringController extends Controller
{
    /**
     * Halaman utama K-Means Clustering.
     */
    public function index()
    {
        return view('clustering');
    }

    /**
     * Proses perhitungan K-Means.
     */
    public function process(Request $request)
    {
        $data = json_decode($request->input('data'), true);
        $k = (int) $request->input('k', 3);

        // Validasi input
        if (!$data || count($data) < $k) {
            return back()->with('error', 'Data tidak cukup atau format salah.');
        }

        // --- 1. Inisialisasi centroid secara acak ---
        $centroids = array_slice($data, 0, $k);

        $changed = true;
        $maxIterations = 100;
        $iteration = 0;

        while ($changed && $iteration < $maxIterations) {
            $iteration++;
            $clusters = [];

            // --- 2. Assign setiap titik ke centroid terdekat ---
            foreach ($data as $point) {
                $distances = array_map(fn($c) => $this->euclideanDistance($point, $c), $centroids);
                $clusterIndex = array_search(min($distances), $distances);
                $clusters[$clusterIndex][] = $point;
            }

            // --- 3. Update centroid ---
            $newCentroids = [];
            foreach ($clusters as $cluster) {
                $latitudes = array_column($cluster, 'latitude');
                $longitudes = array_column($cluster, 'longitude');
                $newCentroids[] = [
                    'latitude' => array_sum($latitudes) / count($latitudes),
                    'longitude' => array_sum($longitudes) / count($longitudes),
                ];
            }

            // --- 4. Cek perubahan ---
            $changed = $centroids !== $newCentroids;
            $centroids = $newCentroids;
        }

        // Hasil clustering akhir
        return view('clustering', [
            'clusters' => $clusters,
            'centroids' => $centroids,
            'iteration' => $iteration,
            'k' => $k,
        ]);
    }

    /**
     * Fungsi jarak Euclidean.
     */
    private function euclideanDistance($a, $b)
    {
        return sqrt(pow($a['latitude'] - $b['latitude'], 2) + pow($a['longitude'] - $b['longitude'], 2));
    }
}
