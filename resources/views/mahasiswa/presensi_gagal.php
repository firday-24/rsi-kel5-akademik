<?php
$title = 'Presensi Gagal';
$breadcrumb = 'Presensi';
include ROOT . '/resources/views/layouts/header.php';
?>
<section class="simple-page attendance-card scan-result-card">
    <div class="empty-state">
        <div class="scan-result-badge error">!</div>
        <h2>Presensi Gagal</h2>
        <p><?= e($pesan ?? 'Presensi tidak dapat diproses.') ?></p>
        <div class="scan-result-actions">
            <a href="<?= e(url('mahasiswa/presensi/scan')) ?>" class="primary-button">Coba Scan Lagi</a>
            <a href="<?= e(url('mahasiswa/presensi')) ?>" class="secondary-button">Rekap Kehadiran</a>
        </div>
    </div>
</section>
<?php include ROOT . '/resources/views/layouts/footer.php'; ?>
