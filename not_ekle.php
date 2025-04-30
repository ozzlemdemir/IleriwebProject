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

// Not ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($baglanti, $_POST["title"]);
    $content = mysqli_real_escape_string($baglanti, $_POST["content"]);

    if (!empty($title) && !empty($content)) {
        $sorgu = "INSERT INTO notes (user_id, title, content) VALUES ('$kullanici_id', '$title', '$content')";
        if (mysqli_query($baglanti, $sorgu)) {
            header("Location: profile.php"); // Başarılıysa profile sayfasına yönlendir
            exit();
        } else {
            echo "Not eklenirken hata oluştu.";
        }
    } else {
        echo "Başlık ve içerik boş bırakılamaz!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Not Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="not_ekle.css">
    
</head>
<body>

<div class="sidebar">
    <h4><?php echo $username; ?></h4>
    <hr>
    <p> İşlemler :</p>
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

<div class="content">
    <h2>Yeni Not Ekle</h2>
    <form method="POST" action="not_ekle.php">
        <div class="form-group">
            <label for="title">Not Başlığı</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="content">Not İçeriği</label>
            <textarea name="content" id="content" class="form-control" rows="6" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Kaydet</button>
    </form>
</div>

</body>
</html>
