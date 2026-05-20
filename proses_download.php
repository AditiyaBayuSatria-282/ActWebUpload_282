<?php
require_once 'config.php';

if (isset($_GET['download'])) {
    $downloadFile = basename($_GET['download']);
    $downloadPath = $uploadDir . $downloadFile;
    $ext = strtolower(pathinfo($downloadFile, PATHINFO_EXTENSION));
    
    if (in_array($ext, $allowed) && file_exists($downloadPath)) {
        ob_clean();
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $downloadFile . '"');
        header('Content-Length: ' . filesize($downloadPath));
        readfile($downloadPath);
        exit;
    }
}

$_SESSION['msg'] = ["type" => "error", "text" => "❌ Gagal mengunduh file."];
header("Location: index.php");
exit;