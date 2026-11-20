<?php
declare(strict_types=1);

/**
 * Model presensi untuk Mahasiswa (scan QR dinamis & validasi radius GPS).
 */
class presensi_mahasiswa_model {
    private const KOORDINAT_KELAS_DEFAULT = [
        'SI101' => ['lat' => -7.953700, 'lng' => 112.614700],
        'SI102' => ['lat' => -7.953700, 'lng' => 112.614700],
        'SI103' => ['lat' => -7.953700, 'lng' => 112.614700],
    ];

    public function getDataSesiByToken(string $tokenQr): ?array {
        if ($tokenQr === '') {
            return null;
        }
        $d = &DemoStore::data();
        foreach ($d['sessions'] as $s) {
            if ($s['TOKEN_QR'] === $tokenQr) {
                return $s;
            }
        }
        return null;
    }

    public function getSesiAktif(): array {
        $d = &DemoStore::data();
        $coursesById = [];
        foreach ($d['courses'] as $c) {
            $coursesById[$c['id']] = $c;
        }

        $out = [];
        foreach ($d['sessions'] as $s) {
            if ((int)$s['STATUS_AKTIF'] === 1) {
                $c = $coursesById[$s['ID_JADWAL']] ?? ['name' => $s['ID_JADWAL'], 'class' => '-'];
                $s['NAMA_MATKUL'] = $c['name'];
                $s['KELAS'] = $c['class'];
                $out[] = $s;
            }
        }
        return $out;
    }

    public function catatKehadiranHadir(string $nim, string $idSesi, string $waktuScan): bool {
        $d = &DemoStore::data();
        $idPresensi = null;
        foreach ($d['sessions'] as $s) {
            if ($s['ID_SESI'] === $idSesi) {
                $idPresensi = $s['ID_PRESENSI'] ?? null;
                break;
            }
        }
        if (!$idPresensi) {
            return false;
        }

        foreach ($d['meetings'] as &$m) {
            if ($m['id'] === $idPresensi) {
                $m['status'] = 'HADIR';
                $m['waktu_scan'] = $waktuScan;
                $m['nim_scan'] = $nim;
                return true;
            }
        }
        unset($m);

        return false;
    }

    public function hitungJarakGpsKelas(float $latMhs, float $lngMhs, string $idJadwal): float {
        if ($latMhs === 0.0 && $lngMhs === 0.0) {
            return 999999.0;
        }

        $kelas = self::KOORDINAT_KELAS_DEFAULT[$idJadwal] ?? ['lat' => -7.953700, 'lng' => 112.614700];
        $earthRadius = 6371000.0;
        $dLat = deg2rad($kelas['lat'] - $latMhs);
        $dLng = deg2rad($kelas['lng'] - $lngMhs);

        $a = sin($dLat / 2) ** 2
            + cos(deg2rad($latMhs)) * cos(deg2rad($kelas['lat'])) * (sin($dLng / 2) ** 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    public function catatLogDugaanKecurangan(string $nim, string $idSesi, string $alasan): void {
        $d = &DemoStore::data();
        $d['fraud_logs'][] = [
            'nim' => $nim,
            'id_sesi' => $idSesi,
            'alasan' => $alasan,
            'waktu' => date('Y-m-d H:i:s'),
        ];
    }
}
