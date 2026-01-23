@extends('layouts.dashboard')

@section('title', 'Admin - Log Aktivitas')
@section('topbar_title', 'Log Aktivitas')

@section('content')
    <section class="table-container">
        <div class="table-header">
            <h3 class="table-title">Riwayat Aktivitas</h3>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Aktivitas</th>
                    <th>Deskripsi</th>
                    <th>IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td style="white-space: nowrap; width: 1%; color: var(--gray-600); font-size: 0.85rem;">
                            {{ $log->created_at->format('d M Y H:i') }}
                        </td>
                        <td>
                            @if($log->user)
                                <div style="font-weight: 600;">{{ $log->user->name }}</div>
                                <div style="font-size: 0.75rem; color: var(--gray-500);">NIP: {{ $log->user->nip }}</div>
                            @else
                                <span style="color: var(--gray-400); font-style: italic;">Hamba Allah</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge active" style="background: #eff6ff; color: var(--primary-color);">
                                {{ $log->aktivitas }}
                            </span>
                        </td>
                        <td>
                            <div style="font-size: 0.9rem; color: var(--gray-700); max-width: 300px;">
                                {{ $log->deskripsi ?: '-' }}
                            </div>
                        </td>
                        <td style="font-family: monospace; font-size: 0.85rem; color: var(--gray-600);">
                            {{ $log->ip_address ?: '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada aktivitas tercatat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 1.5rem;">
            {{ $logs->links('pagination.sikandis') }}
        </div>
    </section>
@endsection
