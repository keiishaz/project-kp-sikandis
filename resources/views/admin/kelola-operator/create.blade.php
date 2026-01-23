@extends('layouts.dashboard')

@section('title', 'Admin - Tambah Operator')
@section('topbar_title', 'Tambah Operator')

@section('content')
    <section class="form-container">
        <form method="POST" action="{{ route('admin.kelola-operator.store') }}">
            @csrf

            <div class="form-grid">
                <div class="form-field">
                    <label for="name">Nama</label>
                    <input id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div class="form-field">
                    <label for="nip">NIP</label>
                    <input id="nip" name="nip" type="text" value="{{ old('nip') }}" required>
                    @error('nip')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-grid">
                <div class="form-field">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required>
                    @error('password')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div></div>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a class="btn" href="{{ route('admin.kelola-operator.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection
