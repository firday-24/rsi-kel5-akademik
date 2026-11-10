<?php

declare(strict_types=1);

class KRS_modal
{
    public string $dosen = '';
    public string $hari = '';
    private int $idKrs = 0;
    public string $jam = '';
    public string $kelas = '';
    public int $kuota = 0;
    public string $mataKuliah = '';
    public string $programStudi = '';
    public string $ruang = '';

    private function initDummy(): void
    {
        // Jika session belum ada ATAU masih memakai format lama (belum ada key 'mataKuliah')
        if (!isset($_SESSION['krs_jadwal']) || !isset($_SESSION['krs_jadwal'][0]['mataKuliah'])) {
            $_SESSION['krs_jadwal'] = [
                [
                    'idKrs' => 1,
                    'mataKuliah' => 'Pemrograman Dasar',
                    'programStudi' => 'PTI',
                    'sks' => '3 SKS',
                    'kelas' => 'A',
                    'dosen' => 'Agus Wicaksono',
                    'hari' => 'Senin',
                    'jam' => '07.00-08.45',
                    'ruang' => 'F3.8',
                    'kuota' => 40
                ],
                [
                    'idKrs' => 2,
                    'mataKuliah' => 'Desain Basis Data',
                    'programStudi' => 'SI',
                    'sks' => '2 SKS',
                    'kelas' => 'B',
                    'dosen' => 'Welly Purnomo, S.T., M.Kom',
                    'hari' => 'Senin',
                    'jam' => '07.00-08.45',
                    'ruang' => 'F2.8',
                    'kuota' => 40
                ],
                [
                    'idKrs' => 3,
                    'mataKuliah' => 'Agama Islam',
                    'programStudi' => 'TI',
                    'sks' => '2 SKS',
                    'kelas' => 'C',
                    'dosen' => 'Welly Purnomo, S.T., M.Kom',
                    'hari' => 'Senin',
                    'jam' => '08.45-10.15',
                    'ruang' => 'F3.8',
                    'kuota' => 40
                ],
                [
                    'idKrs' => 4,
                    'mataKuliah' => 'Probabilitas dan Statistika',
                    'programStudi' => 'TI',
                    'sks' => '3 SKS',
                    'kelas' => 'D',
                    'dosen' => 'Uun Hariyanti, S.Pd., M.Pd., Ph.D',
                    'hari' => 'Rabu',
                    'jam' => '07.00-08.45',
                    'ruang' => 'F3.9',
                    'kuota' => 40
                ],
                [
                    'idKrs' => 5,
                    'mataKuliah' => 'Matematika Diskret',
                    'programStudi' => 'SI',
                    'sks' => '2 SKS',
                    'kelas' => 'D',
                    'dosen' => 'Ir. Wibisono Sukmo Wardhono, S.T., M.T.',
                    'hari' => 'Selasa',
                    'jam' => '07.00-08.45',
                    'ruang' => 'F4.5',
                    'kuota' => 40
                ],
                [
                    'idKrs' => 6,
                    'mataKuliah' => 'Manajemen Bisnis',
                    'programStudi' => 'SI',
                    'sks' => '2 SKS',
                    'kelas' => 'A',
                    'dosen' => 'Welly Purnomo, S.T., M.Kom',
                    'hari' => 'Rabu',
                    'jam' => '07.00-08.45',
                    'ruang' => 'F2.7',
                    'kuota' => 40
                ]
            ];
        }
    }

    public function getAllDataKrs(): array
    {
        $this->initDummy();
        return $_SESSION['krs_jadwal'];
    }

    public function tambahDataKrs(array $dataKrs): void
    {
        $this->initDummy();
        $nextId = count($_SESSION['krs_jadwal']) + 1;

        $_SESSION['krs_jadwal'][] = [
            'idKrs' => $nextId,
            'mataKuliah' => $dataKrs['mataKuliah'],
            'programStudi' => $dataKrs['programStudi'],
            'sks' => '2 SKS',
            'kelas' => $dataKrs['kelas'],
            'dosen' => $dataKrs['dosen'],
            'hari' => $dataKrs['hari'],
            'jam' => $dataKrs['jam'],
            'ruang' => $dataKrs['ruang'],
            'kuota' => (int)$dataKrs['kuota']
        ];
    }

    public function getKrsById(int $idKrs): ?array
    {
        $this->initDummy();
        foreach ($_SESSION['krs_jadwal'] as $krs) {
            if ((int)$krs['idKrs'] === $idKrs) {
                return $krs;
            }
        }
        return null;
    }

    public function updateDataKrs(int $idKrs, array $dataKrs): void
    {
        $this->initDummy();
        foreach ($_SESSION['krs_jadwal'] as &$krs) {
            if ((int)$krs['idKrs'] === $idKrs) {
                $krs['mataKuliah']   = $dataKrs['mataKuliah'];
                $krs['programStudi'] = $dataKrs['programStudi'];
                $krs['kelas']        = $dataKrs['kelas'];
                $krs['dosen']        = $dataKrs['dosen'];
                $krs['hari']         = $dataKrs['hari'];
                $krs['jam']          = $dataKrs['jam'];
                $krs['ruang']        = $dataKrs['ruang'];
                $krs['kuota']        = (int)$dataKrs['kuota'];
                break;
            }
        }
    }
}
