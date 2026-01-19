<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KendaraanController extends Controller
{
    public function index()
    {
        $q = request()->query('q');
        $status = request()->query('status');
        $sort = request()->query('sort');
        $dir = request()->query('dir');

        $query = Kendaraan::query();

        if (is_string($q) && trim($q) !== '') {
            $q = trim($q);
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_kendaraan', 'like', '%' . $q . '%')
                    ->orWhere('no_polisi', 'like', '%' . $q . '%')
                    ->orWhere('pemegang', 'like', '%' . $q . '%')
                    ->orWhere('kode_qr', 'like', '%' . $q . '%');
            });
        }

        if ($status === 'aktif') {
            $driver = DB::connection()->getDriverName();
            if ($driver === 'sqlite') {
                $query->whereRaw("date(pajak || '-01') >= date('now','start of month')");
            } elseif ($driver === 'pgsql') {
                $query->whereRaw("to_date(pajak || '-01', 'YYYY-MM-DD') >= date_trunc('month', now())::date");
            } else {
                $query->whereRaw("STR_TO_DATE(CONCAT(pajak,'-01'), '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01')");
            }
        } elseif ($status === 'mati') {
            $driver = DB::connection()->getDriverName();
            if ($driver === 'sqlite') {
                $query->whereRaw("date(pajak || '-01') < date('now','start of month')");
            } elseif ($driver === 'pgsql') {
                $query->whereRaw("to_date(pajak || '-01', 'YYYY-MM-DD') < date_trunc('month', now())::date");
            } else {
                $query->whereRaw("STR_TO_DATE(CONCAT(pajak,'-01'), '%Y-%m-%d') < DATE_FORMAT(CURDATE(), '%Y-%m-01')");
            }
        }

        $allowedSorts = ['created_at', 'kode_qr', 'nama_kendaraan', 'no_polisi', 'jenis', 'pemegang', 'pajak'];
        $direction = in_array($dir, ['asc', 'desc'], true) ? $dir : 'desc';

        if (is_string($sort) && in_array($sort, $allowedSorts, true)) {
            $query->orderBy($sort, $direction);
        } else {
            $query->latest();
        }

        $kendaraan = $query->paginate(15)->appends(request()->query());

        return view('admin.kendaraan.index', compact('kendaraan'));
    }

    public function exportExcel(Request $request)
    {
        $q = $request->query('q');
        $status = $request->query('status');
        $sort = $request->query('sort');
        $dir = $request->query('dir');

        $query = Kendaraan::query();

        if (is_string($q) && trim($q) !== '') {
            $q = trim($q);
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_kendaraan', 'like', '%' . $q . '%')
                    ->orWhere('no_polisi', 'like', '%' . $q . '%')
                    ->orWhere('pemegang', 'like', '%' . $q . '%')
                    ->orWhere('kode_qr', 'like', '%' . $q . '%');
            });
        }

        if ($status === 'aktif') {
            $driver = DB::connection()->getDriverName();
            if ($driver === 'sqlite') {
                $query->whereRaw("date(pajak || '-01') >= date('now','start of month')");
            } elseif ($driver === 'pgsql') {
                $query->whereRaw("to_date(pajak || '-01', 'YYYY-MM-DD') >= date_trunc('month', now())::date");
            } else {
                $query->whereRaw("STR_TO_DATE(CONCAT(pajak,'-01'), '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01')");
            }
        } elseif ($status === 'mati') {
            $driver = DB::connection()->getDriverName();
            if ($driver === 'sqlite') {
                $query->whereRaw("date(pajak || '-01') < date('now','start of month')");
            } elseif ($driver === 'pgsql') {
                $query->whereRaw("to_date(pajak || '-01', 'YYYY-MM-DD') < date_trunc('month', now())::date");
            } else {
                $query->whereRaw("STR_TO_DATE(CONCAT(pajak,'-01'), '%Y-%m-%d') < DATE_FORMAT(CURDATE(), '%Y-%m-01')");
            }
        }

        $allowedSorts = ['created_at', 'kode_qr', 'nama_kendaraan', 'no_polisi', 'jenis', 'pemegang', 'pajak'];
        $direction = in_array($dir, ['asc', 'desc'], true) ? $dir : 'desc';
        if (is_string($sort) && in_array($sort, $allowedSorts, true)) {
            $query->orderBy($sort, $direction);
        } else {
            $query->latest();
        }

        $rows = $query->get();

        $esc = static fn ($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
        $filename = 'kendaraan-' . now()->format('Ymd-His') . '.xls';

        $html = "<html><head><meta charset=\"UTF-8\"></head><body>";
        $html .= "<table border=\"1\" cellpadding=\"4\" cellspacing=\"0\">";
        $html .= "<thead><tr>";
        $html .= "<th>Kode QR</th>";
        $html .= "<th>Jenis</th>";
        $html .= "<th>Nama Kendaraan</th>";
        $html .= "<th>No Polisi</th>";
        $html .= "<th>Tahun Kendaraan</th>";
        $html .= "<th>Pajak</th>";
        $html .= "<th>Status Pajak</th>";
        $html .= "<th>Pemegang</th>";
        $html .= "<th>NIP</th>";
        $html .= "<th>Jabatan</th>";
        $html .= "<th>Unit Kerja</th>";
        $html .= "<th>No Rangka</th>";
        $html .= "<th>No Mesin</th>";
        $html .= "</tr></thead><tbody>";

        foreach ($rows as $k) {
            $html .= "<tr>";
            $html .= "<td>" . $esc($k->kode_qr) . "</td>";
            $html .= "<td>" . $esc($k->jenis) . "</td>";
            $html .= "<td>" . $esc($k->nama_kendaraan) . "</td>";
            $html .= "<td>" . $esc($k->no_polisi) . "</td>";
            $html .= "<td>" . $esc($k->thn_kendaraan) . "</td>";
            $html .= "<td>" . $esc($k->pajak_label) . "</td>";
            $html .= "<td>" . $esc($k->pajak_is_active ? 'Aktif' : 'Tidak Aktif') . "</td>";
            $html .= "<td>" . $esc($k->pemegang) . "</td>";
            $html .= "<td>" . $esc($k->nip) . "</td>";
            $html .= "<td>" . $esc($k->jabatan) . "</td>";
            $html .= "<td>" . $esc($k->unit_kerja) . "</td>";
            $html .= "<td>" . $esc($k->no_rangka) . "</td>";
            $html .= "<td>" . $esc($k->no_mesin) . "</td>";
            $html .= "</tr>";
        }

        $html .= "</tbody></table></body></html>";

        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function create()
    {
        return view('admin.kendaraan.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateKendaraan($request);
        $validated['kode_qr'] = $this->generateKodeQr();

        Kendaraan::create($validated);

        return redirect()->route('admin.kendaraan.index');
    }

    public function edit(Kendaraan $kendaraan)
    {
        return view('admin.kendaraan.edit', compact('kendaraan'));
    }

    public function show($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        $qrUrl = url('/') . '/' . $kendaraan->kode_qr;

        return view('admin.kendaraan.show', compact('kendaraan', 'qrUrl'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $validated = $this->validateKendaraan($request, $kendaraan);

        $kendaraan->update($validated);

        return redirect()->route('admin.kendaraan.index');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        return redirect()->route('admin.kendaraan.index');
    }

    private function validateKendaraan(Request $request, ?Kendaraan $kendaraan = null): array
    {
        $data = $request->all();
        $wilayah = strtoupper(trim((string) ($data['no_polisi_wilayah'] ?? '')));
        $angka = trim((string) ($data['no_polisi_angka'] ?? ''));
        $huruf = strtoupper(trim((string) ($data['no_polisi_huruf'] ?? '')));
        $data['no_polisi'] = trim($wilayah . ' ' . $angka . ' ' . $huruf);

        $validated = Validator::make($data, [
            'pemegang' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'unit_kerja' => ['required', 'string', 'max:255'],
            'nama_kendaraan' => ['required', 'string', 'max:255'],
            'no_polisi_wilayah' => ['required', 'regex:/^[A-Za-z]{1,3}$/'],
            'no_polisi_angka' => ['required', 'regex:/^[0-9]{1,4}$/'],
            'no_polisi_huruf' => ['required', 'regex:/^[A-Za-z]{1,3}$/'],
            'no_polisi' => ['required', 'string', 'max:255', 'unique:kendaraan,no_polisi' . ($kendaraan ? (',' . $kendaraan->id) : '')],
            'thn_kendaraan' => ['required', 'integer'],
            'no_rangka' => ['required', 'string', 'max:255'],
            'no_mesin' => ['required', 'string', 'max:255'],
            'pajak_bulan' => ['required', 'integer', 'between:1,12'],
            'pajak_tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
            'jenis' => ['required', 'in:jabatan,operasional'],
            'lokasi' => ['nullable', 'string', 'required_if:jenis,operasional'],
        ], [
            'no_polisi.unique' => 'Nomor Polisi sudah terdaftar. Silakan gunakan nomor yang lain.',
            'jenis.in' => 'Jenis harus Kendaraan Dinas Jabatan atau Operasional.',
            'lokasi.required_if' => 'Lokasi wajib diisi untuk Kendaraan Dinas Operasional.',
            'no_polisi_wilayah.required' => 'Wilayah (huruf) wajib diisi.',
            'no_polisi_wilayah.regex' => 'Wilayah harus huruf 1-3 karakter (contoh: B atau BD).',
            'no_polisi_angka.required' => 'Nomor (angka) wajib diisi.',
            'no_polisi_angka.regex' => 'Nomor harus angka 1-4 digit (contoh: 1234).',
            'no_polisi_huruf.required' => 'Huruf belakang wajib diisi.',
            'no_polisi_huruf.regex' => 'Huruf belakang harus huruf 1-3 karakter (contoh: AB).',
        ])->validate();

        $validated['pajak'] = sprintf('%04d-%02d', (int) $validated['pajak_tahun'], (int) $validated['pajak_bulan']);
        unset($validated['pajak_bulan'], $validated['pajak_tahun']);

        // Handle Jenis Logic
        if ($validated['jenis'] === 'jabatan') {
            $validated['jenis'] = 'Kendaraan Dinas Jabatan';
        } else {
            // Operasional
            $lokasi = trim($validated['lokasi'] ?? '');
            $validated['jenis'] = 'Kendaraan Dinas Operasional ' . $lokasi;
        }
        unset($validated['lokasi']); // Remove extra field not in DB
        
        // Ensure kode_qr is set in validated array if it was filled by data
        if (isset($data['kode_qr']) && !isset($validated['kode_qr'])) {
             $validated['kode_qr'] = $data['kode_qr'];
        }

        unset($validated['no_polisi_wilayah'], $validated['no_polisi_angka'], $validated['no_polisi_huruf']);

        return $validated;
    }

    private function generateKodeQR(): string
    {
        $part1 = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3));
        $part2 = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3));

        $kode = "{$part1}-{$part2}";

        while (Kendaraan::where('kode_qr', $kode)->exists()) {
            $part1 = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3));
            $part2 = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3));
            $kode = "{$part1}-{$part2}";
        }

        return $kode;
    }

    public function printQr(Kendaraan $kendaraan)
{
    return view('admin.kendaraan.print-qr', compact('kendaraan'));
}


    public function regenerateQR(Kendaraan $kendaraan)
    {
        $kendaraan->update([
            'kode_qr' => $this->generateKodeQR()
        ]);

        return redirect()->back()->with('success', 'Kode QR berhasil diperbarui!');
    }

    
}
