<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Operator - SIKANDIS | Dinas Kominfo Kota Bengkulu</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L2 7V11C2 16.55 6.84 21.74 12 23C17.16 21.74 22 16.55 22 11V7L12 2Z" fill="#1e40af"/>
                    <path d="M12 7C10.34 7 9 8.34 9 10C9 11.66 10.34 13 12 13C13.66 13 15 11.66 15 10C15 8.34 13.66 7 12 7Z" fill="white"/>
                    <path d="M12 14C9.33 14 7 15.34 7 17V18H17V17C17 15.34 14.67 14 12 14Z" fill="white"/>
                </svg>
            </div>
            <h1 class="sidebar-title">SIKANDIS</h1>
            <p class="sidebar-subtitle">Sistem Inventarisasi Kendaraan Dinas<br>Dinas Kominfo Kota Bengkulu</p>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="#dashboard" class="nav-link active">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 13H11V3H3V13ZM3 21H11V15H3V21ZM13 21H21V11H13V21ZM13 3V9H21V3H13Z" fill="currentColor"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#data-kendaraan" class="nav-link">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 18.5C19.25 18.5 20.5 17.38 20.5 16C20.5 14.62 19.25 13.5 18 13.5C16.75 13.5 15.5 14.62 15.5 16C15.5 17.38 16.75 18.5 18 18.5ZM19.5 9.5H17V12H21.46L19.5 9.5ZM6 18.5C7.25 18.5 8.5 17.38 8.5 16C8.5 14.62 7.25 13.5 6 13.5C4.75 13.5 3.5 14.62 3.5 16C3.5 17.38 4.75 18.5 6 18.5ZM20 8L23 12V17H21C21 18.66 19.66 20 18 20C16.34 20 15 18.66 15 17H9C9 18.66 7.66 20 6 20C4.34 20 3 18.66 3 17H1V6C1 4.9 1.9 4 3 4H17V8H20Z" fill="currentColor"/>
                    </svg>
                    <span>Data Kendaraan</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#logout" class="nav-link">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 7L15.59 8.41L18.17 11H8V13H18.17L15.59 15.58L17 17L22 12L17 7ZM4 5H12V3H4C2.9 3 2 3.9 2 5V19C2 20.1 2.9 21 4 21H12V19H4V5Z" fill="currentColor"/>
                    </svg>
                    <span>Logout</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        <!-- Top Bar -->
        <header class="topbar">
            <button class="mobile-toggle" id="mobile-toggle" aria-label="Toggle Menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 18H21V16H3V18ZM3 13H21V11H3V13ZM3 6V8H21V6H3Z" fill="currentColor"/>
                </svg>
            </button>
            <h2 class="topbar-title">Dashboard Operator</h2>
            <div class="topbar-user">
                <div class="user-info">
                    <div class="user-name">Operator</div>
                    <div class="user-role">Administrator</div>
                </div>
                <div class="user-avatar">OP</div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="content">
            <!-- Summary Cards -->
            <section class="summary-grid">
                <!-- Total Kendaraan -->
                <div class="summary-card" id="card-total">
                    <div class="summary-header">
                        <div class="summary-icon blue">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 18.5C19.25 18.5 20.5 17.38 20.5 16C20.5 14.62 19.25 13.5 18 13.5C16.75 13.5 15.5 14.62 15.5 16C15.5 17.38 16.75 18.5 18 18.5ZM19.5 9.5H17V12H21.46L19.5 9.5ZM6 18.5C7.25 18.5 8.5 17.38 8.5 16C8.5 14.62 7.25 13.5 6 13.5C4.75 13.5 3.5 14.62 3.5 16C3.5 17.38 4.75 18.5 6 18.5ZM20 8L23 12V17H21C21 18.66 19.66 20 18 20C16.34 20 15 18.66 15 17H9C9 18.66 7.66 20 6 20C4.34 20 3 18.66 3 17H1V6C1 4.9 1.9 4 3 4H17V8H20Z" fill="currentColor"/>
                            </svg>
                        </div>
                    </div>
                    <div class="summary-value">156</div>
                    <div class="summary-label">Total Kendaraan Terdaftar</div>
                </div>

                <!-- Pajak Aktif -->
                <div class="summary-card" id="card-active">
                    <div class="summary-header">
                        <div class="summary-icon green">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 16.17L4.83 12L3.41 13.41L9 19L21 7L19.59 5.59L9 16.17Z" fill="currentColor"/>
                            </svg>
                        </div>
                    </div>
                    <div class="summary-value">142</div>
                    <div class="summary-label">Kendaraan Pajak Aktif</div>
                </div>

                <!-- Pajak Tidak Aktif -->
                <div class="summary-card" id="card-inactive">
                    <div class="summary-header">
                        <div class="summary-icon red">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 17H11V15H13V17ZM13 13H11V7H13V13Z" fill="currentColor"/>
                            </svg>
                        </div>
                    </div>
                    <div class="summary-value">14</div>
                    <div class="summary-label">Pajak Tidak Aktif / Habis</div>
                </div>

                <!-- Kendaraan dengan QR Code -->
                <div class="summary-card" id="card-qr">
                    <div class="summary-header">
                        <div class="summary-icon purple">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 11H11V3H3V11ZM5 5H9V9H5V5ZM13 3V11H21V3H13ZM19 9H15V5H19V9ZM3 21H11V13H3V21ZM5 15H9V19H5V15ZM13 13H15V15H13V13ZM15 15H17V17H15V15ZM13 17H15V19H13V17ZM15 19H17V21H15V19ZM17 17H19V19H17V17ZM17 13H19V15H17V13ZM19 15H21V17H19V15ZM19 19H21V21H19V19Z" fill="currentColor"/>
                            </svg>
                        </div>
                    </div>
                    <div class="summary-value">128</div>
                    <div class="summary-label">Kendaraan dengan QR Code</div>
                </div>
            </section>

            <!-- Data Table -->
            <section class="table-container">
                <div class="table-header">
                    <h3 class="table-title">Data Kendaraan Terbaru</h3>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama Kendaraan</th>
                            <th>Nomor Polisi</th>
                            <th>Tahun</th>
                            <th>Pemegang Kendaraan</th>
                            <th>Status Pajak</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-semibold">Toyota Avanza 1.3 G</td>
                            <td>BD 1234 AB</td>
                            <td>2023</td>
                            <td>Kepala Dinas Kominfo</td>
                            <td><span class="status-badge active">Aktif</span></td>
                        </tr>
                        <tr>
                            <td class="font-semibold">Honda Civic 1.5 Turbo</td>
                            <td>BD 5678 CD</td>
                            <td>2022</td>
                            <td>Sekretaris Dinas</td>
                            <td><span class="status-badge active">Aktif</span></td>
                        </tr>
                        <tr>
                            <td class="font-semibold">Mitsubishi Pajero Sport</td>
                            <td>BD 9012 EF</td>
                            <td>2021</td>
                            <td>Kabid Aplikasi Informatika</td>
                            <td><span class="status-badge inactive">Tidak Aktif</span></td>
                        </tr>
                        <tr>
                            <td class="font-semibold">Suzuki Ertiga GX</td>
                            <td>BD 3456 GH</td>
                            <td>2023</td>
                            <td>Kabid Statistik dan Persandian</td>
                            <td><span class="status-badge active">Aktif</span></td>
                        </tr>
                        <tr>
                            <td class="font-semibold">Daihatsu Xenia 1.3 R</td>
                            <td>BD 7890 IJ</td>
                            <td>2020</td>
                            <td>Kabid Komunikasi Publik</td>
                            <td><span class="status-badge active">Aktif</span></td>
                        </tr>
                        <tr>
                            <td class="font-semibold">Toyota Innova Reborn</td>
                            <td>BD 2468 KL</td>
                            <td>2019</td>
                            <td>Kasubbag Umum dan Kepegawaian</td>
                            <td><span class="status-badge inactive">Tidak Aktif</span></td>
                        </tr>
                        <tr>
                            <td class="font-semibold">Isuzu Panther LS</td>
                            <td>BD 1357 MN</td>
                            <td>2018</td>
                            <td>Staff Teknis</td>
                            <td><span class="status-badge active">Aktif</span></td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <!-- External JavaScript -->
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
