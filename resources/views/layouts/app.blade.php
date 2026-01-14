<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIKANDIS')</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f6f7fb; }
        header { background: #0f172a; color: #fff; padding: 12px 16px; display: flex; justify-content: space-between; align-items: center; }
        .container { padding: 16px; }
        a { color: #2563eb; text-decoration: none; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        th { background: #f9fafb; }
        .actions form { display: inline; }
        .btn { display: inline-block; padding: 8px 10px; border-radius: 6px; border: 1px solid #cbd5e1; background: #fff; cursor: pointer; }
        .btn-primary { background: #2563eb; border-color: #2563eb; color: #fff; }
        .btn-danger { background: #dc2626; border-color: #dc2626; color: #fff; }
        .btn + .btn { margin-left: 6px; }
        .top-links a { color: #fff; margin-right: 10px; }
        .card { background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .field { margin-bottom: 10px; }
        label { display: block; font-size: 12px; color: #475569; margin-bottom: 4px; }
        input { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; }
        .error { color: #dc2626; font-size: 12px; }
    </style>
</head>
<body>
<header>
    <div>
        <strong>SIKANDIS</strong>
    </div>
    <div class="top-links">
        @auth
            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('admin.kendaraan.index') }}">Kendaraan</a>
                <a href="{{ route('admin.kelola-operator.index') }}">Operator</a>
            @endif
            <a href="{{ route('operator.kendaraan.index') }}">Kendaraan (Operator)</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn">Logout</button>
            </form>
        @endauth
    </div>
</header>
<div class="container">
    @yield('content')
</div>
</body>
</html>
