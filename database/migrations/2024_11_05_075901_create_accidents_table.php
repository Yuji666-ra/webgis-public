<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accidents', function (Blueprint $table) {
            $table->id();
            $table->string('severity');          // Tingkat Kecelakaan
            $table->integer('deaths');           // Jumlah Meninggal Dunia
            $table->integer('injuries');         // Jumlah Korban Luka
            $table->integer('serious_injuries'); // Jumlah Luka Berat
            $table->integer('minor_injuries');   // Jumlah Luka Ringan
            $table->decimal('latitude', 10, 8);  // Koordinat GPS - Lintang
            $table->decimal('longitude', 11, 8); // Koordinat GPS - Bujur
            $table->integer('cluster');          // Cluster
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accidents');
    }
};

