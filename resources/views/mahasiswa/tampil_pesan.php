<?php
$title = 'KHS'; $breadcrumb = 'KHS';
include ROOT . '/resources/views/layouts/header.php';
?>
<section style="max-width:1168px;margin:38px auto 80px;padding:0 24px;color:#1c2b45">
 <h1 style="font-size:28px;margin:0 0 8px">Kartu Hasil Studi</h1>
 <p style="color:#7788a5;margin:0 0 24px">Pantau KHS di setiap akhir semester.</p>
 <section style="background:#fff;border:1px solid #dfe7f2;border-radius:14px;padding:56px 24px;text-align:center">
  <div style="font-size:42px;color:#9bb8f5;margin-bottom:12px">▤</div>
  <h2 style="font-size:19px;margin:0 0 8px">Belum ada data KHS</h2>
  <p style="color:#7788a5;font-size:14px;margin:0 0 22px">Belum terdapat mata kuliah yang diambil pada semester <?= e((string)$semesterTerpilih) ?>.</p>
  <a href="<?= e(url('mahasiswa')) ?>" style="display:inline-block;background:#285bd8;color:white;text-decoration:none;border-radius:6px;padding:9px 16px;font-size:13px">Kembali ke Beranda</a>
 </section>
</section>
<?php include ROOT . '/resources/views/layouts/footer.php'; ?>
