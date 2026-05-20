<?php
require_once 'config.php';

if (isset($_GET['delete'])) {
    $deleteFile = basename($_GET['delete']);
    $deletePath = $uploadDir . $deleteFile;
    $ext = strtolower(pathinfo($deleteFile, PATHINFO_EXTENSION));
    
    if (in_array($ext, $allowed) && file_exists($deletePath)) {
        unlink($deletePath);
        $_SESSION['msg'] = ["type" => "success", "text" => "✅ File berhasil dihapus!"];
    } else {
        $_SESSION['msg'] = ["type" => "error", "text" => "❌ File tidak ditemukan atau tidak diizinkan."];
    }
}

header("Location: index.php");
exit;