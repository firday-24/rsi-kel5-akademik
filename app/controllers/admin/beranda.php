<?php
declare(strict_types=1);

class BerandaAdmin {
    public function tampil(): void {
        // 1. Panggil middleware sesuai nama fungsi dan huruf kapital 'ADMIN'
        AuthMiddleware::role('ADMIN');

        // 2. Ambil nama dari key 'name' (sesuai struktur di akun-pengguna.php)
        $user = current_user();
        $nama_admin = $user['name'] ?? 'Dwi Handayani';
        $nama_depan = explode(' ', $nama_admin)[0];

        // 3. Data statistik statis sesuai UI Gambar 2
        $statistik = [
            'mahasiswa_aktif' => '2.501',
            'angkatan_aktif'  => '5',
            'total_dosen'     => '107'
        ];

        // 4. Panggil view menggunakan helper view() bawaan sistem
        view('admin/tampil_menu_utama', [
            'nama_admin' => $nama_admin,
            'nama_depan' => $nama_depan,
            'statistik'  => $statistik
        ]);
    }
}