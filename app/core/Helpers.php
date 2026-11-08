<?php
declare(strict_types=1);

function base_path_url(): string { return rtrim((string)envv('APP_BASE_PATH', '/portal-mahasiswa/public'), '/'); }
function url(string $path = ''): string { return base_path_url() . ($path === '' ? '/' : '/' . ltrim($path, '/')); }
function redirect(string $path): never { header('Location: ' . url($path)); exit; }
function e(?string $value): string { return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function csrf_field(): string { return '<input type="hidden" name="_token" value="' . e($_SESSION['_csrf'] ?? '') . '">'; }
function flash(string $key, ?string $value = null): ?string {
    if ($value !== null) { $_SESSION['_flash'][$key] = $value; return null; }
    $result = $_SESSION['_flash'][$key] ?? null; unset($_SESSION['_flash'][$key]); return $result;
}
function view(string $file, array $data = []): void {
    extract($data, EXTR_SKIP);
    $viewFile = ROOT . '/resources/views/' . $file . '.php';
    if (!is_file($viewFile)) throw new RuntimeException("View tidak ditemukan: {$file}");
    require $viewFile;
}
function current_user(): ?array { return $_SESSION['user'] ?? null; }
function initials(string $name): string {
    $parts = preg_split('/\s+/', trim($name));
    return strtoupper(substr($parts[0] ?? 'U', 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
}
function status_label(string $status): string { return match (strtoupper($status)) { 'MENUNGGU' => 'Menunggu', 'DISETUJUI' => 'Disetujui', 'DITOLAK' => 'Ditolak', 'HADIR' => 'Hadir', 'IZIN' => 'Izin', 'SAKIT' => 'Sakit', 'ALPHA' => 'Alpha', default => ucfirst(strtolower($status)) }; }
function require_post_csrf(): void {
    $token = (string)($_POST['_token'] ?? '');
    if (!hash_equals((string)($_SESSION['_csrf'] ?? ''), $token)) { http_response_code(419); exit('Sesi formulir kedaluwarsa. Muat ulang halaman.'); }
}
