<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $total = Kendaraan::count();
        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            $pajakAktif = Kendaraan::whereRaw("date(pajak || '-01') >= date('now','start of month')")->count();
            $pajakMati = Kendaraan::whereRaw("date(pajak || '-01') < date('now','start of month')")->count();
        } elseif ($driver === 'pgsql') {
            $pajakAktif = Kendaraan::whereRaw("to_date(pajak || '-01', 'YYYY-MM-DD') >= date_trunc('month', now())::date")->count();
            $pajakMati = Kendaraan::whereRaw("to_date(pajak || '-01', 'YYYY-MM-DD') < date_trunc('month', now())::date")->count();
        } else {
            $pajakAktif = Kendaraan::whereRaw("STR_TO_DATE(CONCAT(pajak,'-01'), '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01')")->count();
            $pajakMati = Kendaraan::whereRaw("STR_TO_DATE(CONCAT(pajak,'-01'), '%Y-%m-%d') < DATE_FORMAT(CURDATE(), '%Y-%m-01')")->count();
        }

        // Logic Pajak Akan Mati (Bulan ini atau Bulan Depan)
        $currentMonth = now()->format('Y-m');
        $nextMonth = now()->addMonth()->format('Y-m');
        $pajakAkanMati = Kendaraan::whereIn('pajak', [$currentMonth, $nextMonth])->count();

        $latest = Kendaraan::latest()->take(7)->get();

        return view('admin.dashboard', compact('total', 'pajakAktif', 'pajakMati', 'pajakAkanMati', 'latest'));
    }
}
