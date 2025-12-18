<?php

namespace App\Http\Controllers;

use App\Models\Accident;
use Illuminate\Http\Request;

class RiskMapController extends Controller
{
    public function index()
    {
        // Ambil semua data accident
        $accidents = Accident::all();

        return view('peta_risiko', compact('accidents'));
    }
}
