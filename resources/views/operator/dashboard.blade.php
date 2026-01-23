@extends('layouts.dashboard')

@section('title', 'Dashboard Operator - SIKANDIS')
@section('topbar_title', 'Dashboard Operator')

@section('content')
    <section class="summary-grid">
        <div class="summary-card" id="card-total">
            <div class="summary-header">
                <div class="summary-icon blue">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 18.5C19.25 18.5 20.5 17.38 20.5 16C20.5 14.62 19.25 13.5 18 13.5C16.75 13.5 15.5 14.62 15.5 16C15.5 17.38 16.75 18.5 18 18.5ZM19.5 9.5H17V12H21.46L19.5 9.5ZM6 18.5C7.25 18.5 8.5 17.38 8.5 16C8.5 14.62 7.25 13.5 6 13.5C4.75 13.5 3.5 14.62 3.5 16C3.5 17.38 4.75 18.5 6 18.5ZM20 8L23 12V17H21C21 18.66 19.66 20 18 20C16.34 20 15 18.66 15 17H9C9 18.66 7.66 20 6 20C4.34 20 3 18.66 3 17H1V6C1 4.9 1.9 4 3 4H17V8H20Z" fill="currentColor"/>
                    </svg>
                </div>
            </div>
            <div class="summary-value">{{ $total }}</div>
            <div class="summary-label">Total Kendaraan Terdaftar</div>
        </div>

        <div class="summary-card" id="card-pajak-aktif">
            <div class="summary-header">
                <div class="summary-icon green">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 16.17L4.83 12L3.41 13.41L9 19L21 7L19.59 5.59L9 16.17Z" fill="currentColor"/>
                    </svg>
                </div>
            </div>
            <div class="summary-value">{{ $pajakAktif }}</div>
            <div class="summary-label">Kendaraan Pajak Aktif</div>
        </div>

        <div class="summary-card" id="card-pajak-mati">
            <div class="summary-header">
                <div class="summary-icon red">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM7 11H17V13H7V11Z" fill="currentColor"/>
                    </svg>
                </div>
            </div>
            <div class="summary-value">{{ $pajakMati }}</div>
            <div class="summary-label">Kendaraan Pajak Mati</div>
        </div>

        <a href="{{ route('operator.kendaraan.index', ['status' => 'hampir_habis']) }}" style="text-decoration: none; color: inherit;">
            <div class="summary-card">
                <div class="summary-header">
                    <div class="summary-icon" style="color: #f59e0b; background: #fef3c7;">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.99 2C6.47 2 2 6.48 2 12C2 17.52 6.47 22 11.99 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 11.99 2ZM12 16.5C11.17 16.5 10.5 15.83 10.5 15C10.5 14.17 11.17 13.5 12 13.5C12.83 13.5 13.5 14.17 13.5 15C13.5 15.83 12.83 16.5 12 16.5ZM13 12H11V7H13V12Z" fill="currentColor"/>
                        </svg>
                    </div>
                </div>
                <div class="summary-value">{{ isset($pajakAkanMati) ? $pajakAkanMati : 0 }}</div>
                <div class="summary-label">Pajak Segera Jatuh Tempo</div>
                <div style="font-size: 0.75rem; color: #f59e0b; margin-top: 0.5rem;">Klik untuk detail</div>
            </div>
        </a>
    </section>

    <section class="table-container">
        <div class="table-header">
            <h3 class="table-title">Data Kendaraan Terbaru</h3>
            <a href="{{ route('operator.kendaraan.index') }}" class="btn btn-sm btn-outline">Lihat Semua</a>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th class="col-kendaraan">Kendaraan</th>
                    <th class="col-pemegang">Pemegang</th>
                    <th class="col-jenis">Jenis</th>
                    <th class="col-pajak">Status</th>
                    <th class="col-actions">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latest as $k)
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
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            <div class="empty-content">
                                <p>Belum ada data kendaraan.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
