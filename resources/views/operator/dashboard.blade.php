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
    </section>

    <section class="table-container">
        <div class="table-header">
            <h3 class="table-title">Data Kendaraan Terbaru</h3>
            <a href="{{ route('operator.kendaraan.index') }}">Lihat Semua</a>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Kode QR</th>
                    <th>Nama Kendaraan</th>
                    <th>No Polisi</th>
                    <th>Jenis</th>
                    <th>Pemegang</th>
                    <th class="col-pajak">Pajak</th>
                    <th class="col-actions">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latest as $k)
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
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Belum ada data kendaraan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
