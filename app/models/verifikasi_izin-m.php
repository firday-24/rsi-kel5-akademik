<?php
declare(strict_types=1);
class verifikasi_izin_m {
    public function getDaftarPending(string $nip): array {
        $sql="SELECT PI.ID_PENGAJUAN, PI.JENIS_IZIN, PI.KETERANGAN, PI.STATUS_PENGAJUAN, PI.TANGGAL_PENGAJUAN,
        M.NIM, M.NAMA_MAHASISWA, MK.NAMA_MATKUL, JK.KELAS, SP.PERTEMUAN_KE, SP.TANGGAL
        FROM PENGAJUAN_IZIN PI JOIN PRESENSI P ON P.ID_PRESENSI=PI.ID_PRESENSI
        JOIN SESI_PRESENSI SP ON SP.ID_SESI=P.ID_SESI JOIN KRS_DETAIL KD ON KD.ID_PENGAMBILAN=P.ID_PENGAMBILAN
        JOIN JADWAL_KULIAH JK ON JK.ID_JADWAL=KD.ID_JADWAL JOIN MATA_KULIAH MK ON MK.ID_MATKUL=JK.ID_MATKUL
        JOIN MAHASISWA M ON M.NIM=PI.NIM_PENGAJU
        WHERE JK.NIP_PENGAMPU=? AND PI.STATUS_PENGAJUAN='MENUNGGU' ORDER BY PI.TANGGAL_PENGAJUAN";
        $s=db()->prepare($sql);$s->execute([$nip]);return $s->fetchAll();
    }
    public function getDetailData(string $id,string $nip): ?array {
        $sql="SELECT PI.*, M.NIM, M.NAMA_MAHASISWA, MK.NAMA_MATKUL, JK.KELAS, JK.NIP_PENGAMPU, SP.PERTEMUAN_KE, SP.TANGGAL
        FROM PENGAJUAN_IZIN PI JOIN PRESENSI P ON P.ID_PRESENSI=PI.ID_PRESENSI
        JOIN SESI_PRESENSI SP ON SP.ID_SESI=P.ID_SESI JOIN KRS_DETAIL KD ON KD.ID_PENGAMBILAN=P.ID_PENGAMBILAN
        JOIN JADWAL_KULIAH JK ON JK.ID_JADWAL=KD.ID_JADWAL JOIN MATA_KULIAH MK ON MK.ID_MATKUL=JK.ID_MATKUL
        JOIN MAHASISWA M ON M.NIM=PI.NIM_PENGAJU WHERE PI.ID_PENGAJUAN=? AND JK.NIP_PENGAMPU=?";
        $s=db()->prepare($sql);$s->execute([$id,$nip]);return $s->fetch() ?: null;
    }
    public function updateStatusApproved(string $id,string $nip): bool { return $this->update($id,$nip,'DISETUJUI',null); }
    public function updateStatusRejected(string $id,string $nip,string $alasan): bool { return $this->update($id,$nip,'DITOLAK',$alasan); }
    public function updateLogPresensi(string $nim,string $status,string $idPresensi): bool {
        $check=db()->prepare('SELECT COUNT(*) FROM PRESENSI P JOIN KRS_DETAIL KD ON KD.ID_PENGAMBILAN=P.ID_PENGAMBILAN JOIN KRS K ON K.ID_KRS=KD.ID_KRS WHERE P.ID_PRESENSI=? AND K.NIM=?');
        $check->execute([$idPresensi,$nim]); if ((int)$check->fetchColumn()!==1) return false;
        $s=db()->prepare('UPDATE PRESENSI SET STATUS_PRESENSI=? WHERE ID_PRESENSI=?');
        $s->execute([$status,$idPresensi]); return $s->rowCount()===1;
    }
    public function kirimNotifikasi(string $nim,string $status,string $idPengajuan): bool {
        $id='NT'.date('ymdHis').random_int(10,99);$pesan=$status==='DISETUJUI'?'Pengajuan izin/sakit kamu telah disetujui.':'Pengajuan izin/sakit kamu ditolak. Silakan periksa alasan penolakan.';
        $s=db()->prepare('INSERT INTO NOTIFIKASI (ID_NOTIFIKASI,NIM,ID_PENGAJUAN,STATUS,PESAN,TANGGAL_DIBUAT,DIBACA) VALUES (?,?,?,?,?,CURRENT TIMESTAMP,0)');
        return $s->execute([$id,$nim,$idPengajuan,$status,$pesan]);
    }
    private function update(string $id,string $nip,string $status,?string $alasan): bool {
        $pdo=db();$pdo->beginTransaction();try{
            $detail=$this->getDetailData($id,$nip);if(!$detail || $detail['STATUS_PENGAJUAN']!=='MENUNGGU'){$pdo->rollBack();return false;}
            $s=$pdo->prepare("UPDATE PENGAJUAN_IZIN SET STATUS_PENGAJUAN=?, ALASAN_PENOLAKAN=?, NIP_VERIFIKATOR=?, TANGGAL_VERIFIKASI=CURRENT TIMESTAMP WHERE ID_PENGAJUAN=? AND STATUS_PENGAJUAN='MENUNGGU'");
            $s->execute([$status,$alasan,$nip,$id]);
            if($s->rowCount()!==1){$pdo->rollBack();return false;}
            if($status==='DISETUJUI'){$this->updateLogPresensi($detail['NIM'],$detail['JENIS_IZIN']==='SAKIT'?'SAKIT':'IZIN',$detail['ID_PRESENSI']);}
            $this->kirimNotifikasi($detail['NIM'],$status,$id);
            $pdo->commit();return true;
        }catch(Throwable $e){$pdo->rollBack();throw $e;}
    }
}
