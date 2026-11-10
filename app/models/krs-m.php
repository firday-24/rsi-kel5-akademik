<?php

declare(strict_types=1);

class KrsModel
{
    private function initDummy(): void
    {
        if (!isset($_SESSION['krs_jadwal'])) {
            $_SESSION['krs_jadwal'] = [
                [
                    'id' => 'KRS001',
                    'matkul' => 'Pemrograman Dasar',
                    'prodi' => 'PTI',
                    'sks' => '3 SKS',
                    'kelas' => 'A',
                    'dosen' => 'Agus Wicaksono',
                    'hari' => 'Senin',
                    'jam' => '07.00-08.45',
                    'ruang' => 'F3.8',
                    'kuota' => 40
                ],
                [
                    'id' => 'KRS002',
                    'matkul' => 'Desain Basis Data',
                    'prodi' => 'SI',
                    'sks' => '2 SKS',
                    'kelas' => 'B',
                    'dosen' => 'Welly Purnomo, S.T., M.Kom',
                    'hari' => 'Senin',
                    'jam' => '07.00-08.45',
                    'ruang' => 'F2.8',
                    'kuota' => 40
                ],
                [
                    'id' => 'KRS003',
                    'matkul' => 'Agama Islam',
                    'prodi' => 'TI',
                    'sks' => '2 SKS',
                    'kelas' => 'C',
                    'dosen' => 'Welly Purnomo, S.T., M.Kom',
                    'hari' => 'Senin',
                    'jam' => '08.45-10.15',
                    'ruang' => 'F3.8',
                    'kuota' => 40
                ],
                [
                    'id' => 'KRS004',
                    'matkul' => 'Probabilitas dan Statistika',
                    'prodi' => 'TI',
                    'sks' => '3 SKS',
                    'kelas' => 'D',
                    'dosen' => 'Uun Hariyanti, S.Pd., M.Pd., Ph.D',
                    'hari' => 'Rabu',
                    'jam' => '07.00-08.45',
                    'ruang' => 'F3.9',
                    'kuota' => 40
                ],
                [
                    'id' => 'KRS005',
                    'matkul' => 'Matematika Diskret',
                    'prodi' => 'SI',
                    'sks' => '2 SKS',
                    'kelas' => 'D',
                    'dosen' => 'Ir. Wibisono Sukmo Wardhono, S.T., M.T.',
                    'hari' => 'Selasa',
                    'jam' => '07.00-08.45',
                    'ruang' => 'F4.5',
                    'kuota' => 40
                ],
                [
                    'id' => 'KRS006',
                    'matkul' => 'Manajemen Bisnis',
                    'prodi' => 'SI',
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

    public function getAll(): array
    {
        $this->initDummy();
        return $_SESSION['krs_jadwal'];
    }
}
