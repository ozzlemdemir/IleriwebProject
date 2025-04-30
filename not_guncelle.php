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

// Not güncelleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["note_id"])) {
    $note_id = intval($_POST["note_id"]);
    $new_title = mysqli_real_escape_string($baglanti, $_POST["title"]);
    $new_content = mysqli_real_escape_string($baglanti, $_POST["content"]);

    $guncelle = mysqli_query($baglanti, "UPDATE notes SET title='$new_title', content='$new_content' WHERE note_id='$note_id' AND user_id='$kullanici_id'");

    if ($guncelle) {
        header("Location: not_guncelle.php?basarili=1");
        exit();
    } else {
        echo "Güncelleme sırasında hata oluştu.";
    }
}

// Not seçilmişse güncelleme formunu göstermek için veri çek
$guncellenecek_not = null;
if (isset($_GET["id"])) {
    $note_id = intval($_GET["id"]);
    $sorgu = mysqli_query($baglanti, "SELECT * FROM notes WHERE note_id='$note_id' AND user_id='$kullanici_id'");
    $guncellenecek_not = mysqli_fetch_assoc($sorgu);
}

// Tüm notları getir (liste için)
$notlar = mysqli_query($baglanti, "SELECT * FROM notes WHERE user_id='$kullanici_id'");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Not Güncelle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="not_guncelle.css">
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
    <h2>Not Güncelle</h2>

    <?php if ($guncellenecek_not): ?>
        <form method="POST" action="not_guncelle.php">
            <input type="hidden" name="note_id" value="<?php echo $guncellenecek_not['note_id']; ?>">
            <div class="form-group">
                <label for="title">Başlık</label>
                <input type="text" name="title" id="title" class="form-control" value="<?php echo htmlspecialchars($guncellenecek_not['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="content">İçerik</label>
                <textarea name="content" id="content" class="form-control" rows="6" required><?php echo htmlspecialchars($guncellenecek_not['content']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Güncelle</button>
            <a href="not_guncelle.php" class="btn btn-secondary">İptal</a>
        </form>
        <hr>
    <?php endif; ?>

    <h4>Notlarınız:</h4>
    <ul class="list-group">
        <?php while ($not = mysqli_fetch_assoc($notlar)) : ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php echo htmlspecialchars($not['title']); ?>
                <a href="not_guncelle.php?id=<?php echo $not['note_id']; ?>" class="btn btn-sm btn-warning">Güncelle</a>
            </li>
        <?php endwhile; ?>
    </ul>
</div>

</body>
</html>
