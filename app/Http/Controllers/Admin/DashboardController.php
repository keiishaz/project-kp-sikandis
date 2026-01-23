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
            $pajakAktif = Kendaraan::whereRaw("date(CASE WHEN length(pajak) = 7 THEN pajak || '-01' ELSE pajak END) >= date('now','start of month')")->count();
            $pajakMati = Kendaraan::whereRaw("date(CASE WHEN length(pajak) = 7 THEN pajak || '-01' ELSE pajak END) < date('now','start of month')")->count();
        } elseif ($driver === 'pgsql') {
            $pajakAktif = Kendaraan::whereRaw("to_date(CASE WHEN length(pajak) = 7 THEN pajak || '-01' ELSE pajak END, 'YYYY-MM-DD') >= date_trunc('month', now())::date")->count();
            $pajakMati = Kendaraan::whereRaw("to_date(CASE WHEN length(pajak) = 7 THEN pajak || '-01' ELSE pajak END, 'YYYY-MM-DD') < date_trunc('month', now())::date")->count();
        } else {
            $pajakAktif = Kendaraan::whereRaw("STR_TO_DATE(IF(LENGTH(pajak)=7, CONCAT(pajak, '-01'), pajak), '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01')")->count();
            $pajakMati = Kendaraan::whereRaw("STR_TO_DATE(IF(LENGTH(pajak)=7, CONCAT(pajak, '-01'), pajak), '%Y-%m-%d') < DATE_FORMAT(CURDATE(), '%Y-%m-01')")->count();
        }

        // Logic Pajak Akan Mati (Bulan ini atau Bulan Depan)
        $currentMonth = now()->format('Y-m');
        $nextMonth = now()->addMonth()->format('Y-m');
        // Check using substring to match YYYY-MM part regardless of full date
        $pajakAkanMati = Kendaraan::whereRaw("SUBSTR(pajak, 1, 7) IN (?, ?)", [$currentMonth, $nextMonth])->count();

        $latest = Kendaraan::latest()->take(7)->get();

        return view('admin.dashboard', compact('total', 'pajakAktif', 'pajakMati', 'pajakAkanMati', 'latest'));
    }
}
