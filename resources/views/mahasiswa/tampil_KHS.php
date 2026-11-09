<?php
$title = 'KHS'; $breadcrumb = 'KHS';
include ROOT . '/resources/views/layouts/header.php';
$semesterTerpilih = (int)($semesterTerpilih ?? 3);
$nim = (string)(current_user()['nim'] ?? '');
?>
<style>
.khs-page{max-width:1168px;margin:34px auto 70px;padding:0 24px;color:#1c2b45}.khs-heading h1{font-size:28px;margin:0 0 8px;font-weight:750}.khs-heading p{color:#7788a5;margin:0 0 22px;font-size:14px}.khs-card{background:#fff;border:1px solid #dfe7f2;border-radius:15px;overflow:hidden}.khs-card-head{padding:20px;border-bottom:1px solid #dfe7f2;display:flex;justify-content:space-between;gap:12px;align-items:center}.khs-card-head h2{font-size:16px;font-weight:500;margin:0}.khs-updated{font-size:11px;color:#7b8ba6}.khs-tools{display:flex;gap:14px;align-items:center;padding:18px 20px;border-bottom:1px solid #dfe7f2;flex-wrap:wrap}.khs-tools select{border:0;background:#edf3ff;color:#245bd8;border-radius:6px;padding:6px 12px;min-width:190px}.khs-btn{border:0;background:#285bd8;color:white;border-radius:6px;padding:7px 24px;cursor:pointer;font-size:12px}.khs-table-wrap{overflow-x:auto}.khs-table{width:100%;border-collapse:collapse;font-size:12px}.khs-table th{background:#f7f9fc;color:#71829f;text-align:left;font-weight:600;padding:15px 19px;white-space:nowrap}.khs-table td{padding:16px 19px;border-top:1px solid #e1e8f2;color:#71829f}.khs-table td:nth-child(2){color:#23344f}.khs-table .center{text-align:center}.khs-course small{display:block;color:#8190a9;font-size:10px;margin-top:5px}.khs-grade{color:#1e3555!important;font-weight:600}.khs-detail{border:0;background:#edf3ff;color:#245bd8;border-radius:3px;padding:5px 9px;cursor:pointer;font-size:11px}.khs-muted{color:#7e8da6}.khs-empty{padding:30px;text-align:center;color:#7586a2}.khs-modal{display:none;position:fixed;inset:0;background:#14233b88;z-index:999;align-items:center;justify-content:center;padding:20px}.khs-modal.show{display:flex}.khs-modal-box{background:white;border-radius:12px;padding:24px;max-width:460px;width:100%}.khs-modal-box h3{margin-top:0}.khs-modal-close{float:right;border:0;background:#edf3ff;padding:6px 10px;border-radius:5px;cursor:pointer}@media(max-width:700px){.khs-page{padding:0 14px;margin-top:24px}.khs-card-head{align-items:flex-start;flex-direction:column}.khs-heading h1{font-size:24px}}
</style>
<section class="khs-page">
    <div class="khs-heading"><h1>Kartu Hasil Studi</h1><p>Pantau KHS di setiap akhir semester. Jaga dan tingkatkan nilai untuk mengamankan target IPK impianmu.</p></div>
    <section class="khs-card">
        <div class="khs-card-head"><h2>Rekap nilai per mata kuliah</h2><span class="khs-updated">Diperbarui <?= e(date('d M Y, H.i')) ?> WIB</span></div>
        <form class="khs-tools" method="get" action="<?= e(url('mahasiswa/khs')) ?>">
            <label class="sr-only" for="semester">Semester</label>
            <select id="semester" name="semester" onchange="this.form.submit()">
                <?php for($i=1;$i<=8;$i++): ?><option value="<?= $i ?>" <?= $semesterTerpilih===$i?'selected':'' ?>>Semester <?= $i ?></option><?php endfor; ?>
            </select>
            <select aria-label="Jenis semester" disabled><option>Reguler</option></select>
            <button class="khs-btn" type="button" onclick="downloadKhsCsv()">Download</button>
        </form>
        <div class="khs-table-wrap"><table class="khs-table" id="khsTable">
            <thead><tr><th>Kode MK</th><th>Nama MK</th><th class="center">SKS</th><th class="center">Nilai</th><th class="center">Keterangan</th><th class="center">Detail nilai</th></tr></thead>
            <tbody>
            <?php foreach($dataKhs as $row): ?>
                <tr>
                    <td><?= e((string)$row['kodeMK']) ?></td>
                    <td class="khs-course"><?= e((string)$row['mataKuliah']) ?><small><?= e((string)$row['sks']) ?> SKS</small></td>
                    <td class="center"><?= e((string)$row['sks']) ?></td>
                    <td class="center khs-grade"><?= $row['nilai'] !== null && $row['nilai'] !== '' ? e((string)$row['nilai']) : '–' ?></td>
                    <td class="center"><?= e((string)$row['keterangan']) ?></td>
                    <td class="center"><?php if($row['nilai'] !== null && $row['nilai'] !== ''): ?><button class="khs-detail" type="button" onclick='showKhsDetail(<?= json_encode($row['detail'], JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT) ?>)'>Detail Nilai</button><?php else: ?><span class="khs-muted">—</span><?php endif; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table></div>
    </section>
</section>
<div class="khs-modal" id="khsModal" role="dialog" aria-modal="true" aria-labelledby="khsModalTitle"><div class="khs-modal-box"><button class="khs-modal-close" type="button" onclick="closeKhsDetail()">Tutup</button><h3 id="khsModalTitle">Detail Nilai</h3><div id="khsModalContent">Belum ada rincian.</div></div></div>
<script>
function showKhsDetail(detail){const box=document.getElementById('khsModalContent');box.innerHTML='';if(!detail||!detail.length){box.textContent='Rincian nilai belum tersedia.';}else{const ul=document.createElement('ul');detail.forEach(item=>{const li=document.createElement('li');li.textContent=(item.komponen||'Komponen')+': '+(item.nilai??'-');ul.appendChild(li)});box.appendChild(ul)}document.getElementById('khsModal').classList.add('show')}
function closeKhsDetail(){document.getElementById('khsModal').classList.remove('show')}
function downloadKhsCsv(){const rows=[...document.querySelectorAll('#khsTable tr')].map(tr=>[...tr.querySelectorAll('th,td')].slice(0,5).map(td=>'"'+td.innerText.replaceAll('"','""').replaceAll('\n',' ')+'"').join(','));const blob=new Blob(['\ufeff'+rows.join('\n')],{type:'text/csv;charset=utf-8;'});const a=document.createElement('a');a.href=URL.createObjectURL(blob);a.download='KHS-semester-<?= $semesterTerpilih ?>.csv';a.click();URL.revokeObjectURL(a.href)}
</script>
<?php include ROOT . '/resources/views/layouts/footer.php'; ?>
