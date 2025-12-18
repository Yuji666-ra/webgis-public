<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetaClusterController;
use App\Http\Controllers\StatistikController;

/*
|--------------------------------------------------------------------------
| Web Routes - FINAL (Hosting Gratis Friendly)
|--------------------------------------------------------------------------
| View: resources/views/pages/
| Asset: public/ (via Vite build)
| GeoJSON: public/data/
|--------------------------------------------------------------------------
*/

// Landing Page
Route::view('/', 'pages.landing')->name('landing');

// Static Pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');

// Dynamic Pages
Route::get('/peta-cluster', [PetaClusterController::class, 'index'])
    ->name('peta.cluster');

Route::get('/statistik', [StatistikController::class, 'index'])
    ->name('statistik');

    Route::get('/healthz', function() {
    return response()->json(['status' => 'ok']);
});
