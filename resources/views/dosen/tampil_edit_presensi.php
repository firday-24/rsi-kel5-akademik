<?php
$title = 'Edit Presensi';
$breadcrumb = 'Presensi';
include ROOT . '/resources/views/layouts/header.php';
?>
<section class="attendance-page lecturer-queue-page">
    <a href="<?= e(url('dosen/presensi')) ?>" class="back-link"><span>←</span> Kembali ke kelola presensi</a>
    <div class="page-heading lecturer-page-heading">
        <h1>Edit Status Presensi</h1>
        <p><?= e((string)$row['NAMA_MATKUL']) ?> · Kelas <?= e((string)$row['KELAS']) ?> · Pertemuan <?= e((string)$row['PERTEMUAN_KE']) ?></p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="lecturer-flash error"><?= e($error) ?></div>
    <?php endif; ?>

    <section class="attendance-card">
        <div class="table-card-heading">
            <h2>Detail Pertemuan (<?= e((string)$row['ID_PRESENSI']) ?>)</h2>
            <span class="permit-status <?= e(strtolower((string)$row['STATUS_PRESENSI'])) ?>"><?= e(status_label((string)$row['STATUS_PRESENSI'])) ?></span>
        </div>
        <form method="POST" action="<?= e(url('dosen/presensi/simpan')) ?>" class="dosen-session-form">
            <?= csrf_field() ?>
            <input type="hidden" name="id_presensi" value="<?= e((string)$row['ID_PRESENSI']) ?>">
            <div class="form-grid">
                <label class="form-field">Tanggal Pertemuan
                    <input type="text" value="<?= e(fmt_tgl($row['TANGGAL'])) ?>" readonly>
                </label>
                <label class="form-field">Status Baru
                    <select name="status">
                        <?php foreach (['HADIR', 'IZIN', 'SAKIT', 'ALPHA'] as $st): ?>
                        <option value="<?= e($st) ?>" <?= $row['STATUS_PRESENSI'] === $st ? 'selected' : '' ?>>
                            <?= e(status_label($st)) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>
            <div class="form-actions">
                <a href="<?= e(url('dosen/presensi')) ?>" class="secondary-button">Batal</a>
                <button type="submit" class="primary-button">Simpan Perubahan</button>
            </div>
        </form>
    </section>
</section>
<?php include ROOT . '/resources/views/layouts/footer.php'; ?>
