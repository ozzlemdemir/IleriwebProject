<?php
session_start();
include("baglanti.php");


if (!isset($_SESSION["name"])) {
    echo "Bu sayfaya erişim yetkiniz yoktur!";
    exit();
}


if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Geçersiz istek.";
    exit();
}

$note_id = intval($_GET['id']);
$username = $_SESSION["name"];


$kullanici_sorgu = mysqli_query($baglanti, "SELECT user_id FROM users WHERE name='$username'");
$kullanici = mysqli_fetch_assoc($kullanici_sorgu);
$kullanici_id = $kullanici['user_id'];


$not_sorgu = mysqli_query($baglanti, "SELECT * FROM notes WHERE note_id='$note_id' AND user_id='$kullanici_id'");
$not = mysqli_fetch_assoc($not_sorgu);

if (!$not) {
    echo "Bu nota erişim izniniz yok.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Not Görüntüle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="not_goruntule.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4><?php echo htmlspecialchars($not['title']); ?></h4>
            </div>
            <div class="card-body">
                <p><?php echo nl2br(htmlspecialchars($not['content'])); ?></p>
            </div>
            <div class="card-footer text-right">
                <a href="profile.php" class="btn btn-secondary">Geri Dön</a>
            </div>
        </div>
    </div>
</body>
</html>
