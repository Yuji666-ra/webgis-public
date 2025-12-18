<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccidentZone; // Misal ada model AccidentZone untuk database

class OverviewController extends Controller
{
    public function index()
    {
        // Ambil semua data daerah rawan kecelakaan
        $zones = AccidentZone::all();

        return view('overview.index', compact('zones'));
    }
}
