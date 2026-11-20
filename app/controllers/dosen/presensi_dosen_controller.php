<?php
declare(strict_types=1);

/**
 * Controller Presensi Dosen (RE - CTRL10).
 */
class presensi_dosen_controller {
    public function getKelolaPresensi(): void {
        AuthMiddleware::role('DOSEN');
        $nip = (string)(current_user()['nip'] ?? '');
        $model = new presensi_dosen_model();
        $kelas = $model->getDaftarKelasMengajar($nip);
        view('dosen/tampil_kelola_presensi', [
            'kelas' => $kelas,
            'success' => flash('success'),
            'error' => flash('error'),
        ]);
    }

    public function aktifkanSesi(): void {
        AuthMiddleware::role('DOSEN');
        require_post_csrf();
        $idJadwal = (string)($_POST['id_jadwal'] ?? '');
        $batasWaktu = (string)($_POST['batas_waktu'] ?? '');
        $jenis = (string)($_POST['jenis_perkuliahan'] ?? 'DARING');
        $tokenQr = bin2hex(random_bytes(16));

        $model = new presensi_dosen_model();
        $sukses = $model->buatDanAktifkanSesi($idJadwal, $batasWaktu, $tokenQr, $jenis);
        if ($sukses) {
            flash('success', 'Sesi presensi berhasil diaktifkan dengan QR Dinamis.');
        } else {
            flash('error', 'Gagal mengaktifkan sesi presensi.');
        }
        redirect('dosen/presensi');
    }

    public function formEdit(string $idPresensi): void {
        AuthMiddleware::role('DOSEN');
        $row = (new presensi_dosen_model())->getPresensiById($idPresensi);
        if (!$row) {
            http_response_code(404);
            view('auth/404');
            return;
        }
        view('dosen/tampil_edit_presensi', [
            'row' => $row,
            'error' => flash('error'),
        ]);
    }

    public function simpanPerubahanPresensi(): void {
        AuthMiddleware::role('DOSEN');
        require_post_csrf();
        $idPresensi = (string)($_POST['id_presensi'] ?? '');
        $statusBaru = (string)($_POST['status'] ?? '');

        $model = new presensi_dosen_model();
        if (in_array($statusBaru, ['IZIN', 'SAKIT'], true)) {
            $izinSetuju = $model->cekStatusPengajuanIzin($idPresensi);
            if (!$izinSetuju) {
                flash('error', 'Status Izin/Sakit hanya dapat digunakan setelah pengajuan disetujui.');
                redirect('dosen/presensi/edit/' . $idPresensi);
                return;
            }
        }
        $sukses = $model->updateStatusPresensiMahasiswa($idPresensi, $statusBaru);
        flash($sukses ? 'success' : 'error', $sukses ? 'Data presensi berhasil diperbarui.' : 'Gagal memperbarui presensi.');
        redirect('dosen/presensi');
    }
}
