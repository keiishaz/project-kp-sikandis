@extends('layouts.dashboard')

@section('title', 'Admin - Edit Kendaraan')
@section('topbar_title', 'Edit Kendaraan')

@section('content')
@section('content')
    <section class="form-container">
        <form method="POST" action="{{ route('admin.kendaraan.update', $kendaraan) }}">
            @csrf
            @method('PUT')

            {{-- Parsing Logic for Jenis & Lokasi --}}
            @php
                $jenisDb = $kendaraan->jenis; 
                $isOperasional = \Illuminate\Support\Str::contains($jenisDb, 'Operasional');
                $currentJenis = $isOperasional ? 'operasional' : 'jabatan';
                
                // Extract location if Operasional
                $currentLokasi = '';
                if ($isOperasional) {
                    $currentLokasi = trim(str_replace('Kendaraan Dinas Operasional', '', $jenisDb));
                }
            @endphp

            {{-- Vertical Layout Matching Create --}}
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                
                {{-- 1. Pemegang --}}
                <div class="form-field">
                    <label for="pemegang">Pemegang</label>
                    <input id="pemegang" name="pemegang" value="{{ old('pemegang', $kendaraan->pemegang) }}" required>
                    @error('pemegang')<div class="error-text">{{ $message }}</div>@enderror
                </div>

                {{-- 2. NIP --}}
                <div class="form-field">
                    <label for="nip">NIP</label>
                    <input id="nip" name="nip" value="{{ old('nip', $kendaraan->nip) }}" required>
                    @error('nip')<div class="error-text">{{ $message }}</div>@enderror
                </div>

                {{-- 3. Jabatan --}}
                <div class="form-field">
                    <label for="jabatan">Jabatan</label>
                    <input id="jabatan" name="jabatan" value="{{ old('jabatan', $kendaraan->jabatan) }}" required>
                    @error('jabatan')<div class="error-text">{{ $message }}</div>@enderror
                </div>

                {{-- 4. Unit Kerja --}}
                <div class="form-field">
                    <label for="unit_kerja">Unit Kerja</label>
                    <input id="unit_kerja" name="unit_kerja" value="{{ old('unit_kerja', $kendaraan->unit_kerja) }}" required>
                    @error('unit_kerja')<div class="error-text">{{ $message }}</div>@enderror
                </div>

                {{-- 5. Nama Kendaraan --}}
                <div class="form-field">
                    <label for="nama_kendaraan">Nama Kendaraan</label>
                    <input id="nama_kendaraan" name="nama_kendaraan" value="{{ old('nama_kendaraan', $kendaraan->nama_kendaraan) }}" required>
                    @error('nama_kendaraan')<div class="error-text">{{ $message }}</div>@enderror
                </div>

                {{-- 6. No Polisi --}}
                <div class="form-field">
                    <label>No Polisi</label>
                    @php
                        $plateWilayah = '';
                        $plateAngka = '';
                        $plateHuruf = '';

                        if (is_string($kendaraan->no_polisi) && preg_match('/^\s*([A-Za-z]{1,3})\s*([0-9]{1,4})\s*([A-Za-z]{1,3})\s*$/', $kendaraan->no_polisi, $m)) {
                            $plateWilayah = strtoupper($m[1]);
                            $plateAngka = $m[2];
                            $plateHuruf = strtoupper($m[3]);
                        } elseif (is_string($kendaraan->no_polisi) && preg_match('/^\s*([A-Za-z]{1,3})\s+([0-9]{1,4})\s+([A-Za-z]{1,3})\s*$/', $kendaraan->no_polisi, $m)) {
                            $plateWilayah = strtoupper($m[1]);
                            $plateAngka = $m[2];
                            $plateHuruf = strtoupper($m[3]);
                        }
                    @endphp
                    <div class="plate-grid">
                        <input aria-label="Wilayah" name="no_polisi_wilayah" value="{{ old('no_polisi_wilayah', $plateWilayah) }}" placeholder="B/BD" required>
                        <input aria-label="Angka" name="no_polisi_angka" value="{{ old('no_polisi_angka', $plateAngka) }}" placeholder="1234" required>
                        <input aria-label="Huruf" name="no_polisi_huruf" value="{{ old('no_polisi_huruf', $plateHuruf) }}" placeholder="AB" required>
                    </div>
                    @error('no_polisi')<div class="error-text">{{ $message }}</div>@enderror
                </div>

                {{-- 7. Tahun Kendaraan --}}
                <div class="form-field">
                    <label for="thn_kendaraan">Tahun Kendaraan</label>
                    <input id="thn_kendaraan" name="thn_kendaraan" type="number" value="{{ old('thn_kendaraan', $kendaraan->thn_kendaraan) }}" required>
                    @error('thn_kendaraan')<div class="error-text">{{ $message }}</div>@enderror
                </div>

                {{-- 8. No Rangka --}}
                <div class="form-field">
                    <label for="no_rangka">No Rangka</label>
                    <input id="no_rangka" name="no_rangka" value="{{ old('no_rangka', $kendaraan->no_rangka) }}" required>
                    @error('no_rangka')<div class="error-text">{{ $message }}</div>@enderror
                </div>

                {{-- 9. No Mesin --}}
                <div class="form-field">
                    <label for="no_mesin">No Mesin</label>
                    <input id="no_mesin" name="no_mesin" value="{{ old('no_mesin', $kendaraan->no_mesin) }}" required>
                    @error('no_mesin')<div class="error-text">{{ $message }}</div>@enderror
                </div>

                {{-- 10. Pajak --}}
                <div class="form-field">
                    <label>Pajak</label>
                    @php
                        $bulanMap = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                        ];
                        // Parse existing pajak string usually YYYY-MM
                        $pajakParts = explode('-', $kendaraan->pajak ?? '');
                        $dbYear = isset($pajakParts[0]) ? (int)$pajakParts[0] : now()->year;
                        $dbMonth = isset($pajakParts[1]) ? (int)$pajakParts[1] : now()->month;

                        $selectedBulan = (int) old('pajak_bulan', $dbMonth);
                        $selectedYear = (int) old('pajak_tahun', $dbYear);
                        
                        $startYear = now()->year - 5;
                        $endYear = now()->year + 5;
                    @endphp
                    <div class="pajak-grid">
                        <select id="pajak_bulan" name="pajak_bulan" required>
                            @foreach($bulanMap as $num => $label)
                                <option value="{{ $num }}" {{ $selectedBulan === $num ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <select id="pajak_tahun" name="pajak_tahun" required>
                            @for($y = $startYear; $y <= $endYear; $y++)
                                <option value="{{ $y }}" {{ $selectedYear === $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    @error('pajak_bulan')<div class="error-text">{{ $message }}</div>@enderror
                    @error('pajak_tahun')<div class="error-text">{{ $message }}</div>@enderror
                </div>

                {{-- 11. Jenis Kendaraan --}}
                <div class="form-field">
                    <label for="jenis">Jenis Kendaraan</label>
                    <select id="jenis" name="jenis" required onchange="toggleLokasi()">
                        <option value="jabatan" {{ old('jenis', $currentJenis) === 'jabatan' ? 'selected' : '' }}>Kendaraan Dinas Jabatan</option>
                        <option value="operasional" {{ old('jenis', $currentJenis) === 'operasional' ? 'selected' : '' }}>Kendaraan Dinas Operasional</option>
                    </select>
                    @error('jenis')<div class="error-text">{{ $message }}</div>@enderror
                </div>

                <div class="form-field" id="lokasi_field" style="display: none;">
                    <label for="lokasi">Lokasi Operasional</label>
                    <input id="lokasi" name="lokasi" value="{{ old('lokasi', $currentLokasi) }}" placeholder="Contoh: Balaikota Merah Putih">
                    @error('lokasi')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                <a class="btn" href="{{ route('admin.kendaraan.index') }}">Batal</a>
            </div>
        </form>
    </section>

    <script>
        function toggleLokasi() {
            const jenis = document.getElementById('jenis').value;
            const lokasiField = document.getElementById('lokasi_field');
            const lokasiInput = document.getElementById('lokasi');

            if (jenis === 'operasional') {
                lokasiField.style.display = 'flex';
                lokasiInput.setAttribute('required', 'required');
            } else {
                lokasiField.style.display = 'none';
                lokasiInput.removeAttribute('required');
                lokasiInput.value = ''; // Clear value if hidden
            }
        }

        // Run on load to set initial state
        document.addEventListener('DOMContentLoaded', toggleLokasi);
    </script>
@endsection
