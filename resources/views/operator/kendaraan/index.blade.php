@extends('layouts.dashboard')

@section('title', 'Operator - Data Kendaraan')
@section('topbar_title', 'Data Kendaraan')

@section('content')
    <section class="table-container">
        <div class="table-header">
            <h3 class="table-title">Data Kendaraan</h3>
            <div class="table-header-actions">
                <a href="{{ route('operator.kendaraan.create') }}" class="btn btn-primary">Tambah</a>
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
                    <th><a class="sort-link" href="{{ $sortLink('pemegang') }}">Pemegang <span class="sort-indicator">{{ $sortIndicator('pemegang') }}</span></a></th>
                    <th><a class="sort-link" href="{{ $sortLink('nama_kendaraan') }}">Nama Kendaraan <span class="sort-indicator">{{ $sortIndicator('nama_kendaraan') }}</span></a></th>
                    <th><a class="sort-link" href="{{ $sortLink('no_polisi') }}">No Polisi <span class="sort-indicator">{{ $sortIndicator('no_polisi') }}</span></a></th>
                    <th><a class="sort-link" href="{{ $sortLink('jenis') }}">Jenis <span class="sort-indicator">{{ $sortIndicator('jenis') }}</span></a></th>
                    <th class="col-pajak"><a class="sort-link" href="{{ $sortLink('pajak') }}">Pajak <span class="sort-indicator">{{ $sortIndicator('pajak') }}</span></a></th>
                    <th class="col-actions">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kendaraan as $k)
                    <tr>
                        <td>{{ $k->pemegang }}</td>
                        <td class="font-semibold">{{ $k->nama_kendaraan }}</td>
                        <td>{{ $k->no_polisi }}</td>
                        <td>{{ ucfirst($k->jenis) }}</td>
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
                        <td colspan="6">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $kendaraan->links('pagination.sikandis') }}
    </section>
@endsection
