<?php
session_start();
include("baglanti.php");

// Oturum kontrolü
if (!isset($_SESSION["name"])) {
    echo "Bu sayfaya erişim yetkiniz yoktur!";
    exit();
}

$username = $_SESSION["name"];

// Kullanıcının ID'sini al
$kullanici_sorgu = mysqli_query($baglanti, "SELECT user_id FROM users WHERE name='$username'");
$kullanici = mysqli_fetch_assoc($kullanici_sorgu);
$kullanici_id = $kullanici['user_id'];

// Silme işlemi
if (isset($_GET['sil']) && is_numeric($_GET['sil'])) {
    $note_id = intval($_GET['sil']);

    // Silme işlemi sadece kendi notuysa yapılmalı
    $sil_sorgu = mysqli_query($baglanti, "DELETE FROM notes WHERE note_id='$note_id' AND user_id='$kullanici_id'");

    if ($sil_sorgu) {
        header("Location: not_sil.php?silindi=1");
        exit();
    } else {
        echo "Silme işlemi başarısız.";
    }
}

// Notları çek
$notlar = mysqli_query($baglanti, "SELECT * FROM notes WHERE user_id='$kullanici_id'");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Not Sil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="not_sil.css">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            height: 100vh;
            padding: 20px;
            border-right: 1px solid #ddd;
        }
        .sidebar h4 {
            font-weight: bold;
        }
        .sidebar ul {
            list-style: none;
            padding-left: 0;
        }
        .sidebar ul li {
            padding: 8px 0;
        }
        .content {
            padding: 40px;
            width: 100%;
        }
    </style>
    <script>
        function onayla(id) {
            if (confirm("Bu notu silmek istediğinizden emin misiniz?")) {
                window.location.href = "not_sil.php?sil=" + id;
            }
        }
    </script>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4><?php echo $username; ?></h4>
    <hr>
    <p>İşlemler :</p>
    <ul>
        <li><a href="not_ekle.php">Yeni Not Ekle</a></li>
        <li><a href="not_guncelle.php">Not Güncelle</a></li>
        <li><a href="not_sil.php">Not Sil</a></li>
        <li><a href="profile.php">Not Görüntüle</a></li>
    </ul>
    <form action="cikis.php" method="POST" class="cikis-btn">
        <button type="submit" class="btn btn-danger btn-block">Çıkış Yap</button>
    </form>
</div>

<!-- İçerik -->
<div class="content">
    <h3>Silinebilir Notlar</h3>

    <?php if (isset($_GET['silindi'])): ?>
        <div class="alert alert-success">Not başarıyla silindi.</div>
    <?php endif; ?>

    <?php if (mysqli_num_rows($notlar) > 0): ?>
        <div class="list-group">
            <?php while ($not = mysqli_fetch_assoc($notlar)) : ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?php echo htmlspecialchars($not['title']); ?></strong><br>
                        <small><?php echo mb_substr(htmlspecialchars($not['content']), 0, 50, 'UTF-8'); ?>...</small>
                    </div>
                    <button onclick="onayla(<?php echo $not['note_id']; ?>)" class="btn btn-danger btn-sm">Sil</button>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>Silinecek not bulunamadı.</p>
    <?php endif; ?>
</div>

</body>
</html>
