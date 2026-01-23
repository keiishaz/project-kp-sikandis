@extends('layouts.dashboard')

@section('title', 'Operator - Edit Kendaraan')
@section('topbar_title', 'Edit Kendaraan')

@section('content')
    <section class="form-container" style="width: 100%; margin: 0 auto;">
        <form method="POST" action="{{ route('operator.kendaraan.update', $kendaraan) }}">
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

            {{-- SECTION 1: DATA PEMEGANG --}}
            <div class="form-section">
                <h3 class="section-title">Data Pemegang</h3>
                <div class="grid-2">
                    <div class="form-field">
                        <label for="pemegang">Nama Pemegang</label>
                        <input id="pemegang" name="pemegang" value="{{ old('pemegang', $kendaraan->pemegang) }}" required placeholder="Masukkan nama pemegang">
                        @error('pemegang')<div class="error-text">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-field">
                        <label for="nip">NIP</label>
                        <input id="nip" name="nip" value="{{ old('nip', $kendaraan->nip) }}" required placeholder="Masukkan NIP">
                        @error('nip')<div class="error-text">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-field">
                        <label for="jabatan">Jabatan</label>
                        <input id="jabatan" name="jabatan" value="{{ old('jabatan', $kendaraan->jabatan) }}" required placeholder="Masukkan jabatan">
                        @error('jabatan')<div class="error-text">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-field">
                        <label for="unit_kerja">Unit Kerja</label>
                        <input id="unit_kerja" name="unit_kerja" value="{{ old('unit_kerja', $kendaraan->unit_kerja) }}" required placeholder="Masukkan unit kerja">
                        @error('unit_kerja')<div class="error-text">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- SECTION 2: IDENTITAS KENDARAAN --}}
            <div class="form-section">
                <h3 class="section-title">Identitas Kendaraan</h3>
                <div class="grid-2">
                    <div class="form-field">
                        <label for="nama_kendaraan">Nama Kendaraan</label>
                        <input id="nama_kendaraan" name="nama_kendaraan" value="{{ old('nama_kendaraan', $kendaraan->nama_kendaraan) }}" required placeholder="Contoh: Toyota Avanza">
                        @error('nama_kendaraan')<div class="error-text">{{ $message }}</div>@enderror
                    </div>
                    
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
                           <input aria-label="Wilayah" name="no_polisi_wilayah" value="{{ old('no_polisi_wilayah', $plateWilayah) }}" placeholder="BD" required style="text-align: center;">
                           <input aria-label="Angka" name="no_polisi_angka" value="{{ old('no_polisi_angka', $plateAngka) }}" placeholder="1234" required style="text-align: center; flex: 2;">
                           <input aria-label="Huruf" name="no_polisi_huruf" value="{{ old('no_polisi_huruf', $plateHuruf) }}" placeholder="XY" required style="text-align: center;">
                       </div>
                       @error('no_polisi')<div class="error-text">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-field">
                        <label for="jenis">Jenis Kendaraan</label>
                        <select id="jenis" name="jenis" required onchange="toggleLokasi()">
                            <option value="jabatan" {{ old('jenis', $currentJenis) === 'jabatan' ? 'selected' : '' }}>Kendaraan Dinas Jabatan</option>
                            <option value="operasional" {{ old('jenis', $currentJenis) === 'operasional' ? 'selected' : '' }}>Kendaraan Dinas Operasional</option>
                        </select>
                        @error('jenis')<div class="error-text">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-field" id="lokasi_field" style="display: none;">
                        <label for="lokasi" style="display: block; margin-bottom: 0.5rem;">Lokasi Operasional</label>
                        <input id="lokasi" name="lokasi" value="{{ old('lokasi', $currentLokasi) }}" placeholder="Contoh: Balaikota Merah Putih" style="width: 100%;">
                        @error('lokasi')<div class="error-text">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- SECTION 3: DETAIL TEKNIS & PAJAK --}}
            <div class="form-section">
                <h3 class="section-title">Detail Teknis & Pajak</h3>
                <div class="grid-3">
                    <div class="form-field">
                        <label for="thn_kendaraan">Tahun Pembuatan</label>
                         <select id="thn_kendaraan" name="thn_kendaraan" required>
                            <option value="">Pilih Tahun</option>
                            @php
                                $thn_skrg = date('Y');
                            @endphp
                            @for($y = $thn_skrg + 1; $y >= 1980; $y--)
                                <option value="{{ $y }}" {{ old('thn_kendaraan', $kendaraan->thn_kendaraan) == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                        @error('thn_kendaraan')<div class="error-text">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-field">
                        <label for="no_rangka">No Rangka</label>
                        <input id="no_rangka" name="no_rangka" value="{{ old('no_rangka', $kendaraan->no_rangka) }}" required placeholder="Nomor Rangka">
                        @error('no_rangka')<div class="error-text">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-field">
                        <label for="no_mesin">No Mesin</label>
                        <input id="no_mesin" name="no_mesin" value="{{ old('no_mesin', $kendaraan->no_mesin) }}" required placeholder="Nomor Mesin">
                        @error('no_mesin')<div class="error-text">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="form-field" style="margin-top: 1rem;">
                    <label for="pajak_tgl">Jatuh Tempo Pajak</label>
                     @php
                        // Logic fallback date
                        $pajakValue = $kendaraan->pajak;
                        // If stored as YYYY-MM (7 chars), append -01 to make it valid for date input
                        if (strlen($pajakValue) === 7) {
                            $pajakValue .= '-01';
                        }
                    @endphp
                    <input id="pajak_tgl" name="pajak_tgl" type="date" value="{{ old('pajak_tgl', $pajakValue) }}" required style="max-width: 300px;">
                    <small style="display: block; color: var(--gray-500); margin-top: 0.25rem;">Pilih tanggal jatuh tempo pajak</small>
                    @error('pajak_tgl')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-actions" style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
                <a class="btn" href="{{ route('operator.kendaraan.index') }}" style="background: white; border: 1px solid var(--gray-300);">Batal</a>
                <button class="btn btn-primary" type="submit" style="padding-left: 2rem; padding-right: 2rem;">Simpan Perubahan</button>
            </div>
        </form>
    </section>

    <script>
        function toggleLokasi() {
            const jenis = document.getElementById('jenis').value;
            const lokasiField = document.getElementById('lokasi_field');
            const lokasiInput = document.getElementById('lokasi');

            if (jenis === 'operasional') {
                lokasiField.style.display = 'block';
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
    
    <style>
        .form-section {
            background: #fff;
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .section-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--gray-100);
        }
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        .grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1.5rem;
        }
        @media (max-width: 768px) {
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
        }
    </style>
@endsection
