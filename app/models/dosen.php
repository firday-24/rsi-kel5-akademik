<?php
declare(strict_types=1);
class Dosen {
    public function getByNip(string $nip): ?array {
        $s=db()->prepare('SELECT NIP, NAMA_DOSEN FROM DOSEN WHERE NIP=?'); $s->execute([$nip]); return $s->fetch() ?: null;
    }
}
