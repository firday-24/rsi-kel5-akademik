<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Admin - Edit Jadwal KRS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', system-ui, sans-serif;
        }

        body {
            background-color: #F8FAFC;
            color: #1E293B;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .navbar {
            background: #FFF;
            border-bottom: 1px solid #E2E8F0;
            padding: 14px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .breadcrumb {
            font-size: 14px;
            color: #64748B;
        }

        .breadcrumb a {
            color: #64748B;
            text-decoration: none;
        }

        .breadcrumb span {
            color: #0F172A;
            font-weight: 600;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .semester-badge {
            background: #EFF6FF;
            color: #2563EB;
            font-size: 12px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 999px;
        }

        .profile-menu {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 500;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #DBEAFE;
            color: #1D4ED8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
        }

        /* Container */
        .container {
            max-width: 1150px;
            width: 100%;
            margin: 32px auto;
            padding: 0 20px;
            flex: 1;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #2563EB;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .page-title h1 {
            font-size: 24px;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 4px;
        }

        .page-title p {
            font-size: 13px;
            color: #64748B;
            margin-bottom: 24px;
        }

        /* Grid Layout */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            align-items: start;
        }

        /* Form Card */
        .form-card {
            background: #FFF;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            overflow: hidden;
        }

        .form-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid #F1F5F9;
            font-size: 15px;
            font-weight: 600;
            color: #0F172A;
        }

        .form-card-body {
            padding: 24px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 18px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-size: 12px;
            font-weight: 500;
            color: #475569;
        }

        .form-group input {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            color: #0F172A;
            outline: none;
            transition: 0.2s;
        }

        .form-group input:focus {
            border-color: #2563EB;
            background: #FFF;
        }

        .jam-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .jam-group input {
            width: 100%;
        }

        .jam-sep {
            color: #94A3B8;
            font-weight: 600;
        }

        .keterangan-box {
            background: #F1F5F9;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 12px;
            color: #334155;
            margin-top: 6px;
        }

        .form-card-footer {
            padding: 16px 24px;
            border-top: 1px solid #F1F5F9;
            display: flex;
            justify-content: flex-end;
        }

        .btn-submit {
            background: #2563EB;
            color: #FFF;
            border: none;
            padding: 10px 22px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }

        .btn-submit:hover {
            background: #1D4ED8;
        }

        /* Info Card */
        .info-card {
            background: #EFF6FF;
            border-radius: 14px;
            padding: 20px;
            color: #1E3A8A;
        }

        .info-header {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .info-list {
            padding-left: 18px;
            font-size: 12px;
            color: #475569;
            display: flex;
            flex-direction: column;
            gap: 10px;
            line-height: 1.5;
        }

        /* Footer */
        .footer {
            border-top: 1px solid #E2E8F0;
            background: #FFF;
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #64748B;
            margin-top: 40px;
        }

        .footer-links a {
            color: #64748B;
            text-decoration: none;
            margin-left: 16px;
        }

        .footer-links a.primary {
            color: #2563EB;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <header class="navbar">
        <div class="breadcrumb">
            <a href="/demo/public/admin">Portal Admin</a> &nbsp;&gt;&nbsp; <span>Kelola KRS</span>
        </div>
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
        <a href="/demo/public/admin/krs" class="back-link">← Kembali ke antrean</a>

        <div class="page-title">
            <h1>Edit Jadwal KRS</h1>
            <p>Edit jadwal KRS untuk mata kuliah yang akan berjalan</p>
        </div>

        <div class="content-grid">
            <form action="/demo/public/admin/krs/update/<?= $krs['idKrs'] ?>" method="POST" class="form-card">
                <?php if (function_exists('csrf_field')): ?>
                    <?= csrf_field() ?>
                <?php else: ?>
                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['_csrf'] ?? '') ?>">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['_csrf'] ?? '') ?>">
                    <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['_csrf'] ?? '') ?>">
                <?php endif; ?>

                <div class="form-card-header">Informasi Jadwal</div>

                <div class="form-card-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Mata Kuliah</label>
                            <input type="text" name="mataKuliah" value="<?= htmlspecialchars($krs['mataKuliah']) ?>" placeholder="<?= htmlspecialchars($krs['mataKuliah']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Program Studi</label>
                            <input type="text" name="programStudi" value="<?= htmlspecialchars($krs['programStudi']) ?>" placeholder="<?= htmlspecialchars($krs['programStudi']) ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas" value="<?= htmlspecialchars($krs['kelas']) ?>" placeholder="<?= htmlspecialchars($krs['kelas']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Dosen</label>
                            <input type="text" name="dosen" value="<?= htmlspecialchars($krs['dosen']) ?>" placeholder="<?= htmlspecialchars($krs['dosen']) ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Hari</label>
                            <input type="text" name="hari" value="<?= htmlspecialchars($krs['hari']) ?>" placeholder="<?= htmlspecialchars($krs['hari']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Jam</label>
                            <div class="jam-group">
                                <input type="text" name="jam_mulai" value="<?= htmlspecialchars($krs['jam_mulai']) ?>" placeholder="<?= htmlspecialchars($krs['jam_mulai']) ?>" required>
                                <span class="jam-sep">—</span>
                                <input type="text" name="jam_selesai" value="<?= htmlspecialchars($krs['jam_selesai']) ?>" placeholder="<?= htmlspecialchars($krs['jam_selesai']) ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Ruang</label>
                            <input type="text" name="ruang" value="<?= htmlspecialchars($krs['ruang']) ?>" placeholder="<?= htmlspecialchars($krs['ruang']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Kuota</label>
                            <input type="number" name="kuota" value="<?= htmlspecialchars((string)$krs['kuota']) ?>" placeholder="<?= htmlspecialchars((string)$krs['kuota']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <div class="keterangan-box">
                            Periksa data yang sudah ditambahkan agar tidak terjadi kesalahan
                        </div>
                    </div>
                </div>

                <div class="form-card-footer">
                    <button type="submit" class="btn-submit">📄 Submit</button>
                </div>
            </form>

            <aside class="info-card">
                <div class="info-header">ⓘ Periksa sebelum memutuskan</div>
                <ul class="info-list">
                    <li>Pilih mata kuliah, program studi, dan kelas yang sudah terdaftar di sistem</li>
                    <li>Kuota dapat diubah sesuai kebutuhan</li>
                </ul>
            </aside>
        </div>
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