<?php
declare(strict_types=1);
class izin_m {
    public function getDataRiwayat(string $nim): array {
        $sql="SELECT PI.ID_PENGAJUAN, PI.JENIS_IZIN, PI.KETERANGAN, PI.FILE_BUKTI, PI.STATUS_PENGAJUAN, PI.ALASAN_PENOLAKAN, PI.TANGGAL_PENGAJUAN,
        MK.NAMA_MATKUL, SP.PERTEMUAN_KE, SP.TANGGAL
        FROM PENGAJUAN_IZIN PI JOIN PRESENSI P ON P.ID_PRESENSI=PI.ID_PRESENSI
        JOIN SESI_PRESENSI SP ON SP.ID_SESI=P.ID_SESI JOIN KRS_DETAIL KD ON KD.ID_PENGAMBILAN=P.ID_PENGAMBILAN
        JOIN JADWAL_KULIAH JK ON JK.ID_JADWAL=KD.ID_JADWAL JOIN MATA_KULIAH MK ON MK.ID_MATKUL=JK.ID_MATKUL
        WHERE PI.NIM_PENGAJU=? ORDER BY PI.TANGGAL_PENGAJUAN DESC";
        $s=db()->prepare($sql);$s->execute([$nim]);return $s->fetchAll();
    }
    public function getFormPengajuan(string $nim): array {
        $sql="SELECT P.ID_PRESENSI, MK.NAMA_MATKUL, JK.KELAS, SP.PERTEMUAN_KE, SP.TANGGAL, P.STATUS_PRESENSI
        FROM PRESENSI P JOIN KRS_DETAIL KD ON KD.ID_PENGAMBILAN=P.ID_PENGAMBILAN JOIN KRS K ON K.ID_KRS=KD.ID_KRS
        JOIN JADWAL_KULIAH JK ON JK.ID_JADWAL=KD.ID_JADWAL JOIN MATA_KULIAH MK ON MK.ID_MATKUL=JK.ID_MATKUL
        JOIN SESI_PRESENSI SP ON SP.ID_SESI=P.ID_SESI
        WHERE K.NIM=? AND P.STATUS_PRESENSI='ALPHA' AND NOT EXISTS (SELECT 1 FROM PENGAJUAN_IZIN X WHERE X.ID_PRESENSI=P.ID_PRESENSI)
        ORDER BY SP.TANGGAL DESC";
        $s=db()->prepare($sql);$s->execute([$nim]);return $s->fetchAll();
    }
    public function canSubmit(string $idPresensi,string $nim): bool {
        $s=db()->prepare("SELECT COUNT(*) AS JML FROM PRESENSI P JOIN KRS_DETAIL KD ON KD.ID_PENGAMBILAN=P.ID_PENGAMBILAN JOIN KRS K ON K.ID_KRS=KD.ID_KRS WHERE P.ID_PRESENSI=? AND K.NIM=? AND P.STATUS_PRESENSI='ALPHA' AND NOT EXISTS (SELECT 1 FROM PENGAJUAN_IZIN X WHERE X.ID_PRESENSI=P.ID_PRESENSI)");
        $s->execute([$idPresensi,$nim]); return (int)$s->fetchColumn() > 0;
    }
    public function insertDataPengajuan(string $idPresensi,string $nim,string $jenis,string $keterangan,string $file): string {
        if (!$this->canSubmit($idPresensi,$nim)) throw new RuntimeException('Pertemuan tidak valid untuk diajukan.');
        $id='IZ'.date('ymdHis').random_int(10,99);
        $s=db()->prepare("INSERT INTO PENGAJUAN_IZIN (ID_PENGAJUAN, ID_PRESENSI, NIM_PENGAJU, JENIS_IZIN, KETERANGAN, FILE_BUKTI, STATUS_PENGAJUAN, TANGGAL_PENGAJUAN) VALUES (?,?,?,?,?,?, 'MENUNGGU', CURRENT TIMESTAMP)");
        $s->execute([$id,$idPresensi,$nim,$jenis,$keterangan,$file]); return $id;
    }
}
