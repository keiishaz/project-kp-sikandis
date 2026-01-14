@extends('layouts.dashboard')

@section('title', 'Operator - Tambah Kendaraan')
@section('topbar_title', 'Tambah Kendaraan')

@section('content')
    <section class="form-container">
        <form method="POST" action="{{ route('operator.kendaraan.store') }}">
            @csrf

            <div class="form-grid">
                <div class="form-field">
                    <label for="kode_qr">Kode QR</label>
                    <input id="kode_qr" name="kode_qr" value="{{ old('kode_qr') }}" required>
                    @error('kode_qr')<div class="error-text">{{ $message }}</div>@enderror
                </div>

                <div class="form-field">
                    <label for="jenis">Jenis</label>
                    <select id="jenis" name="jenis" required>
                        <option value="operasional" {{ old('jenis') === 'operasional' ? 'selected' : '' }}>Operasional</option>
                        <option value="jabatan" {{ old('jenis') === 'jabatan' ? 'selected' : '' }}>Jabatan</option>
                    </select>
                    @error('jenis')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-grid">
                <div class="form-field">
                    <label for="nama_kendaraan">Nama Kendaraan</label>
                    <input id="nama_kendaraan" name="nama_kendaraan" value="{{ old('nama_kendaraan') }}" required>
                    @error('nama_kendaraan')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div class="form-field">
                    <label>No Polisi</label>
                    <div class="plate-grid">
                        <input aria-label="Wilayah" name="no_polisi_wilayah" value="{{ old('no_polisi_wilayah') }}" placeholder="B/BD" required>
                        <input aria-label="Angka" name="no_polisi_angka" value="{{ old('no_polisi_angka') }}" placeholder="1234" required>
                        <input aria-label="Huruf" name="no_polisi_huruf" value="{{ old('no_polisi_huruf') }}" placeholder="AB" required>
                    </div>
                    @error('no_polisi_wilayah')<div class="error-text">{{ $message }}</div>@enderror
                    @error('no_polisi_angka')<div class="error-text">{{ $message }}</div>@enderror
                    @error('no_polisi_huruf')<div class="error-text">{{ $message }}</div>@enderror
                    @error('no_polisi')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-grid">
                <div class="form-field">
                    <label for="thn_kendaraan">Tahun Kendaraan</label>
                    <input id="thn_kendaraan" name="thn_kendaraan" type="number" value="{{ old('thn_kendaraan') }}" required>
                    @error('thn_kendaraan')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div class="form-field">
                    <label>Pajak</label>
                    @php
                        $bulanMap = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                        ];
                        $selectedBulan = (int) old('pajak_bulan', now()->month);
                        $startYear = now()->year - 5;
                        $endYear = now()->year + 5;
                        $selectedYear = (int) old('pajak_tahun', now()->year);
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
            </div>

            <div class="form-grid">
                <div class="form-field">
                    <label for="no_rangka">No Rangka</label>
                    <input id="no_rangka" name="no_rangka" value="{{ old('no_rangka') }}" required>
                    @error('no_rangka')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div class="form-field">
                    <label for="no_mesin">No Mesin</label>
                    <input id="no_mesin" name="no_mesin" value="{{ old('no_mesin') }}" required>
                    @error('no_mesin')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-grid">
                <div class="form-field">
                    <label for="pemegang">Pemegang</label>
                    <input id="pemegang" name="pemegang" value="{{ old('pemegang') }}" required>
                    @error('pemegang')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div class="form-field">
                    <label for="nip">NIP</label>
                    <input id="nip" name="nip" value="{{ old('nip') }}" required>
                    @error('nip')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-grid">
                <div class="form-field">
                    <label for="jabatan">Jabatan</label>
                    <input id="jabatan" name="jabatan" value="{{ old('jabatan') }}" required>
                    @error('jabatan')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div class="form-field">
                    <label for="unit_kerja">Unit Kerja</label>
                    <input id="unit_kerja" name="unit_kerja" value="{{ old('unit_kerja') }}" required>
                    @error('unit_kerja')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a class="btn" href="{{ route('operator.kendaraan.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection
