<?php
// Memulai session untuk berkirim pesan alert antar halaman
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$uploadDir = "uploads/";

// Buat folder uploads otomatis jika belum ada
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$allowedMime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

// Ambil pesan dari session jika ada
$msg = isset($_SESSION['msg']) ? $_SESSION['msg'] : null;
unset($_SESSION['msg']); // Hapus langsung agar tidak muncul terus-menerus saat di-refresh

// Ambil daftar file terupdate untuk ditampilkan di upload.php
$files = [];
if (is_dir($uploadDir)) {
    $scan = scandir($uploadDir);
    if ($scan !== false) {
        $files = array_filter($scan, function($f) use ($allowed) {
            return in_array(strtolower(pathinfo($f, PATHINFO_EXTENSION)), $allowed);
        });
    }
}