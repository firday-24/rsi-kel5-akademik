<?php
$title = 'Scan Presensi';
$breadcrumb = 'Presensi';
include ROOT . '/resources/views/layouts/header.php';
$sesiAktif = $sesiAktif ?? [];
$defaultToken = !empty($sesiAktif) ? (string)$sesiAktif[0]['TOKEN_QR'] : 'TOKEN_DYNAMIC_ACTIVE';
?>
<section class="attendance-scan-page">
    <a href="<?= e(url('mahasiswa/presensi')) ?>" class="back-link"><span>←</span> Kembali ke rekap kehadiran</a>
    <div class="page-heading">
        <h1>Presensi Perkuliahan</h1>
        <p>Pindai QR Code dinamis dari dosen atau aktifkan GPS untuk kelas luring.</p>
    </div>
    <div class="scanner-card">
        <div class="camera-viewport-mock">
            <div class="scanner-laser-line"></div>
            <span>Arahkan kamera ke QR Code aktif</span>
        </div>
        <form method="POST" action="<?= e(url('mahasiswa/presensi/scan')) ?>" id="formScanQr" class="scan-form-stack">
            <?= csrf_field() ?>
            <input type="hidden" name="token_qr" id="inputTokenQr" value="<?= e($defaultToken) ?>">
            <input type="hidden" name="lat" id="inputLat" value="">
            <input type="hidden" name="lng" id="inputLng" value="">

            <div class="scan-demo-controls">
                <?php if (!empty($sesiAktif)): ?>
                <label class="form-field">Sesi Aktif (Demo QR)
                    <select id="selectDemoToken">
                        <?php foreach ($sesiAktif as $s): ?>
                        <option value="<?= e((string)$s['TOKEN_QR']) ?>">
                            <?= e((string)$s['NAMA_MATKUL']) ?> (Kelas <?= e((string)$s['KELAS']) ?> · Pertemuan <?= e((string)$s['PERTEMUAN_KE']) ?> · <?= e((string)$s['JENIS_PERKULIAHAN']) ?>)
                        </option>
                        <?php endforeach; ?>
                        <option value="TOKEN_TIDAK_VALID">Simulasi Token Tidak Valid</option>
                    </select>
                </label>
                <?php endif; ?>
                <label class="form-field">Token QR
                    <input type="text" id="visibleTokenInput" value="<?= e($defaultToken) ?>" placeholder="Masukkan token QR dari dosen">
                </label>
                <small class="gps-status-note" id="gpsStatusNote">Mendeteksi koordinat GPS perangkat...</small>
            </div>

            <button type="submit" class="primary-button full-width">Kirim Presensi</button>
        </form>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const hiddenToken = document.getElementById('inputTokenQr');
    const visibleToken = document.getElementById('visibleTokenInput');
    const selectDemo = document.getElementById('selectDemoToken');
    const gpsNote = document.getElementById('gpsStatusNote');

    if (visibleToken && hiddenToken) {
        visibleToken.addEventListener('input', function () {
            hiddenToken.value = this.value.trim();
        });
    }
    if (selectDemo && visibleToken && hiddenToken) {
        selectDemo.addEventListener('change', function () {
            visibleToken.value = this.value;
            hiddenToken.value = this.value;
        });
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (pos) {
                document.getElementById('inputLat').value = pos.coords.latitude;
                document.getElementById('inputLng').value = pos.coords.longitude;
                if (gpsNote) {
                    gpsNote.textContent = 'GPS aktif (' + pos.coords.latitude.toFixed(5) + ', ' + pos.coords.longitude.toFixed(5) + ').';
                }
            },
            function () {
                if (gpsNote) {
                    gpsNote.textContent = 'GPS tidak aktif / izin ditolak (diperlukan untuk kelas luring).';
                }
            }
        );
    } else if (gpsNote) {
        gpsNote.textContent = 'Browser tidak mendukung geolokasi.';
    }
});
</script>
<?php include ROOT . '/resources/views/layouts/footer.php'; ?>
