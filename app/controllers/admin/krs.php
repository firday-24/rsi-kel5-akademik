<?php

declare(strict_types=1);

class KelolaKrsAdmin
{
    public function tampil(): void
    {
        AuthMiddleware::role('ADMIN');

        $user = current_user();
        $nama_admin = $user['name'] ?? 'Dwi Handayani';
        $daftar_krs = (new KrsModel())->getAll();

        view('admin/tampil_kelola_krs', [
            'nama_admin' => $nama_admin,
            'daftar_krs' => $daftar_krs
        ]);
    }
}
