@extends('layouts.dashboard')

@php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp

@section('title', 'Operator - Detail Kendaraan')
@section('topbar_title', 'Detail Kendaraan')

@section('content')
    <div style="width: 100%; margin: 0 auto;">
        
        {{-- Header / Toolbar --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-800); margin-bottom: 0.25rem;">
                    {{ $kendaraan->nama_kendaraan }}
                </h2>
                <div style="color: var(--gray-500); font-size: 0.875rem;">
                    {{ $kendaraan->no_polisi }} • {{ $kendaraan->jenis }}
                </div>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <a href="{{ route('operator.kendaraan.index') }}" class="btn" style="background: white; border: 1px solid var(--gray-200); color: var(--gray-800);">
                    Kembali
                </a>
                <a href="{{ route('operator.kendaraan.edit', $kendaraan) }}" class="btn btn-primary">
                    Edit Data
                </a>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; align-items: start;">
            
            {{-- Left Column: Information --}}
            <div style="background: white; border-radius: 12px; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200); overflow: hidden;">
                <div style="padding: 1.5rem; border-bottom: 1px solid var(--gray-200); background: var(--gray-50);">
                    <h3 style="font-size: 1rem; font-weight: 600; margin: 0;">Informasi Detail</h3>
                </div>
                
                <div style="padding: 1.5rem;">
                    {{-- Group: Utama --}}
                    <div style="margin-bottom: 2rem;">
                        <h4 style="font-size: 0.75rem; text-transform: uppercase; color: var(--gray-500); letter-spacing: 0.05em; margin-bottom: 1rem;">
                            Data Utama
                        </h4>
                        <div style="display: grid; gap: 1rem;">
                            <div class="detail-item">
                                <span style="display: block; font-size: 0.8rem; color: var(--gray-500);">Nama Kendaraan</span>
                                <span style="font-weight: 500;">{{ $kendaraan->nama_kendaraan }}</span>
                            </div>
                            <div class="detail-item">
                                <span style="display: block; font-size: 0.8rem; color: var(--gray-500);">Nomor Polisi</span>
                                <span style="font-weight: 500; font-size: 1.1rem;">{{ $kendaraan->no_polisi }}</span>
                            </div>
                            <div class="detail-item">
                                <span style="display: block; font-size: 0.8rem; color: var(--gray-500);">Jenis</span>
                                <span style="font-weight: 500; text-transform: capitalize;">{{ $kendaraan->jenis }}</span>
                            </div>
                             <div class="detail-item">
                                <span style="display: block; font-size: 0.8rem; color: var(--gray-500);">Tahun Pembuatan</span>
                                <span style="font-weight: 500;">{{ $kendaraan->thn_kendaraan }}</span>
                            </div>
                        </div>
                    </div>

                    <hr style="border: 0; border-top: 1px dashed var(--gray-200); margin: 1.5rem 0;">

                    {{-- Group: Teknis & Pajak --}}
                    <div style="margin-bottom: 2rem;">
                        <h4 style="font-size: 0.75rem; text-transform: uppercase; color: var(--gray-500); letter-spacing: 0.05em; margin-bottom: 1rem;">
                            Teknis & Pajak
                        </h4>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div>
                                <span style="display: block; font-size: 0.8rem; color: var(--gray-500);">No. Rangka</span>
                                <span style="font-family: monospace; font-size: 0.95rem;">{{ $kendaraan->no_rangka }}</span>
                            </div>
                            <div>
                                <span style="display: block; font-size: 0.8rem; color: var(--gray-500);">No. Mesin</span>
                                <span style="font-family: monospace; font-size: 0.95rem;">{{ $kendaraan->no_mesin }}</span>
                            </div>
                            <div>
                                <span style="display: block; font-size: 0.8rem; color: var(--gray-500);">Jatuh Tempo Pajak</span>
                                <div style="font-weight: 500; display: flex; align-items: center; margin-top: 0.25rem;">
                                    {{ $kendaraan->pajak_label }}
                                    @if($kendaraan->pajak_is_expiring_soon)
                                        <span class="status-badge" style="background: #fef3c7; color: #b45309; margin-left: 8px; border: none;">Segera Habis</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <span style="display: block; font-size: 0.8rem; color: var(--gray-500);">Status Pajak</span>
                                <span class="status-badge {{ $kendaraan->pajak_is_active ? 'active' : 'inactive' }}" style="display: inline-block; margin-top: 0.25rem;">
                                    {{ $kendaraan->pajak_is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <hr style="border: 0; border-top: 1px dashed var(--gray-200); margin: 1.5rem 0;">

                    {{-- Group: Pemegang --}}
                    <div>
                        <h4 style="font-size: 0.75rem; text-transform: uppercase; color: var(--gray-500); letter-spacing: 0.05em; margin-bottom: 1rem;">
                            Pemegang
                        </h4>
                        <div style="display: grid; gap: 0.75rem;">
                            <div style="display: flex; gap: 0.5rem; align-items: baseline;">
                                <span style="width: 100px; font-size: 0.8rem; color: var(--gray-500);">Nama</span>
                                <span style="font-weight: 600; font-size: 0.9rem;">{{ $kendaraan->pemegang }}</span>
                            </div>
                            <div style="display: flex; gap: 0.5rem; align-items: baseline;">
                                <span style="width: 100px; font-size: 0.8rem; color: var(--gray-500);">NIP</span>
                                <span style="font-size: 0.9rem;">{{ $kendaraan->nip }}</span>
                            </div>
                            <div style="display: flex; gap: 0.5rem; align-items: baseline;">
                                <span style="width: 100px; font-size: 0.8rem; color: var(--gray-500);">Jabatan</span>
                                <span style="font-size: 0.9rem;">{{ $kendaraan->jabatan }}</span>
                            </div>
                            <div style="display: flex; gap: 0.5rem; align-items: baseline;">
                                <span style="width: 100px; font-size: 0.8rem; color: var(--gray-500);">Unit Kerja</span>
                                <span style="font-size: 0.9rem;">{{ $kendaraan->unit_kerja }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: QR & Actions --}}
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                {{-- QR Card --}}
                <div style="background: white; border-radius: 12px; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200); padding: 1.5rem; text-align: center;">
                    <h3 style="font-size: 0.9rem; font-weight: 600; margin-bottom: 1rem;">QR Code Identitas</h3>
                    
                    <div style="background: white; padding: 1rem; border: 1px solid var(--gray-200); border-radius: 8px; display: inline-block; margin-bottom: 1rem;">
                        {!! QrCode::size(160)->style('round')->generate($qrUrl) !!}
                    </div>

                    <p style="font-size: 0.75rem; color: var(--gray-500); margin-bottom: 1.5rem; word-break: break-all;">
                        {{ $qrUrl }}
                    </p>

                    <div style="display: grid; gap: 0.75rem;">
                        <a href="{{ route('operator.kendaraan.print', $kendaraan->id) }}" target="_blank" class="btn btn-primary" style="width: 100%; justify-content: center;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.5rem;"><path d="M6 9V2h12v7"></path><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><path d="M6 14h12v8H6z"></path></svg>
                            Cetak Stiker QR
                        </a>

                        <form action="{{ route('operator.kendaraan.regenerate', $kendaraan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membuat ulang QR Code? QR Code lama tidak akan berfungsi lagi.');">
                            @csrf
                            <button type="submit" class="btn btn-warning" style="width: 100%; justify-content: center; font-size: 0.8rem; padding: 0.6rem;">
                                Regenerate QR Baru
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
