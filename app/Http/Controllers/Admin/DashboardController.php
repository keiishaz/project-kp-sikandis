<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\ActivityLog;
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
        $activityLogs = ActivityLog::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('total', 'pajakAktif', 'pajakMati', 'pajakAkanMati', 'latest', 'activityLogs'));
    }
}
