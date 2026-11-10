<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Admin - Kelola KRS</title>
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

        .breadcrumb a:hover {
            color: #2563EB;
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

        /* Header Section */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
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
        }

        .btn-tambah {
            background: #2563EB;
            color: #FFF;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-tambah:hover {
            background: #1D4ED8;
        }

        /* Card & Search */
        .table-card {
            background: #FFF;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            overflow: hidden;
        }

        .search-wrapper {
            padding: 18px 24px;
            border-bottom: 1px solid #F1F5F9;
        }

        .search-box {
            position: relative;
            max-width: 480px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 14px 10px 38px;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            font-size: 13px;
            outline: none;
            transition: 0.2s;
        }

        .search-box input:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            font-size: 14px;
        }

        /* Table */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: #F8FAFC;
            padding: 12px 18px;
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            border-bottom: 1px solid #E2E8F0;
        }

        td {
            padding: 16px 18px;
            font-size: 13px;
            color: #334155;
            border-bottom: 1px solid #F1F5F9;
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: #F8FAFC;
        }

        .prodi-name {
            font-weight: 600;
            color: #0F172A;
            display: block;
        }

        .sks-text {
            font-size: 11px;
            color: #64748B;
        }

        /* Action Buttons */
        .aksi-group {
            display: flex;
            gap: 8px;
        }

        .btn-edit {
            background: #EFF6FF;
            color: #2563EB;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
        }

        .btn-edit:hover {
            background: #DBEAFE;
        }

        .btn-delete {
            background: #FEF2F2;
            color: #EF4444;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
        }

        .btn-delete:hover {
            background: #FEE2E2;
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

        /* Modal Konfirmasi Hapus */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 999;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-box {
            background: #FFFFFF;
            border-radius: 16px;
            width: 100%;
            max-width: 420px;
            padding: 24px 28px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 18px;
            color: #64748B;
            cursor: pointer;
            margin-bottom: 12px;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 700;
            color: #0F172A;
            line-height: 1.4;
            margin-bottom: 8px;
        }

        .modal-desc {
            font-size: 13px;
            color: #64748B;
            margin-bottom: 24px;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-batal {
            background: #E57385;
            color: #FFFFFF;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-batal:hover {
            background: #D85B6F;
        }

        .btn-setuju {
            background: #2563EB;
            color: #FFFFFF;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-setuju:hover {
            background: #1D4ED8;
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
        <div class="page-header">
            <div class="page-title">
                <h1>Kelola KRS</h1>
                <p>Kelola jadwal, ruang, dan informasi perkuliahan.</p>
            </div>
            <a href="/demo/public/admin/krs/tambah" class="btn-tambah">
                <span>⊕</span> Tambah Jadwal
            </a>
        </div>

        <div class="table-card">
            <div class="search-wrapper">
                <div class="search-box">
                    <span class="search-icon">🔍</span>
                    <input type="text" id="searchInput" placeholder="Cari mata kuliah, dosen, ruang......." onkeyup="filterTabel()">
                </div>
            </div>

            <div class="table-responsive">
                <table id="tabelKrs">
                    <thead>
                        <tr>
                            <th>Mata Kuliah</th>
                            <th>Prodi</th>
                            <th>Kelas</th>
                            <th>Dosen</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Ruang</th>
                            <th>Kuota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($daftar_krs as $krs): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($krs['mataKuliah']) ?></strong></td>
                                <td>
                                    <span class="prodi-name"><?= htmlspecialchars($krs['programStudi']) ?></span>
                                    <span class="sks-text"><?= htmlspecialchars($krs['sks']) ?></span>
                                </td>
                                <td><?= htmlspecialchars($krs['kelas']) ?></td>
                                <td><?= htmlspecialchars($krs['dosen']) ?></td>
                                <td><?= htmlspecialchars($krs['hari']) ?></td>
                                <td><?= htmlspecialchars($krs['jam']) ?></td>
                                <td><?= htmlspecialchars($krs['ruang']) ?></td>
                                <td><?= htmlspecialchars((string)$krs['kuota']) ?></td>
                                <td>
                                    <div class="aksi-group">
                                        <a href="/demo/public/admin/krs/edit/<?= $krs['idKrs'] ?>" class="btn-edit">✏️ Edit</a>
                                        <button type="button" class="btn-delete" onclick="bukaModalHapus(<?= $krs['idKrs'] ?>)">🗑️ Delete</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
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

    <script>
        function filterTabel() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const rows = document.querySelectorAll("#tabelKrs tbody tr");
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(input) ? "" : "none";
            });
        }
    </script>

    <!-- Modal Konfirmasi Hapus -->
    <div id="modalHapus" class="modal-overlay">
        <div class="modal-box">
            <button type="button" class="modal-close" onclick="tutupModalHapus()">✕</button>
            <h3 class="modal-title">Apakah Anda yakin ingin menghapus data ini ?</h3>
            <p class="modal-desc">Konfirmasi terlebih dahulu sebelum melakukan tindakan</p>
            <div class="modal-actions">
                <button type="button" class="btn-batal" onclick="tutupModalHapus()">Tidak</button>
                <form id="formHapus" method="POST" action="">
                    <?php if (function_exists('csrf_field')): ?>
                        <?= csrf_field() ?>
                    <?php else: ?>
                        <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['_csrf'] ?? '') ?>">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['_csrf'] ?? '') ?>">
                        <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['_csrf'] ?? '') ?>">
                    <?php endif; ?>
                    <button type="submit" class="btn-setuju">Ya, Setujui</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function bukaModalHapus(idKrs) {
            document.getElementById('formHapus').action = '/demo/public/admin/krs/hapus/' + idKrs;
            document.getElementById('modalHapus').classList.add('active');
        }

        function tutupModalHapus() {
            document.getElementById('modalHapus').classList.remove('active');
        }
    </script>
</body>

</html>