<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Admin - Beranda</title>
    <!-- Panggil CSS bawaan proyek jika perlu -->
    <link rel="stylesheet" href="/demo/public/css/portal.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #F8FAFC; color: #1E293B; min-height: 100vh; display: flex; flex-direction: column; }
        
        /* Navbar */
        .navbar { background: #FFF; border-bottom: 1px solid #E2E8F0; padding: 14px 40px; display: flex; justify-content: space-between; align-items: center; }
        .breadcrumb { font-size: 14px; color: #64748B; }
        .breadcrumb span { color: #0F172A; font-weight: 600; }
        .nav-right { display: flex; align-items: center; gap: 20px; }
        .semester-badge { background: #EFF6FF; color: #2563EB; font-size: 12px; font-weight: 600; padding: 6px 14px; border-radius: 999px; }
        .profile-menu { display: flex; align-items: center; gap: 10px; font-size: 14px; font-weight: 500; }
        .avatar { width: 36px; height: 36px; border-radius: 50%; background: #DBEAFE; color: #1D4ED8; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; }

        /* Main */
        .container { max-width: 1100px; width: 100%; margin: 32px auto; padding: 0 20px; flex: 1; }
        .greeting { font-size: 24px; font-weight: 700; margin-bottom: 20px; color: #0F172A; }

        /* Hero */
        .hero-card { background: #133B82; border-radius: 16px; color: #FFF; display: flex; justify-content: space-between; align-items: center; overflow: hidden; margin-bottom: 24px; min-height: 220px; }
        .hero-content { padding: 36px 40px; max-width: 65%; }
        .hero-subtitle { font-size: 11px; letter-spacing: 1px; text-transform: uppercase; color: #93C5FD; font-weight: 600; margin-bottom: 10px; }
        .hero-title { font-size: 28px; font-weight: 600; line-height: 1.3; margin-bottom: 12px; }
        .hero-desc { font-size: 14px; color: #DBEAFE; }
        .hero-image { width: 240px; height: 220px; object-fit: cover; object-position: top; }

        /* Stats */
        .stats-card { background: #FFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 24px 32px; display: grid; grid-template-columns: repeat(3, 1fr); margin-bottom: 32px; }
        .stat-item { padding: 0 20px; border-right: 1px solid #F1F5F9; }
        .stat-item:first-child { padding-left: 0; }
        .stat-item:last-child { border-right: none; }
        .stat-label { font-size: 13px; color: #64748B; margin-bottom: 8px; }
        .stat-value { font-size: 32px; font-weight: 700; color: #0F172A; }
        .stat-unit { font-size: 13px; color: #64748B; font-weight: 400; margin-left: 4px; }

        /* Menu */
        .section-title { font-size: 16px; font-weight: 600; color: #334155; margin-bottom: 16px; }
        .menu-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 32px; }
        .menu-card { background: #FFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 22px; display: flex; align-items: center; justify-content: space-between; text-decoration: none; color: inherit; transition: 0.2s; }
        .menu-card:hover { border-color: #93C5FD; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08); transform: translateY(-2px); }
        .menu-left { display: flex; align-items: center; gap: 16px; }
        .menu-icon { width: 48px; height: 48px; background: #EFF6FF; color: #2563EB; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .menu-text h3 { font-size: 16px; font-weight: 600; color: #0F172A; margin-bottom: 4px; }
        .menu-text p { font-size: 12px; color: #64748B; }
        .arrow-icon { color: #94A3B8; font-size: 16px; }

        /* Info Banner */
        .info-banner { background: #EFF6FF; border-radius: 12px; padding: 16px 20px; display: flex; align-items: flex-start; gap: 14px; margin-bottom: 40px; }
        .info-icon { color: #2563EB; font-size: 18px; }
        .info-text h4 { font-size: 13px; font-weight: 600; color: #1E3A8A; margin-bottom: 4px; }
        .info-text p { font-size: 12px; color: #475569; }

        /* Footer */
        .footer { border-top: 1px solid #E2E8F0; background: #FFF; padding: 18px 40px; display: flex; justify-content: space-between; align-items: center; font-size: 12px; color: #64748B; }
        .footer-links a { color: #64748B; text-decoration: none; margin-left: 16px; }
        .footer-links a.primary { color: #2563EB; font-weight: 500; }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="breadcrumb">Portal Admin &nbsp;&gt;&nbsp; <span>Beranda</span></div>
        <div class="nav-right">
            <div class="semester-badge">Semester Ganjil 2026/2027</div>
            <span>🔔</span>
            <div class="profile-menu">
                <div class="avatar">DH</div>
                <span><?= htmlspecialchars($nama_admin) ?></span>
                <span>⌄</span>
            </div>
        </div>
    </header>

    <main class="container">
        <h1 class="greeting">Selamat Datang, <?= htmlspecialchars($nama_depan) ?>!</h1>

        <section class="hero-card">
            <div class="hero-content">
                <div class="hero-subtitle">PUSAT KENDALI AKADEMIK</div>
                <h2 class="hero-title">Administrasi Akademik Lebih<br>Mudah dan Terarah</h2>
                <p class="hero-desc">Pantau presensi, KRS, dan pengajuan izin mahasiswa secara efisien</p>
            </div>
            <img src="/demo/public/images/foto-admin.jpg" alt="Admin Akademik" class="hero-image">
        </section>

        <section class="stats-card">
            <div class="stat-item">
                <div class="stat-label">Total mahasiswa aktif</div>
                <div class="stat-value"><?= $statistik['mahasiswa_aktif'] ?><span class="stat-unit">mahasiswa</span></div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Total angkatan aktif</div>
                <div class="stat-value"><?= $statistik['angkatan_aktif'] ?><span class="stat-unit">angkatan</span></div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Total dosen</div>
                <div class="stat-value"><?= $statistik['total_dosen'] ?><span class="stat-unit">dosen</span></div>
            </div>
        </section>

        <h3 class="section-title">Menu Pengelolaan Akademik</h3>
        <section class="menu-grid">
            <a href="/demo/public/admin/presensi" class="menu-card">
                <div class="menu-left">
                    <div class="menu-icon">⛶</div>
                    <div class="menu-text">
                        <h3>Kelola Presensi</h3>
                        <p>Catat &amp; cek kehadiran</p>
                    </div>
                </div>
                <span class="arrow-icon">↗</span>
            </a>

            <a href="/demo/public/admin/krs" class="menu-card">
                <div class="menu-left">
                    <div class="menu-icon">📝</div>
                    <div class="menu-text">
                        <h3>Kelola KRS</h3>
                        <p>Rencana studi semester</p>
                    </div>
                </div>
                <span class="arrow-icon">↗</span>
            </a>

            <a href="/demo/public/admin/izin" class="menu-card">
                <div class="menu-left">
                    <div class="menu-icon">📄</div>
                    <div class="menu-text">
                        <h3>Kelola Izin</h3>
                        <p>Ajukan izin perkuliahan</p>
                    </div>
                </div>
                <span class="arrow-icon">↗</span>
            </a>
        </section>

        <section class="info-banner">
            <div class="info-icon">ⓘ</div>
            <div class="info-text">
                <h4>Pastikan Data Akademik Diperbarui Secara Berkala</h4>
                <p>Ada data yang kurang sesuai? Hubungi dosen pengampu mata kuliah terkait.</p>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div>© 2026 Universitas Cakrawala Nusantara</div>
        <div>Sistem Informasi Akademik · Universitas Cakrawala Nusantara</div>
        <div class="footer-links">
            <a href="#">Panduan mahasiswa</a>
            <a href="#" class="primary">Hubungi akademik</a>
        </div>
    </footer>

</body>
</html>