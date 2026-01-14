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

        $latest = Kendaraan::latest()->take(7)->get();

        return view('operator.dashboard', compact('total', 'pajakAktif', 'pajakMati', 'latest'));
    }
}
