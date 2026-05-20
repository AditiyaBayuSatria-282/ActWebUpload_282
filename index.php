<?php 
require_once 'config.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Upload Gambar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>📁 Web Upload Gambar</h2>
    <p class="subtitle">Upload, preview, download, dan kelola foto kamu</p>

    <?php if($msg !== null): ?>
        <div class="alert alert-<?= $msg['type'] ?>">
            <?= htmlspecialchars($msg['text']) ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <form action="proses_upload.php" method="POST" enctype="multipart/form-data">
            <div class="upload-area" onclick="document.getElementById('fileInput').click()">
                <div class="upload-icon" id="boxIcon">🖼️</div>
                
                <div class="preview-container" id="previewBox">
                    <img id="imgPreview" src="#" alt="Preview Foto">
                </div>

                <span><span class="highlight">Klik untuk memilih foto</span></span>
                <span>JPG, JPEG, PNG, GIF, WEBP • Maks 2MB</span>
                
                <input type="file" id="fileInput" name="fileToUpload" accept="image/*" onchange="previewImage(this)">
                
                <div class="file-name" id="fileName">Belum ada file dipilih</div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">⬆️ Upload Foto</button>
        </form>
    </div>

    <div class="card file-list">
        <h3>📂 File Terupload (<?= count($files) ?>)</h3>
        <?php if(empty($files)): ?>
            <p class="empty">Belum ada foto yang diupload.</p>
        <?php else: ?>
            <?php foreach($files as $file): ?>
                <div class="file-item">
                    <div class="file-info">
                        <img src="uploads/<?= htmlspecialchars($file) ?>" alt="Uploaded image">
                        <span><?= htmlspecialchars($file) ?></span>
                    </div>
                    <div class="file-actions">
                        <a href="proses_download.php?download=<?= urlencode($file) ?>" class="btn btn-download">⬇️ Unduh</a>
                        <a href="proses_delete.php?delete=<?= urlencode($file) ?>" class="btn btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus file ini?')">🗑️ Hapus</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    function previewImage(input) {
        const fileName = document.getElementById('fileName');
        const previewBox = document.getElementById('previewBox');
        const imgPreview = document.getElementById('imgPreview');
        const boxIcon = document.getElementById('boxIcon');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            fileName.textContent = file.name;

            const reader = new FileReader();
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                previewBox.style.display = 'block';
                boxIcon.style.display = 'none'; 
            }
            reader.readAsDataURL(file);
        } else {
            fileName.textContent = 'Belum ada file dipilih';
            previewBox.style.display = 'none';
            boxIcon.style.display = 'block';
        }
    }
</script>
</body>
</html>