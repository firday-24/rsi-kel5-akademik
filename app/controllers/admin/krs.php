<?php

declare(strict_types=1);

class KRS
{
    private int $isKrs = 0;

    public function tampilkan(): void
    {
        AuthMiddleware::role('ADMIN');

        $user = current_user();
        $nama_admin = $user['name'] ?? 'Dwi Handayani';
        $daftar_krs = (new KRS_modal())->getAllDataKrs();

        view('admin/tampil_kelola_krs', [
            'nama_admin' => $nama_admin,
            'daftar_krs' => $daftar_krs
        ]);
    }

    public function formTambah(): void
    {
        AuthMiddleware::role('ADMIN');

        $user = current_user();
        $nama_admin = $user['name'] ?? 'Dwi Handayani';

        view('admin/tambah_KRS', [
            'nama_admin' => $nama_admin
        ]);
    }

    public function tambahKrs(): void
    {
        AuthMiddleware::role('ADMIN');

        $jamMulai = trim((string)($_POST['jam_mulai'] ?? ''));
        $jamSelesai = trim((string)($_POST['jam_selesai'] ?? ''));
        $jamGabung = ($jamMulai !== '' && $jamSelesai !== '') ? "$jamMulai-$jamSelesai" : '-';

        $dataKrs = [
            'mataKuliah'   => trim((string)($_POST['mataKuliah'] ?? '')),
            'programStudi' => trim((string)($_POST['programStudi'] ?? '')),
            'kelas'        => trim((string)($_POST['kelas'] ?? '')),
            'dosen'        => trim((string)($_POST['dosen'] ?? '')),
            'hari'         => trim((string)($_POST['hari'] ?? '')),
            'jam'          => $jamGabung,
            'ruang'        => trim((string)($_POST['ruang'] ?? '')),
            'kuota'        => (int)($_POST['kuota'] ?? 40),
        ];

        (new KRS_modal())->tambahDataKrs($dataKrs);

        // Kembali ke halaman Kelola KRS setelah submit
        redirect('admin/krs');
    }

    public function formEdit(int $idKrs): void
    {
        AuthMiddleware::role('ADMIN');

        $krs = (new KRS_modal())->getKrsById($idKrs);
        if (!$krs) {
            redirect('admin/krs');
        }

        // Memecah jam "07.00-08.45" menjadi jam_mulai dan jam_selesai
        $pecahJam = explode('-', $krs['jam'] ?? '');
        $krs['jam_mulai']   = trim($pecahJam[0] ?? '');
        $krs['jam_selesai'] = trim($pecahJam[1] ?? '');

        $user = current_user();
        $nama_admin = $user['name'] ?? 'Dwi Handayani';

        view('admin/edit_KRS', [
            'nama_admin' => $nama_admin,
            'krs'        => $krs
        ]);
    }

    public function editKrs(int $idKrs): void
    {
        AuthMiddleware::role('ADMIN');

        $jamMulai   = trim((string)($_POST['jam_mulai'] ?? ''));
        $jamSelesai = trim((string)($_POST['jam_selesai'] ?? ''));
        $jamGabung  = ($jamMulai !== '' && $jamSelesai !== '') ? "$jamMulai-$jamSelesai" : '-';

        $dataKrs = [
            'mataKuliah'   => trim((string)($_POST['mataKuliah'] ?? '')),
            'programStudi' => trim((string)($_POST['programStudi'] ?? '')),
            'kelas'        => trim((string)($_POST['kelas'] ?? '')),
            'dosen'        => trim((string)($_POST['dosen'] ?? '')),
            'hari'         => trim((string)($_POST['hari'] ?? '')),
            'jam'          => $jamGabung,
            'ruang'        => trim((string)($_POST['ruang'] ?? '')),
            'kuota'        => (int)($_POST['kuota'] ?? 40),
        ];

        (new KRS_modal())->updateDataKrs($idKrs, $dataKrs);

        // Kembali ke halaman Kelola KRS setelah submit
        redirect('admin/krs');
    }
}
