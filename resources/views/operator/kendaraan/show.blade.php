@extends('layouts.dashboard')

@section('title', 'Operator - Detail Kendaraan')
@section('topbar_title', 'Detail Kendaraan')

@section('content')
    <section class="form-container">
        <div class="table-toolbar" style="margin-bottom: var(--spacing-md);">
            <div class="table-toolbar-left">
                <h3 class="table-title" style="margin: 0;">{{ $kendaraan->nama_kendaraan }}</h3>
            </div>
            <div class="table-toolbar-right">
                <a class="btn btn-sm" href="{{ route('operator.kendaraan.index') }}">Kembali</a>
                <a class="btn btn-primary btn-sm" href="{{ route('operator.kendaraan.edit', $kendaraan) }}">Edit</a>
            </div>
        </div>

        <div class="detail-grid">
            <div class="detail-row">
                <div class="detail-key">Kode QR</div>
                <div class="detail-value">{{ $kendaraan->kode_qr }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-key">Jenis</div>
                <div class="detail-value">{{ $kendaraan->jenis }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-key">Nama Kendaraan</div>
                <div class="detail-value">{{ $kendaraan->nama_kendaraan }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-key">No Polisi</div>
                <div class="detail-value">{{ $kendaraan->no_polisi }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-key">Tahun Kendaraan</div>
                <div class="detail-value">{{ $kendaraan->thn_kendaraan }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-key">Pajak</div>
                <div class="detail-value">{{ $kendaraan->pajak_label }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-key">Status Pajak</div>
                <div class="detail-value">
                    <span class="status-badge {{ $kendaraan->pajak_is_active ? 'active' : 'inactive' }}">
                        {{ $kendaraan->pajak_is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-key">Pemegang</div>
                <div class="detail-value">{{ $kendaraan->pemegang }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-key">NIP</div>
                <div class="detail-value">{{ $kendaraan->nip }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-key">Jabatan</div>
                <div class="detail-value">{{ $kendaraan->jabatan }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-key">Unit Kerja</div>
                <div class="detail-value">{{ $kendaraan->unit_kerja }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-key">No Rangka</div>
                <div class="detail-value">{{ $kendaraan->no_rangka }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-key">No Mesin</div>
                <div class="detail-value">{{ $kendaraan->no_mesin }}</div>
            </div>
        </div>
    </section>
@endsection
