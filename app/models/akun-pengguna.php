<?php
declare(strict_types=1);
class AkunPengguna {
    public function ValidasiKredensial(string $email, string $kataSandi): ?array{
        $sql = 'SELECT A.ID_AKUN, A.EMAIL, A.PASSWORD_HASH, A.PERAN, A.STATUS_AKUN,
                   M.NIM, M.NAMA_MAHASISWA, D.NIP, D.NAMA_DOSEN, AD.NAMA_ADMIN
            FROM AKUN_PENGGUNA A
            LEFT JOIN MAHASISWA M ON M.ID_AKUN = A.ID_AKUN
            LEFT JOIN DOSEN D ON D.ID_AKUN = A.ID_AKUN
            LEFT JOIN ADMIN_AKADEMIK AD ON AD.ID_AKUN = A.ID_AKUN
            WHERE LOWER(A.EMAIL) = LOWER(CAST(? AS VARCHAR(120)))
               OR CAST(M.NIM AS VARCHAR(120)) = CAST(? AS VARCHAR(120))
               OR CAST(D.NIP AS VARCHAR(120)) = CAST(? AS VARCHAR(120))';
        $stmt = db()->prepare($sql);
        $stmt->execute([$email, $email, $email]);
        $row = $stmt->fetch();
        if (
            !$row ||
            $row['STATUS_AKUN'] !== 'AKTIF' ||
            !password_verify($kataSandi, $row['PASSWORD_HASH'])
        ) {
        return null;
        }
        
        $name = $row['NAMA_MAHASISWA']
        ?: ($row['NAMA_DOSEN'] ?: $row['NAMA_ADMIN']);
        
        return [
            'id' => $row['ID_AKUN'],
            'email' => $row['EMAIL'],
            'role' => $row['PERAN'],
            'name' => $name,
            'nim' => $row['NIM'],
            'nip' => $row['NIP']
        ];
    }
}
