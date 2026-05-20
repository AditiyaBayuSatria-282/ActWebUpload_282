<?php
require_once 'config.php';

if (isset($_POST['submit'])) {
    if (!isset($_FILES['fileToUpload']) || $_FILES['fileToUpload']['error'] == UPLOAD_ERR_NO_FILE) {
        $_SESSION['msg'] = ["type" => "error", "text" => "❌ Silakan pilih file gambar terlebih dahulu!"];
    } else {
        $file = $_FILES['fileToUpload'];
        $fileName = $file['name'];
        $fileTmp = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExt, $allowed)) {
            $_SESSION['msg'] = ["type" => "error", "text" => "❌ File tidak diizinkan! Hanya format JPG, JPEG, PNG, GIF, WEBP."];
        } elseif (!in_array(mime_content_type($fileTmp), $allowedMime)) {
            $_SESSION['msg'] = ["type" => "error", "text" => "❌ Tipe file tidak valid! File tersebut bukan gambar asli."];
        } elseif ($fileSize > 2097152) {
            $_SESSION['msg'] = ["type" => "error", "text" => "❌ Ukuran file terlalu besar! Maksimal 2MB."];
        } elseif ($fileError !== 0) {
            $_SESSION['msg'] = ["type" => "error", "text" => "❌ Terjadi error saat sistem memproses upload."];
        } else {
            $newFileName = uniqid('img_', true) . '.' . $fileExt;
            if (move_uploaded_file($fileTmp, $uploadDir . $newFileName)) {
                $_SESSION['msg'] = ["type" => "success", "text" => "✅ File berhasil diupload!"];
            } else {
                $_SESSION['msg'] = ["type" => "error", "text" => "❌ Gagal menyimpan file ke folder server."];
            }
        }
    }
}

header("Location: index.php");
exit;