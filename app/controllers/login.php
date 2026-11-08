<?php
declare(strict_types=1);
class Login {
    public function Tampilkan(): void { if(current_user()) redirect(current_user()['role']==='DOSEN'?'dosen':(current_user()['role']==='MAHASISWA'?'mahasiswa':'admin')); view('auth/tampil_login',['error'=>flash('error')]); }
    public function ProsesLogin(): void { require_post_csrf();$email=trim((string)($_POST['email']??''));$password=(string)($_POST['kata_sandi']??'');$user=(new AkunPengguna())->ValidasiKredensial($email,$password);if(!$user){$this->TampilkanEmailSalahAtauSandiSalah();}session_regenerate_id(true);$_SESSION['user']=$user;redirect(match($user['role']){'MAHASISWA'=>'mahasiswa','DOSEN'=>'dosen',default=>'admin'}); }
    public function TampilkanEmailSalahAtauSandiSalah(): void { flash('error','Email atau kata sandi salah, atau akun tidak aktif.'); redirect(''); }
    public function Logout(): void { require_post_csrf();$_SESSION=[];session_regenerate_id(true);$_SESSION['_csrf']=bin2hex(random_bytes(32));redirect(''); }
}
