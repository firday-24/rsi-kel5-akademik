<?php
declare(strict_types=1);
session_start();
if (empty($_SESSION['_csrf'])) $_SESSION['_csrf'] = bin2hex(random_bytes(32));
if (!defined('ROOT')) define('ROOT', dirname(__DIR__));
if (PHP_SAPI === 'cli-server') {
    $requested = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $staticFile = __DIR__ . $requested;
    if ($requested !== '/' && is_file($staticFile)) return false;
}
require ROOT . '/config/database.php';
load_env_file(ROOT . '/.env');
require ROOT . '/app/core/Helpers.php';
require ROOT . '/app/middleware/AuthMiddleware.php';
foreach (glob(ROOT . '/app/models/*.php') as $f) require_once $f;
foreach (glob(ROOT . '/app/controllers/*.php') as $f) require_once $f;
foreach (glob(ROOT . '/app/controllers/*/*.php') as $f) require_once $f;
header('X-Content-Type-Options: nosniff'); header('X-Frame-Options: SAMEORIGIN'); header('Referrer-Policy: strict-origin-when-cross-origin');
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$base = base_path_url(); if ($base !== '' && str_starts_with($path, $base)) $path = substr($path, strlen($base)) ?: '/';
$path = '/' . trim($path, '/'); if ($path === '//') $path = '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
try {
 if ($method === 'POST') require_post_csrf();
 if ($method==='GET' && $path==='/') (new Login())->Tampilkan();
 elseif ($method==='POST' && $path==='/login') (new Login())->ProsesLogin();
 elseif ($method==='POST' && $path==='/logout') (new Login())->Logout();
 elseif ($method==='GET' && $path==='/mahasiswa') (new BerandaMahasiswa())->tampil();
 elseif ($method==='GET' && $path==='/mahasiswa/presensi') (new presensi())->getLogPresensi();
 elseif ($method==='GET' && $path==='/mahasiswa/izin') (new izin())->getRiwayatPengajuan();
 elseif ($method==='GET' && $path==='/mahasiswa/izin/buat') (new izin())->getFormPengajuan();
 elseif ($method==='POST' && $path==='/mahasiswa/izin/simpan') (new izin())->simpanPengajuan();
 elseif ($method==='GET' && $path==='/dosen') (new BerandaDosen())->tampil();
 elseif ($method==='GET' && $path==='/dosen/izin') (new verifikasi_izin())->getDaftarPengajuanPending();
 elseif ($method==='POST' && preg_match('#^/dosen/izin/([^/]+)/setujui$#',$path,$m)) (new verifikasi_izin())->prosesSetujui(rawurldecode($m[1]));
 elseif ($method==='POST' && preg_match('#^/dosen/izin/([^/]+)/tolak$#',$path,$m)) (new verifikasi_izin())->prosesTolak(rawurldecode($m[1]));
 elseif ($method==='GET' && preg_match('#^/dosen/izin/([^/]+)$#',$path,$m)) (new verifikasi_izin())->getDetailPengajuan(rawurldecode($m[1]));
 elseif ($method==='GET' && $path==='/admin') {AuthMiddleware::role('ADMIN_AKADEMIK');$title='Admin Akademik';$isDosen=false;view('auth/admin');}
 else {http_response_code(404);view('auth/404');}
} catch (Throwable $e) {
 http_response_code(500); error_log((string)$e);
 if (envv('APP_ENV','development')==='development') echo '<main style="font-family:Arial;padding:32px"><h2>Terjadi kesalahan aplikasi</h2><pre>'.e($e->getMessage()).'</pre><p>Periksa koneksi Db2, file .env, dan log PHP.</p></main>';
 else echo 'Terjadi kesalahan pada aplikasi.';
}
