<?php
declare(strict_types=1);

function load_env_file(string $file): void {
    if (!is_file($file)) return;
    foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim(trim($value), "\"'");
    }
}

function envv(string $key, ?string $default = null): ?string {
    return $_ENV[$key] ?? getenv($key) ?: $default;
}

function db(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;
    $host = envv('DB2_HOST', '127.0.0.1');
    $port = envv('DB2_PORT', '50000');
    $database = envv('DB2_DATABASE', 'PORTALDB');
    $user = envv('DB2_USER', 'PORTAL_APP');
    $password = envv('DB2_PASSWORD', '');
    $charset = envv('DB2_CHARSET', 'UTF-8');
    if (!extension_loaded('pdo_ibm')) {
        throw new RuntimeException('Ekstensi PHP pdo_ibm belum aktif. Instal driver IBM Data Server Driver dan aktifkan extension pdo_ibm di php.ini.');
    }
    $dsn = "ibm:DRIVER={IBM DB2 ODBC DRIVER};DATABASE={$database};HOSTNAME={$host};PORT={$port};PROTOCOL=TCPIP;CHARSET={$charset};";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    $schema = strtoupper((string) envv('DB2_SCHEMA', 'PORTAL'));
    if (!preg_match('/^[A-Z][A-Z0-9_]{0,127}$/', $schema)) throw new RuntimeException('Nama schema Db2 tidak valid.');
    $pdo->exec("SET CURRENT SCHEMA {$schema}");
    return $pdo;
}
