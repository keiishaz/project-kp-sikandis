<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $total = Kendaraan::count();
        
        // Use model accessors for accurate counting (supports both Y-m and Y-m-d formats)
        $allVehicles = Kendaraan::all();
        
        $pajakAktif = $allVehicles->filter(function($k) {
            return $k->pajak_is_active;
        })->count();
        
        $pajakMati = $allVehicles->filter(function($k) {
            return !$k->pajak_is_active;
        })->count();
        
        $pajakAkanMati = $allVehicles->filter(function($k) {
            return $k->pajak_is_expiring_soon && $k->pajak_is_active;
        })->count();

        $latest = Kendaraan::latest()->take(3)->get();

        return view('operator.dashboard', compact('total', 'pajakAktif', 'pajakMati', 'pajakAkanMati', 'latest'));
    }
}
