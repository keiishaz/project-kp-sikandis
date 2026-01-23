@extends('layouts.dashboard')

@section('title', 'Admin - Kelola Operator')
@section('topbar_title', 'Kelola Operator')

@section('content')
    <section class="table-container">
        <div class="table-header">
            <h3 class="table-title">Kelola Operator</h3>
            <button type="button" class="btn btn-primary" data-modal-open="modal-admin-operator-create">Tambah Operator</button>
        </div>

        <form class="table-toolbar" method="GET" action="{{ route('admin.kelola-operator.index') }}">
            <div class="table-toolbar-left">
                <div class="toolbar-field">
                    <input type="text" name="q" placeholder="Cari nama atau NIP" value="{{ request('q') }}">
                </div>
            </div>
            <div class="table-toolbar-right">
                <button class="btn btn-sm btn-primary" type="submit">Cari</button>
                <a class="btn btn-sm" href="{{ route('admin.kelola-operator.index') }}">Reset</a>
            </div>
        </form>

        @php
            $baseQuery = request()->except('page');
            $currentSort = request('sort');
            $currentDir = request('dir');

            $sortLink = function (string $key) use ($baseQuery, $currentSort, $currentDir) {
                $dir = ($currentSort === $key && $currentDir === 'asc') ? 'desc' : 'asc';
                return route('admin.kelola-operator.index', array_merge($baseQuery, ['sort' => $key, 'dir' => $dir]));
            };

            $sortIndicator = function (string $key) use ($currentSort, $currentDir) {
                if ($currentSort !== $key) return '';
                return $currentDir === 'asc' ? '▲' : '▼';
            };
        @endphp

        <table class="data-table">
            <thead>
                <tr>
                    <th><a class="sort-link" href="{{ $sortLink('name') }}">Nama <span class="sort-indicator">{{ $sortIndicator('name') }}</span></a></th>
                    <th><a class="sort-link" href="{{ $sortLink('nip') }}">NIP <span class="sort-indicator">{{ $sortIndicator('nip') }}</span></a></th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($operators as $op)
                    <tr>
                        <td class="font-semibold">{{ $op->name }}</td>
                        <td>{{ $op->nip }}</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.kelola-operator.edit', $op) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.kelola-operator.destroy', $op) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="btn btn-danger btn-sm"
                                    type="submit"
                                    onclick="return confirm('Data operator akan dihapus permanen.\nTindakan ini tidak dapat dibatalkan.\n\nApakah Anda yakin ingin melanjutkan?');">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Belum ada operator.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $operators->links('pagination.sikandis') }}
    </section>

    <div class="modal-overlay {{ $errors->any() ? 'active' : '' }}" id="modal-admin-operator-create">
        <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-admin-operator-create-title">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-admin-operator-create-title">Tambah Operator</h3>
                <button type="button" class="modal-close" data-modal-close="modal-admin-operator-create">✕</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.kelola-operator.store') }}">
                    @csrf

                    <div class="form-grid">
                        <div class="form-field">
                            <label for="op_name">Nama</label>
                            <input id="op_name" name="name" value="{{ old('name') }}" required>
                            @error('name')<div class="error-text">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-field">
                            <label for="op_nip">NIP</label>
                            <input id="op_nip" name="nip" type="text" value="{{ old('nip') }}" required>
                            @error('nip')<div class="error-text">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-field">
                            <label for="op_password">Password</label>
                            <input id="op_password" name="password" type="password" required>
                            @error('password')<div class="error-text">{{ $message }}</div>@enderror
                        </div>
                        <div></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn" data-modal-close="modal-admin-operator-create">Batal</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
