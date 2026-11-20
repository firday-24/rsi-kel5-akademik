<?php
$title = 'Presensi Berhasil';
$breadcrumb = 'Presensi';
include ROOT . '/resources/views/layouts/header.php';
?>
<section class="simple-page attendance-card scan-result-card">
    <div class="empty-state">
        <div class="scan-result-badge success">✓</div>
        <h2>Presensi Berhasil</h2>
        <p><?= e($pesan ?? 'Kehadiran Anda berhasil dicatat.') ?></p>
        <div class="scan-result-actions">
            <a href="<?= e(url('mahasiswa/presensi')) ?>" class="primary-button">Lihat Rekap Kehadiran</a>
            <a href="<?= e(url('mahasiswa')) ?>" class="secondary-button">Beranda</a>
        </div>
    </div>
</section>
<?php include ROOT . '/resources/views/layouts/footer.php'; ?>
