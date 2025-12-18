<?php

// database/seeders/AccidentSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accident;

class AccidentSeeder extends Seeder
{
    public function run()
    {
        // Misalkan kita akan menambahkan data kecelakaan secara manual
        Accident::create(['latitude' => -7.250445, 'longitude' => 112.768845, 'severity' => 3]); // berat
        Accident::create(['latitude' => -7.257144, 'longitude' => 112.745387, 'severity' => 2]); // sedang
        Accident::create(['latitude' => -7.265235, 'longitude' => 112.773694, 'severity' => 1]); // ringan
        // Tambahkan lebih banyak data sesuai kebutuhan
    }
}

$data = [
    [-8.224866729, 113.1570217],
    [-8.023261513, 113.2349979],
    [-7.945853354, 113.2532477],
    [-8.111845823, 113.2306058],
    [-8.103022256, 113.270799],
    [-8.123452619, 113.360419],
    [-8.144432223, 113.2050041],
    [-8.003773978, 113.2635108],
    [-8.105101785, 113.272353],
    [-8.108806406, 113.2061323],
    [-8.235017867, 113.178415],
    [-8.189387468, 113.0667667],
    [-8.019946536, 112.94561],
    [-8.143941683, 113.236157],
    [-8.183346626, 113.0643145],
    [-8.191032149, 113.2154661],
    [-8.153566189, 113.2486812],
    [-8.236263846, 113.3119193],
    [-8.104960716, 113.1081009]
];

foreach ($data as $coords) {
    Accident::create([
        'latitude' => $coords[0],
        'longitude' => $coords[1],
        'severity' => rand(0, 2) // Misalnya, random severity untuk testing
    ]);
}
