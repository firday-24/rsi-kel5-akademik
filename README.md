# Portal Akademik — PHP Native MVC + IBM Db2

Aplikasi ini menggunakan **PHP Native MVC (tanpa Laravel/Blade/Composer)** dan **IBM Db2 LUW**. View menggunakan file `.php` biasa. Nama file model mempertahankan pola diagram (`presensi-m.php`, `izin-m.php`, `verifikasi_izin-m.php`); identifier class PHP memakai underscore karena tanda hubung tidak valid dalam nama class (`presensi_m`, `izin_m`, `verifikasi_izin_m`). Controller mempertahankan nama fitur dan method dari class/sequence diagram.

## Cakupan fitur

- Login satu pintu: mahasiswa, dosen, admin akademik.
- Rekap kehadiran mahasiswa per pengambilan mata kuliah.
- Pengajuan izin/sakit dengan PDF maksimal 2 MB.
- Verifikasi pengajuan hanya oleh **dosen pengampu jadwal mata kuliah terkait**.
- Dosen PA disimpan sebagai relasi bimbingan (`DOSEN_PA`), bukan role login terpisah.
- Mahasiswa dapat mengulang mata kuliah karena setiap pengambilan memiliki `ID_PENGAMBILAN` tersendiri.

## Struktur project

```text
app/
  controllers/       # login.php, mahasiswa/presensi.php, mahasiswa/izin.php,
                     # dosen/verifikasi_izin.php, dan beranda
  models/            # akun-pengguna.php, presensi-m.php, izin-m.php,
                     # verifikasi_izin-m.php, mahasiswa.php, dosen.php
  middleware/        # AuthMiddleware.php
  core/              # Helpers.php
config/              # database.php
 database/           # DDL, DML seed, query test, privilege, reset
public/              # index.php, CSS, uploads
resources/views/     # auth, mahasiswa, dosen, layouts; semua .php
```

## 1. Siapkan Db2 di VirtualBox

1. Pastikan IBM Db2 LUW sudah terpasang di VM dan instance aktif.
2. Buat database latihan (jalankan sebagai user instance Db2 di terminal VM):

   ```bash
   db2 create database PORTALDB using codeset UTF-8 territory ID
   ```

3. Pastikan TCP/IP aktif dan Db2 mendengarkan port `50000` (sesuaikan jika port instance berbeda):

   ```bash
   db2set DB2COMM=TCPIP
   db2 update dbm cfg using SVCENAME 50000
   db2stop
   db2start
   db2 get dbm cfg | grep -i SVCENAME
   ```

4. Atur jaringan VirtualBox agar komputer anggota kelompok dapat menjangkau VM. Pilihan yang umum:
   - **Bridged Adapter**: VM mendapat IP di jaringan LAN yang sama.
   - **Host-only Adapter**: host dan VM dapat saling mengakses; untuk anggota kelompok lain perlu jaringan/rute tambahan.
5. Buka port TCP Db2 (`50000`) pada firewall VM dan pastikan koneksi dari komputer host dapat mencapai IP VM. Jangan mengekspos port database ke internet publik.
6. Catat IP VM, port, nama database, dan user Db2.

> Contoh IP `192.168.56.101` pada `.env.example` hanya placeholder. Ganti dengan IP VM milikmu.

## 2. Jalankan DDL dan DML melalui DBeaver

1. Di DBeaver pilih **New Database Connection → Db2**.
2. Isi Host = IP VM, Port = `50000`, Database = `PORTALDB`, Username dan Password Db2. Unduh driver jika DBeaver meminta.
3. Klik **Test Connection**, lalu **Finish**.
4. Buka SQL Editor pada koneksi `PORTALDB`.
5. Jalankan file secara berurutan:
   - `database/01_SCHEMA_DDL.sql` — membuat schema dan tabel.
   - `database/02_SEED_DML.sql` — mengisi akun dan data dummy.
   - `database/03_QUERIES_TESTING.sql` — contoh query untuk memeriksa data.
6. File SQL adalah file teks biasa yang dapat diedit kelompokmu. Anggota yang memiliki akses Db2 dapat mengubah DDL/DML, menyimpan perubahan, lalu menjalankannya di koneksi yang sama.

**Jangan jalankan DDL berulang pada schema yang sudah dibuat**, karena nama schema/tabel sudah ada. Untuk mengulang data latihan, gunakan `database/05_RESET_DATA_DML.sql`, kemudian jalankan ulang `02_SEED_DML.sql`. Reset menghapus seluruh data latihan dalam tabel terkait.

## 3. Beri hak anggota kelompok untuk edit DDL dan DML

- Minta DBA/administrator Db2 menjalankan `database/04_TEAM_PRIVILEGES.sql`.
- Edit baris contoh `GRANT ROLE PORTAL_DEV TO USER ...` dengan authorization ID Db2 tiap anggota.
- Role `PORTAL_DEV` memberi hak membuat, mengubah, dan menghapus objek pada schema `PORTAL`, serta SELECT/INSERT/UPDATE/DELETE pada tabel yang ada.
- Untuk tabel baru yang dibuat setelah skrip privilege dijalankan, tambahkan grant DML untuk role `PORTAL_DEV` pada tabel tersebut.
- Setiap anggota perlu punya user Db2 sendiri dan koneksi DBeaver masing-masing. Agar semua mengedit database yang sama, arahkan koneksi DBeaver tiap anggota ke IP VM dan database `PORTALDB` yang sama. Simpan file SQL di folder bersama (misalnya Git) supaya perubahan DDL/DML juga tersinkron sebagai file. Hak role di database tidak otomatis membagikan perubahan file SQL lokal. Jangan berbagi akun DBA.

Akun aplikasi PHP sebaiknya berbeda dari akun developer dan diberi hak minimum. Skrip privilege juga membuat `PORTAL_APP_ROLE` dengan hak minimum yang dibutuhkan aplikasi. Setelah user Db2 `PORTAL_APP` tersedia pada sistem autentikasi Db2 (OS/LDAP sesuai konfigurasi server), DBA menjalankan `GRANT ROLE PORTAL_APP_ROLE TO USER PORTAL_APP;`.

## 4. Konfigurasi PHP

Aplikasi membutuhkan:
- PHP 8.1+.
- Ekstensi `pdo_ibm` yang cocok dengan versi PHP, arsitektur (x64/x86), dan compiler PHP yang dipakai.
- Ekstensi `fileinfo` untuk validasi MIME PDF.
- Apache `mod_rewrite` (XAMPP) atau PHP built-in server.

1. Salin `.env.example` menjadi `.env`.
2. Ubah `DB2_HOST`, `DB2_PORT`, `DB2_DATABASE`, `DB2_SCHEMA`, `DB2_USER`, dan `DB2_PASSWORD` sesuai VM Db2.
3. Pastikan `DB2_USER` sudah diberi hak SELECT/INSERT/UPDATE yang dibutuhkan pada schema `PORTAL`.
4. Letakkan folder project di `C:\xampp\htdocs\portal-mahasiswa`.
5. Aktifkan `pdo_ibm` pada `php.ini` setelah memasang IBM Data Server Driver/IBM PHP driver yang kompatibel, lalu restart Apache.
6. Buka `http://localhost/portal-mahasiswa/public/`.

Jika tidak memakai XAMPP, ubah `APP_BASE_PATH=/` pada `.env`, lalu dari folder project jalankan:

```bash
php -S 127.0.0.1:8000 -t public public/index.php
```

Lalu buka `http://127.0.0.1:8000/`. Jika aplikasi berjalan di host Windows dan Db2 berada di VM, `DB2_HOST` harus IP VM, bukan `localhost`.

## 5. Akun demo

Semua password demo: **`Demo123!`**

| Email | Pengguna | Role | Kondisi data |
|---|---|---|---|
| `ayu@student.ac.id` | Ayu Maharani | MAHASISWA | Pernah mengajukan; disetujui |
| `bima@student.ac.id` | Bima Pratama | MAHASISWA | Belum pernah mengajukan |
| `citra@student.ac.id` | Citra Lestari | MAHASISWA | Pernah mengajukan; ditolak |
| `dimas@student.ac.id` | Dimas Saputra | MAHASISWA | Pengajuan menunggu verifikasi |
| `eka@student.ac.id` | Eka Putri | MAHASISWA | Pernah mengajukan; disetujui |
| `andi@kampus.ac.id` | Andi Wijaya | DOSEN | Pengampu Administrasi Basis Data |
| `ratna@kampus.ac.id` | Ratna Puspita | DOSEN | Pengampu Analisis dan Perancangan Sistem; dosen PA |
| `fajar@kampus.ac.id` | Fajar Nugroho | DOSEN | Pengampu Pemrograman Web; dosen PA |
| `admin@kampus.ac.id` | Admin Akademik | ADMIN_AKADEMIK | Login admin demo |

Bukti PDF contoh untuk pengajuan demo disediakan di `public/uploads/demo_IZ001.pdf` sampai `demo_IZ004.pdf`.

## 6. URL aplikasi

- Login: `/`
- Mahasiswa: `/mahasiswa`
- Rekap kehadiran: `/mahasiswa/presensi`
- Riwayat izin: `/mahasiswa/izin`
- Form izin: `/mahasiswa/izin/buat`
- Dosen: `/dosen`
- Antrean verifikasi: `/dosen/izin`
- Detail: `/dosen/izin/{ID_PENGAJUAN}`

Dengan XAMPP, awali path tersebut dengan `http://localhost/portal-mahasiswa/public`.

## 7. Catatan implementasi dan keamanan

- Password disimpan menggunakan `password_hash()`; login memakai `password_verify()`.
- Role diperiksa di server melalui middleware. Mahasiswa tidak dapat membuka area dosen.
- Dosen hanya dapat melihat/memproses pengajuan pada jadwal mata kuliah yang `NIP_PENGAMPU`-nya sama dengan dosen login. Pengecekan dilakukan kembali pada aksi update.
- Persetujuan mengubah status pengajuan dan status presensi dalam satu transaksi Db2. Penolakan menyimpan alasan dan tidak mengubah status presensi.
- File upload dibatasi PDF dan 2 MB. Berkas demo di folder public hanya untuk latihan; untuk produksi sebaiknya simpan di luar document root dan sediakan controller download yang memeriksa otorisasi.
- Data IPK/SKS di dashboard masih label contoh, bukan bagian perhitungan database pada scope ini.
- Versi ini belum menyediakan pemulihan password, manajemen akun admin, notifikasi email, dan audit log.
- Ekstensi `pdo_ibm` belum tersedia pada lingkungan pembuatan ZIP ini, sehingga koneksi live ke Db2 belum dapat diuji di sini. Jalankan pengujian koneksi setelah driver PHP Db2 dipasang pada komputer/VM yang menjalankan PHP.

### Alur kerja database kelompok yang disarankan

1. Satu anggota bertugas sebagai pengelola schema awal dan menjalankan DDL pertama kali.
2. Setiap anggota memperoleh user Db2 personal, role `PORTAL_DEV`, dan membuat koneksi DBeaver ke database VM yang sama.
3. DDL/DML diubah melalui file `.sql` pada repository bersama; sebelum menjalankan perubahan struktur, koordinasikan urutan eksekusi agar tidak saling menimpa.
4. DML uji coba dapat dijalankan pada data latihan. Hindari menjalankan `05_RESET_DATA_DML.sql` pada database yang berisi data penting.
5. Simpan perubahan SQL ke Git agar semua anggota mendapat versi file yang sama. DBeaver mengelola koneksi dan eksekusi SQL, sedangkan Git/penyimpanan bersama mengelola kolaborasi file.
