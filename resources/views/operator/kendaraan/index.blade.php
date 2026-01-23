@extends('layouts.dashboard')

@section('title', 'Operator - Data Kendaraan')
@section('topbar_title', 'Data Kendaraan')

@section('content')
    <section class="table-container">
        <!-- Header Section -->
        <div class="table-header">
            <h3 class="table-title">Data Kendaraan</h3>
            <div class="table-header-actions">
                <a href="{{ route('operator.kendaraan.create') }}" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Tambah</span>
                </a>
                <a href="{{ route('operator.kendaraan.export', request()->query()) }}" class="btn btn-outline">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Export</span>
                </a>
            </div>
        </div>

        <!-- Search & Filter Toolbar -->
        <form class="table-toolbar" method="GET" action="{{ route('operator.kendaraan.index') }}">
            <div class="table-toolbar-inner">
                <!-- Auto-Search Input -->
                <div class="toolbar-field">
                    <input type="search" 
                           name="q" 
                           class="table-search-input"
                           placeholder="Cari No. Polisi, Nama, atau Pemegang..." 
                           value="{{ request('q') }}"
                           autocomplete="off">
                </div>

                <!-- Status Filter -->
                <div class="toolbar-field">
                    <select name="status" class="table-filter-select">
                        <option value="">Semua Status Pajak</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Pajak Hidup</option>
                        <option value="mati" {{ request('status') == 'mati' ? 'selected' : '' }}>Pajak Mati</option>
                    </select>
                </div>

                 <!-- Jenis Filter -->
                 <div class="toolbar-field">
                    <select name="jenis" class="table-filter-select">
                        <option value="">Semua Jenis Kendaraan</option>
                        <option value="Kendaraan Dinas Jabatan" {{ request('jenis') == 'Kendaraan Dinas Jabatan' ? 'selected' : '' }}>Dinas Jabatan</option>
                        <option value="Kendaraan Dinas Operasional" {{ request('jenis') == 'Kendaraan Dinas Operasional' ? 'selected' : '' }}>Dinas Operasional</option>
                    </select>
                </div>
            </div>
        </form>

        <!-- Data Table -->
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="col-kendaraan">Kendaraan</th>
                        <th class="col-pemegang">Pemegang</th>
                        <th class="col-jenis">Jenis</th>
                        <th class="col-pajak">Status Pajak</th>
                        <th class="col-actions">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kendaraan as $k)
                        <tr>
                            <!-- Kendaraan -->
                            <td class="col-kendaraan" data-label="Kendaraan">
                                <div class="vehicle-info">
                                    <div class="vehicle-plate">{{ $k->no_polisi }}</div>
                                    <div class="vehicle-name">{{ $k->nama_kendaraan }}</div>
                                </div>
                            </td>
                            
                            <!-- Pemegang -->
                            <td class="col-pemegang" data-label="Pemegang">
                                <div class="holder-text font-semibold">{{ $k->pemegang }}</div>
                                <div class="text-xs text-gray-500">{{ $k->jabatan }}</div>
                            </td>
                            
                            <!-- Jenis -->
                            <td class="col-jenis" data-label="Jenis">
                                <span class="type-badge">
                                    {{ ucfirst($k->jenis == 'Kendaraan Dinas Jabatan' ? 'Jabatan' : 'Operasional') }}
                                </span>
                            </td>
                            
                            <!-- Status Pajak -->
                            <td class="col-pajak" data-label="Status Pajak">
                                <span class="status-badge {{ $k->pajak_is_active ? 'active' : 'inactive' }}">
                                    {{ $k->pajak_is_active ? 'HIDUP' : 'MATI' }}
                                </span>
                                <div class="tax-date mt-1">{{ $k->pajak_label }}</div>
                            </td>
                            
                            <!-- Actions -->
                            <td class="col-actions" data-label="Aksi">
                                <div class="action-buttons">
                                    <a href="{{ route('operator.kendaraan.show', $k) }}" class="btn-action btn-detail" title="Detail">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </a>
                                    <a href="{{ route('operator.kendaraan.edit', $k) }}" class="btn-action btn-edit" title="Edit">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('operator.kendaraan.destroy', $k) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data kendaraan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" title="Hapus">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                <div class="empty-content">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="8" x2="12" y2="12"></line>
                                        <line x1="12" y1="16" x2="12" y2="16"></line>
                                    </svg>
                                    <p>Data kendaraan tidak ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $kendaraan->links('pagination.sikandis') }}
        </div>
    </section>
@endsection
