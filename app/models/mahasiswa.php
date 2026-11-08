<?php
declare(strict_types=1);
class Mahasiswa {
    public function getByNim(string $nim): ?array {
        $s=db()->prepare('SELECT NIM, NAMA_MAHASISWA, PROGRAM_STUDI, ANGKATAN FROM MAHASISWA WHERE NIM=?'); $s->execute([$nim]); return $s->fetch() ?: null;
    }
}
