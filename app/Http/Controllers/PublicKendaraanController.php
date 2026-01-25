<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PublicKendaraanController extends Controller
{
    public function show($kode_qr)
    {
        $kendaraan = Kendaraan::where('kode_qr', $kode_qr)->first();

        if (!$kendaraan) {
            return view('umum.not-found');
        }

        return view('umum.public', compact('kendaraan'));
    }
}
