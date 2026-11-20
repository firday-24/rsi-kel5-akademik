<?php
declare(strict_types=1);

/**
 * Controller Presensi Mahasiswa (RE - CTRL11).
 */
class presensi_mahasiswa_controller {
    public function tampil(): void {
        AuthMiddleware::role('MAHASISWA');
        $sesiAktif = (new presensi_mahasiswa_model())->getSesiAktif();
        view('mahasiswa/tampil_presensi_mahasiswa', [
            'sesiAktif' => $sesiAktif,
        ]);
    }

    public function kirimDataQR(): void {
        AuthMiddleware::role('MAHASISWA');
        require_post_csrf();
        $nim = (string)(current_user()['nim'] ?? '');
        $tokenQr = trim((string)($_POST['token_qr'] ?? ''));
        $waktuScan = date('Y-m-d H:i:s');
        $model = new presensi_mahasiswa_model();
        $sesi = $model->getDataSesiByToken($tokenQr);

        if (!$sesi || (int)$sesi['STATUS_AKTIF'] !== 1) {
            view('mahasiswa/presensi_gagal', ['pesan' => 'QR tidak valid atau sesi presensi telah berakhir.']);
            return;
        }

        if ($sesi['JENIS_PERKULIAHAN'] === 'DARING') {
            $model->catatKehadiranHadir($nim, $sesi['ID_SESI'], $waktuScan);
            view('mahasiswa/presensi_berhasil', ['pesan' => 'Presensi daring berhasil dicatat sebagai Hadir.']);
        } else {
            // Luring: Validasi GPS Koordinat Max 15 Meter dari Lokasi Kelas
            $latMhs = (float)($_POST['lat'] ?? 0);
            $lngMhs = (float)($_POST['lng'] ?? 0);
            $jarakMhsMeter = $model->hitungJarakGpsKelas($latMhs, $lngMhs, (string)$sesi['ID_JADWAL']);
            if ($jarakMhsMeter <= 15.0) {
                $model->catatKehadiranHadir($nim, $sesi['ID_SESI'], $waktuScan);
                view('mahasiswa/presensi_berhasil', ['pesan' => 'Presensi luring berhasil. Posisi dalam jangkauan 15 meter.']);
            } else {
                $model->catatLogDugaanKecurangan($nim, $sesi['ID_SESI'], 'Diluar radius 15 meter');
                view('mahasiswa/presensi_gagal', ['pesan' => 'Anda tidak masuk dalam jangkauan area kelas ( > 15 meter).']);
            }
        }
    }
}
