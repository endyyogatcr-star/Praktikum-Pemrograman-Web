<?php
/**
 * Praktikum 4: Implementasi Aplikasi Web Dinamis Menggunakan PHP
 * File: proses_hapus.php
 * Skrip pemroses penghapusan data mahasiswa berdasarkan npm.
 */

require_once __DIR__ . '/includes/functions.php';

// Ambil parameter npm dari URL
$npm = $_GET['npm'] ?? '';

if (!empty($npm)) {
    $hasil = hapus_mahasiswa($npm);
    if ($hasil['status']) {
        set_flash_message('success', $hasil['message']);
    } else {
        set_flash_message('danger', $hasil['message']);
    }
} else {
    set_flash_message('danger', 'npm mahasiswa yang akan dihapus tidak ditentukan!');
}

// Redirect kembali ke halaman utama
header('Location: index.php#daftar-mahasiswa');
exit;

