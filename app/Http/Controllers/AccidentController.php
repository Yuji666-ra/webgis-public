<?php

namespace App\Http\Controllers;

use App\Models\Accident;
use Illuminate\Http\Request;

class AccidentController extends Controller
{
    // Fungsi untuk menampilkan halaman dashboard
    public function index()
    {
        return view('monitoring_dashboard');
    }

    // Fungsi untuk mendapatkan data clustering dalam format JSON (untuk peta)
    public function getClusteringData()
    {
        $accidents = Accident::all();
        $data = $accidents->map(function ($accident) {
            return [
                'id' => $accident->id,
                'latitude' => $accident->latitude,
                'longitude' => $accident->longitude,
                'severity' => $accident->severity
            ];
        })->toArray();

        $clusters = $this->kMeans($data, 3);

        return response()->json($clusters);
    }

    // Fungsi K-Means Clustering
    private function kMeans($data, $k)
    {
        // Inisialisasi centroid secara acak
        $centroids = array_map(fn($index) => $data[$index], array_rand($data, $k));

        $clusters = [];
        $changed = true;

        while ($changed) {
            $changed = false;
            $clusters = array_fill(0, $k, []); // Kelompokkan data ke centroid terdekat

            foreach ($data as $point) {
                $closest = $this->closestCentroid($point, $centroids);
                $clusters[$closest][] = $point;
            }

            // Update centroid
            foreach ($clusters as $i => $cluster) {
                if (!empty($cluster)) {
                    $newCentroid = [
                        'latitude' => array_sum(array_column($cluster, 'latitude')) / count($cluster),
                        'longitude' => array_sum(array_column($cluster, 'longitude')) / count($cluster)
                    ];

                    if ($newCentroid != $centroids[$i]) {
                        $changed = true;
                        $centroids[$i] = $newCentroid;
                    }
                }
            }
        }

        return $this->assignClusterColors($clusters);
    }

    // Fungsi untuk menentukan centroid terdekat
    private function closestCentroid($point, $centroids)
    {
        $closest = 0;
        $minDistance = PHP_INT_MAX;

        foreach ($centroids as $i => $centroid) {
            $distance = sqrt(pow($point['latitude'] - $centroid['latitude'], 2) + pow($point['longitude'] - $centroid['longitude'], 2));
            if ($distance < $minDistance) {
                $minDistance = $distance;
                $closest = $i;
            }
        }

        return $closest;
    }

    // Fungsi untuk memberikan warna pada cluster
    private function assignClusterColors($clusters)
    {
        $colors = ['red', 'yellow', 'green']; // Merah untuk berat, kuning untuk sedang, hijau untuk ringan
        $coloredClusters = [];

        foreach ($clusters as $index => $cluster) {
            foreach ($cluster as $point) {
                $point['cluster'] = $index; // Indeks cluster untuk JavaScript
                $point['color'] = $colors[$index]; // Warna sesuai indeks cluster
                $coloredClusters[] = $point;
            }
        }

        return $coloredClusters;
    }

    // Fungsi untuk menghapus kecelakaan dengan ID tertentu
    public function deleteSpecificAccidents()
    {
        // Menghapus data kecelakaan berdasarkan latitude, longitude, dan severity
        Accident::where([
            ['latitude', '=', -7.250445],
            ['longitude', '=', 112.768845],
            ['severity', '=', 'Berat'],
        ])->orWhere([
            ['latitude', '=', -7.257144],
            ['longitude', '=', 112.745387],
            ['severity', '=', 'Berat'],
        ])->orWhere([
            ['latitude', '=', -7.265235],
            ['longitude', '=', 112.773694],
            ['severity', '=', 'Berat'],
        ])->delete();

        return response()->json(['message' => 'Data kecelakaan telah dihapus.'], 200);
    }
}
