<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIKANDIS')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <img src="{{ asset('assets/images/logo-kominfo.png') }}" alt="Logo Kominfo" style="height: 48px; width: auto; object-fit: contain;">
            </div>
            <h1 class="sidebar-title">SIKANDIS</h1>
            <p class="sidebar-subtitle">Sistem Inventarisasi Kendaraan Dinas<br>Dinas Kominfo Kota Bengkulu</p>
        </div>

        <nav class="sidebar-nav">
            @auth
                @php
                    $isAdmin = auth()->user()->hasRole('admin');
                    $isOperator = auth()->user()->hasRole('operator');
                @endphp

                @if($isAdmin)
                    <div class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 13H11V3H3V13ZM3 21H11V15H3V21ZM13 21H21V11H13V21ZM13 3V9H21V3H13Z" fill="currentColor"/>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.kendaraan.index') }}" class="nav-link {{ request()->routeIs('admin.kendaraan.*') ? 'active' : '' }}">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 18.5C19.25 18.5 20.5 17.38 20.5 16C20.5 14.62 19.25 13.5 18 13.5C16.75 13.5 15.5 14.62 15.5 16C15.5 17.38 16.75 18.5 18 18.5ZM19.5 9.5H17V12H21.46L19.5 9.5ZM6 18.5C7.25 18.5 8.5 17.38 8.5 16C8.5 14.62 7.25 13.5 6 13.5C4.75 13.5 3.5 14.62 3.5 16C3.5 17.38 4.75 18.5 6 18.5ZM20 8L23 12V17H21C21 18.66 19.66 20 18 20C16.34 20 15 18.66 15 17H9C9 18.66 7.66 20 6 20C4.34 20 3 18.66 3 17H1V6C1 4.9 1.9 4 3 4H17V8H20Z" fill="currentColor"/>
                            </svg>
                            <span>Data Kendaraan</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.kelola-operator.index') }}" class="nav-link {{ request()->routeIs('admin.kelola-operator.*') ? 'active' : '' }}">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 11C17.66 11 18.99 9.66 18.99 8C18.99 6.34 17.66 5 16 5C14.34 5 13 6.34 13 8C13 9.66 14.34 11 16 11ZM8 11C9.66 11 10.99 9.66 10.99 8C10.99 6.34 9.66 5 8 5C6.34 5 5 6.34 5 8C5 9.66 6.34 11 8 11ZM8 13C5.67 13 1 14.17 1 16.5V19H15V16.5C15 14.17 10.33 13 8 13ZM16 13C15.71 13 15.38 13.02 15.03 13.05C16.19 13.89 17 15.02 17 16.5V19H23V16.5C23 14.17 18.33 13 16 13Z" fill="currentColor"/>
                            </svg>
                            <span>Kelola Operator</span>
                        </a>
                    </div>
                @else
                    <div class="nav-item">
                        <a href="{{ route('operator.dashboard') }}" class="nav-link {{ request()->routeIs('operator.dashboard') ? 'active' : '' }}">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 13H11V3H3V13ZM3 21H11V15H3V21ZM13 21H21V11H13V21ZM13 3V9H21V3H13Z" fill="currentColor"/>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('operator.kendaraan.index') }}" class="nav-link {{ request()->routeIs('operator.kendaraan.*') ? 'active' : '' }}">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 18.5C19.25 18.5 20.5 17.38 20.5 16C20.5 14.62 19.25 13.5 18 13.5C16.75 13.5 15.5 14.62 15.5 16C15.5 17.38 16.75 18.5 18 18.5ZM19.5 9.5H17V12H21.46L19.5 9.5ZM6 18.5C7.25 18.5 8.5 17.38 8.5 16C8.5 14.62 7.25 13.5 6 13.5C4.75 13.5 3.5 14.62 3.5 16C3.5 17.38 4.75 18.5 6 18.5ZM20 8L23 12V17H21C21 18.66 19.66 20 18 20C16.34 20 15 18.66 15 17H9C9 18.66 7.66 20 6 20C4.34 20 3 18.66 3 17H1V6C1 4.9 1.9 4 3 4H17V8H20Z" fill="currentColor"/>
                            </svg>
                            <span>Data Kendaraan</span>
                        </a>
                    </div>
                @endif

                <div class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link nav-link-button">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17 7L15.59 8.41L18.17 11H8V13H18.17L15.59 15.58L17 17L22 12L17 7ZM4 5H12V3H4C2.9 3 2 3.9 2 5V19C2 20.1 2.9 21 4 21H12V19H4V5Z" fill="currentColor"/>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            @endauth
        </nav>
    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            <button class="mobile-toggle" id="mobile-toggle" aria-label="Toggle Menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 18H21V16H3V18ZM3 13H21V11H3V13ZM3 6V8H21V6H3Z" fill="currentColor"/>
                </svg>
            </button>

            <h2 class="topbar-title">@yield('topbar_title', 'Dashboard')</h2>

            <div class="topbar-user">
                @auth
                    @php
                        $user = auth()->user();
                        $roleText = $user->hasRole('admin') ? 'Admin' : 'Operator';
                        $initials = strtoupper(substr($user->name ?? 'U', 0, 2));
                    @endphp
                    <div class="user-info">
                        <div class="user-name">{{ $user->name }}</div>
                        <div class="user-role">{{ $roleText }}</div>
                    </div>
                    <div class="user-avatar">{{ $initials }}</div>
                @endauth
            </div>
        </header>

        <main class="content">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
