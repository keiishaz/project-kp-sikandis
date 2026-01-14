@extends('layouts.dashboard')

@section('title', 'Operator - Data Kendaraan')
@section('topbar_title', 'Data Kendaraan')

@section('content')
    <section class="table-container">
        <div class="table-header">
            <h3 class="table-title">Data Kendaraan</h3>
            <div class="table-header-actions">
                <button type="button" class="btn btn-primary" data-modal-open="modal-operator-kendaraan-create">Tambah</button>
                <a class="btn btn-sm" href="{{ route('operator.kendaraan.export', request()->query()) }}">Export Excel</a>
            </div>
        </div>

        <form class="table-toolbar" method="GET" action="{{ route('operator.kendaraan.index') }}">
            <div class="table-toolbar-left">
                <div class="toolbar-field">
                    <input type="text" name="q" placeholder="Cari nama / no polisi / pemegang / QR" value="{{ request('q') }}">
                </div>
                <div class="toolbar-field">
                    <select name="status">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="mati" {{ request('status') === 'mati' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            </div>
            <div class="table-toolbar-right">
                <button class="btn btn-sm btn-primary" type="submit">Terapkan</button>
                <a class="btn btn-sm" href="{{ route('operator.kendaraan.index') }}">Reset</a>
            </div>
        </form>

        @php
            $baseQuery = request()->except('page');
            $currentSort = request('sort');
            $currentDir = request('dir');

            $sortLink = function (string $key) use ($baseQuery, $currentSort, $currentDir) {
                $dir = ($currentSort === $key && $currentDir === 'asc') ? 'desc' : 'asc';
                return route('operator.kendaraan.index', array_merge($baseQuery, ['sort' => $key, 'dir' => $dir]));
            };

            $sortIndicator = function (string $key) use ($currentSort, $currentDir) {
                if ($currentSort !== $key) return '';
                return $currentDir === 'asc' ? '▲' : '▼';
            };
        @endphp

        <table class="data-table">
            <thead>
                <tr>
                    <th><a class="sort-link" href="{{ $sortLink('kode_qr') }}">Kode QR <span class="sort-indicator">{{ $sortIndicator('kode_qr') }}</span></a></th>
                    <th><a class="sort-link" href="{{ $sortLink('nama_kendaraan') }}">Nama Kendaraan <span class="sort-indicator">{{ $sortIndicator('nama_kendaraan') }}</span></a></th>
                    <th><a class="sort-link" href="{{ $sortLink('no_polisi') }}">No Polisi <span class="sort-indicator">{{ $sortIndicator('no_polisi') }}</span></a></th>
                    <th><a class="sort-link" href="{{ $sortLink('jenis') }}">Jenis <span class="sort-indicator">{{ $sortIndicator('jenis') }}</span></a></th>
                    <th><a class="sort-link" href="{{ $sortLink('pemegang') }}">Pemegang <span class="sort-indicator">{{ $sortIndicator('pemegang') }}</span></a></th>
                    <th class="col-pajak"><a class="sort-link" href="{{ $sortLink('pajak') }}">Pajak <span class="sort-indicator">{{ $sortIndicator('pajak') }}</span></a></th>
                    <th class="col-actions">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kendaraan as $k)
                    <tr>
                        <td>{{ $k->kode_qr }}</td>
                        <td class="font-semibold">{{ $k->nama_kendaraan }}</td>
                        <td>{{ $k->no_polisi }}</td>
                        <td>{{ ucfirst($k->jenis) }}</td>
                        <td>{{ $k->pemegang }}</td>
                        <td class="col-pajak">
                            <div class="pajak-info">
                                <span>{{ $k->pajak_label }}</span>
                                <span class="status-badge {{ $k->pajak_is_active ? 'active' : 'inactive' }}">
                                    {{ $k->pajak_is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                        </td>
                        <td class="col-actions">
                            <div class="action-buttons">
                                <a class="btn btn-sm" href="{{ route('operator.kendaraan.show', $k) }}">Detail</a>
                                <a class="btn btn-primary btn-sm" href="{{ route('operator.kendaraan.edit', $k) }}">Edit</a>
                                <form method="POST" action="{{ route('operator.kendaraan.destroy', $k) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $kendaraan->links('pagination.sikandis') }}
    </section>

    <div class="modal-overlay {{ $errors->any() ? 'active' : '' }}" id="modal-operator-kendaraan-create">
        <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-operator-kendaraan-create-title">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-operator-kendaraan-create-title">Tambah Kendaraan</h3>
                <button type="button" class="modal-close" data-modal-close="modal-operator-kendaraan-create">✕</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('operator.kendaraan.store') }}">
                    @csrf

                    <div class="form-grid">
                        <div class="form-field">
                            <label for="om_kode_qr">Kode QR</label>
                            <input id="om_kode_qr" name="kode_qr" value="{{ old('kode_qr') }}" required>
                            @error('kode_qr')<div class="error-text">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-field">
                            <label for="om_jenis">Jenis</label>
                            <select id="om_jenis" name="jenis" required>
                                <option value="operasional" {{ old('jenis') === 'operasional' ? 'selected' : '' }}>Operasional</option>
                                <option value="jabatan" {{ old('jenis') === 'jabatan' ? 'selected' : '' }}>Jabatan</option>
                            </select>
                            @error('jenis')<div class="error-text">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-field">
                            <label for="om_nama_kendaraan">Nama Kendaraan</label>
                            <input id="om_nama_kendaraan" name="nama_kendaraan" value="{{ old('nama_kendaraan') }}" required>
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
                            <label for="om_thn_kendaraan">Tahun Kendaraan</label>
                            <input id="om_thn_kendaraan" name="thn_kendaraan" type="number" value="{{ old('thn_kendaraan') }}" required>
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
                                <select id="om_pajak_bulan" name="pajak_bulan" required>
                                    @foreach($bulanMap as $num => $label)
                                        <option value="{{ $num }}" {{ $selectedBulan === $num ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <select id="om_pajak_tahun" name="pajak_tahun" required>
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
                            <label for="om_no_rangka">No Rangka</label>
                            <input id="om_no_rangka" name="no_rangka" value="{{ old('no_rangka') }}" required>
                            @error('no_rangka')<div class="error-text">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-field">
                            <label for="om_no_mesin">No Mesin</label>
                            <input id="om_no_mesin" name="no_mesin" value="{{ old('no_mesin') }}" required>
                            @error('no_mesin')<div class="error-text">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-field">
                            <label for="om_pemegang">Pemegang</label>
                            <input id="om_pemegang" name="pemegang" value="{{ old('pemegang') }}" required>
                            @error('pemegang')<div class="error-text">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-field">
                            <label for="om_nip">NIP</label>
                            <input id="om_nip" name="nip" value="{{ old('nip') }}" required>
                            @error('nip')<div class="error-text">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-field">
                            <label for="om_jabatan">Jabatan</label>
                            <input id="om_jabatan" name="jabatan" value="{{ old('jabatan') }}" required>
                            @error('jabatan')<div class="error-text">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-field">
                            <label for="om_unit_kerja">Unit Kerja</label>
                            <input id="om_unit_kerja" name="unit_kerja" value="{{ old('unit_kerja') }}" required>
                            @error('unit_kerja')<div class="error-text">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn" data-modal-close="modal-operator-kendaraan-create">Batal</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
