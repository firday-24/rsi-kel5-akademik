<?php
$title = 'Kelola Presensi';
$breadcrumb = 'Presensi';
include ROOT . '/resources/views/layouts/header.php';
$kelas = $kelas ?? [];
?>
<section class="attendance-page lecturer-queue-page">
    <a href="<?= e(url('dosen')) ?>" class="back-link"><span>←</span> Kembali ke home</a>
    <div class="page-heading lecturer-page-heading">
        <h1>Kelola Presensi Kelas</h1>
        <p>Aktifkan sesi QR dinamis dan perbarui status kehadiran mahasiswa pada mata kuliah yang Anda ampu.</p>
    </div>

    <?php if (!empty($success)): ?>
        <div class="lecturer-flash success"><?= e($success) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="lecturer-flash error"><?= e($error) ?></div>
    <?php endif; ?>

    <section class="attendance-card">
        <div class="table-card-heading">
            <h2>Aktifkan Sesi QR Dinamis</h2>
            <span class="status-pill">Mode Demo Session</span>
        </div>
        <form method="POST" action="<?= e(url('dosen/presensi/aktifkan')) ?>" class="dosen-session-form">
            <?= csrf_field() ?>
            <div class="form-grid">
                <label class="form-field">Mata Kuliah / Kelas
                    <select name="id_jadwal" required>
                        <?php foreach ($kelas as $k): ?>
                        <option value="<?= e((string)$k['ID_JADWAL']) ?>">
                            <?= e((string)$k['ID_JADWAL']) ?> · <?= e((string)$k['NAMA_MATKUL']) ?> (Kelas <?= e((string)$k['KELAS']) ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="form-field">Jenis Perkuliahan
                    <select name="jenis_perkuliahan">
                        <option value="DARING">Daring (Validasi QR)</option>
                        <option value="LURING">Luring (Validasi QR + GPS 15m)</option>
                    </select>
                </label>
                <label class="form-field">Batas Waktu Sesi
                    <input type="datetime-local" name="batas_waktu" value="<?= e(date('Y-m-d\T23:59')) ?>">
                </label>
            </div>
            <div class="form-actions">
                <button type="submit" class="primary-button">Aktifkan Sesi &amp; Buat QR</button>
            </div>
        </form>
    </section>

    <?php foreach ($kelas as $k): ?>
    <section class="attendance-card">
        <div class="table-card-heading">
            <div class="permit-title-group">
                <h2><?= e((string)$k['NAMA_MATKUL']) ?> · Kelas <?= e((string)$k['KELAS']) ?></h2>
                <span class="count-pill"><?= count($k['presensi']) ?> pertemuan</span>
            </div>
            <?php if (!empty($k['sesi_aktif'])): ?>
                <span class="token-badge">
                    QR Aktif (<?= e((string)$k['sesi_aktif']['JENIS_PERKULIAHAN']) ?>):
                    <code><?= e((string)$k['sesi_aktif']['TOKEN_QR']) ?></code>
                </span>
            <?php else: ?>
                <span class="status-pill">Belum ada sesi aktif</span>
            <?php endif; ?>
        </div>
        <div class="table-scroll">
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>ID Presensi</th>
                        <th class="center">Pertemuan</th>
                        <th>Tanggal</th>
                        <th>Status Saat Ini</th>
                        <th>Ubah Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($k['presensi'], 0, 5) as $p): ?>
                    <tr>
                        <td class="permit-id"><?= e((string)$p['ID_PRESENSI']) ?></td>
                        <td class="center muted-cell">Pertemuan <?= e((string)$p['PERTEMUAN_KE']) ?></td>
                        <td class="muted-cell"><?= e(fmt_tgl($p['TANGGAL'])) ?></td>
                        <td>
                            <span class="permit-status <?= e(strtolower((string)$p['STATUS_PRESENSI'])) ?>">
                                <?= e(status_label((string)$p['STATUS_PRESENSI'])) ?>
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="<?= e(url('dosen/presensi/simpan')) ?>" class="inline-status-form">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_presensi" value="<?= e((string)$p['ID_PRESENSI']) ?>">
                                <select name="status" aria-label="Status presensi">
                                    <?php foreach (['HADIR', 'IZIN', 'SAKIT', 'ALPHA'] as $st): ?>
                                    <option value="<?= e($st) ?>" <?= $p['STATUS_PRESENSI'] === $st ? 'selected' : '' ?>>
                                        <?= e(status_label($st)) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="lecturer-detail-link">Simpan</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php endforeach; ?>
</section>
<?php include ROOT . '/resources/views/layouts/footer.php'; ?>
