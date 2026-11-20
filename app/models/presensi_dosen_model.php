<?php
declare(strict_types=1);

/**
 * Model presensi untuk Dosen (berbasis DemoStore session).
 */
class presensi_dosen_model {
    private const ALLOWED_STATUS = ['HADIR', 'IZIN', 'SAKIT', 'ALPHA'];

    public function getDaftarKelasMengajar(string $nip): array {
        $d = &DemoStore::data();
        $out = [];

        foreach ($d['courses'] as $c) {
            $presensi = [];
            foreach ($d['meetings'] as $m) {
                if ($m['course_id'] === $c['id']) {
                    $presensi[] = [
                        'ID_PRESENSI' => $m['id'],
                        'PERTEMUAN_KE' => $m['meeting'],
                        'TANGGAL' => $m['date'],
                        'STATUS_PRESENSI' => $m['status'],
                    ];
                }
            }

            $sesiList = [];
            $sesiAktif = null;
            foreach ($d['sessions'] as $s) {
                if ($s['ID_JADWAL'] === $c['id']) {
                    $sesiList[] = $s;
                    if ((int)$s['STATUS_AKTIF'] === 1) {
                        $sesiAktif = $s;
                    }
                }
            }

            $out[] = [
                'ID_JADWAL' => $c['id'],
                'NAMA_MATKUL' => $c['name'],
                'KELAS' => $c['class'],
                'NIP_PENGAMPU' => $nip,
                'sesi_aktif' => $sesiAktif,
                'riwayat_sesi' => array_reverse($sesiList),
                'presensi' => array_reverse($presensi),
            ];
        }

        return $out;
    }

    public function buatDanAktifkanSesi(
        string $idJadwal,
        string $batasWaktu,
        string $tokenQr,
        string $jenisPerkuliahan = 'DARING'
    ): bool {
        $d = &DemoStore::data();
        $course = null;
        foreach ($d['courses'] as $c) {
            if ($c['id'] === $idJadwal) {
                $course = $c;
                break;
            }
        }
        if (!$course || trim($tokenQr) === '') {
            return false;
        }

        foreach ($d['sessions'] as &$s) {
            if ($s['ID_JADWAL'] === $idJadwal) {
                $s['STATUS_AKTIF'] = 0;
            }
        }
        unset($s);

        $maxMeeting = 0;
        foreach ($d['meetings'] as $m) {
            if ($m['course_id'] === $idJadwal && (int)$m['meeting'] > $maxMeeting) {
                $maxMeeting = (int)$m['meeting'];
            }
        }
        $nextMeeting = $maxMeeting + 1;
        $newPresensiId = 'PRS' . str_pad((string)(count($d['meetings']) + 1), 3, '0', STR_PAD_LEFT);
        $tanggal = date('Y-m-d');

        $d['meetings'][] = [
            'id' => $newPresensiId,
            'course_id' => $course['id'],
            'course' => $course['name'],
            'class' => $course['class'],
            'meeting' => $nextMeeting,
            'date' => $tanggal,
            'status' => 'ALPHA',
        ];

        $newSesiId = 'SES' . str_pad((string)(count($d['sessions']) + 1), 3, '0', STR_PAD_LEFT);
        $jenis = strtoupper($jenisPerkuliahan) === 'LURING' ? 'LURING' : 'DARING';
        $batas = trim($batasWaktu) !== '' ? str_replace('T', ' ', trim($batasWaktu)) : ($tanggal . ' 23:59:00');

        $d['sessions'][] = [
            'ID_SESI' => $newSesiId,
            'ID_JADWAL' => $idJadwal,
            'ID_PRESENSI' => $newPresensiId,
            'PERTEMUAN_KE' => $nextMeeting,
            'TANGGAL' => $tanggal,
            'BATAS_WAKTU' => $batas,
            'STATUS_AKTIF' => 1,
            'TOKEN_QR' => $tokenQr,
            'JENIS_PERKULIAHAN' => $jenis,
        ];

        return true;
    }

    public function cekStatusPengajuanIzin(string $idPresensi): bool {
        $d = &DemoStore::data();
        foreach ($d['requests'] as $r) {
            if ($r['meeting_id'] === $idPresensi && $r['status'] === 'DISETUJUI') {
                return true;
            }
        }
        return false;
    }

    public function updateStatusPresensiMahasiswa(string $idPresensi, string $statusBaru): bool {
        $status = strtoupper(trim($statusBaru));
        if (!in_array($status, self::ALLOWED_STATUS, true)) {
            return false;
        }

        $d = &DemoStore::data();
        foreach ($d['meetings'] as &$m) {
            if ($m['id'] === $idPresensi) {
                $m['status'] = $status;
                return true;
            }
        }
        unset($m);

        return false;
    }

    public function getPresensiById(string $idPresensi): ?array {
        $d = &DemoStore::data();
        foreach ($d['meetings'] as $m) {
            if ($m['id'] === $idPresensi) {
                return [
                    'ID_PRESENSI' => $m['id'],
                    'ID_JADWAL' => $m['course_id'],
                    'NAMA_MATKUL' => $m['course'],
                    'KELAS' => $m['class'],
                    'PERTEMUAN_KE' => $m['meeting'],
                    'TANGGAL' => $m['date'],
                    'STATUS_PRESENSI' => $m['status'],
                ];
            }
        }
        return null;
    }
}
