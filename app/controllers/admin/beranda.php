<?php
// Panggil middleware untuk memastikan yang masuk adalah admin
// AuthMiddleware::check('admin'); // sesuaikan dengan nama fungsi di AuthMiddleware.php

$nama_admin = $_SESSION['user']['nama'] ?? 'Dwi Handayani';
$nama_depan = explode(' ', $nama_admin)[0];

// Data statistik statis (tanpa database) sesuai UI Gambar 2
$statistik = [
    'mahasiswa_aktif' => '2.501',
    'angkatan_aktif'  => '5',
    'total_dosen'     => '107'
];

// Panggil tampilan view admin
require_once __DIR__ . '/../../../resources/views/admin/tampil_menu_utama.php';