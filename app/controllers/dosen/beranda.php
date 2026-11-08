<?php
declare(strict_types=1);
class BerandaDosen { public function tampil(): void {AuthMiddleware::role('DOSEN');view('dosen/tampil_menu_utama');} }
