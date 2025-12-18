<?php

namespace App\Http\Controllers;

use App\Models\Accident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UploadCsvController extends Controller
{
    public function uploadCsv(Request $request)
    {
        // Validasi file yang diupload harus berupa CSV
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $file = $request->file('file');
        $filePath = $file->getRealPath();

        // Buka file CSV dan baca setiap barisnya
        if (($handle = fopen($filePath, 'r')) !== false) {
            // Lewati baris header
            fgetcsv($handle, 1000, "\t");

            // Baca data baris per baris
            while (($data = fgetcsv($handle, 1000, "\t")) !== false) {
                // Buat array dengan data sesuai struktur CSV
                Accident::create([
                    'severity' => $data[1],             // Tingkat Kecelakaan
                    'deaths' => $data[2],               // Jumlah Meninggal Dunia
                    'injuries' => $data[3],             // Jumlah Korban Luka
                    'serious_injuries' => $data[4],     // Jumlah Luka Berat
                    'minor_injuries' => $data[5],       // Jumlah Luka Ringan
                    'latitude' => $data[6],             // Koordinat GPS - Lintang
                    'longitude' => $data[7],            // Koordinat GPS - Bujur
                    'cluster' => $data[8],              // Cluster
                ]);
            }
            fclose($handle);
        }

        return redirect()->back()->with('success', 'Data CSV berhasil diunggah dan disimpan ke database.');
    }
}
