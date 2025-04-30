<?php
session_start();
include("baglanti.php");

// Oturum kontrolü
if (!isset($_SESSION["name"])) {
    echo "Bu sayfaya erişim yetkiniz yoktur!";
    exit();
}

$username = $_SESSION["name"];

// Kullanıcının ID'sini çek
$kullanici_sorgu = mysqli_query($baglanti, "SELECT user_id FROM users WHERE name='$username'");
$kullanici = mysqli_fetch_assoc($kullanici_sorgu);
$kullanici_id = $kullanici['user_id'];

// Kullanıcının notlarını çek
$notlar_sorgu = mysqli_query($baglanti, "SELECT * FROM notes WHERE user_id='$kullanici_id'");
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="profile.css">
</head>
<body>

    <div class="sidebar">
        <h4><?php echo $username; ?></h4>
        <hr>
        <p> İşlemler :</p>
        <ul>
            
                <li><a href="not_ekle.php">Yeni Not Ekle</a></li>
                <li><a href="not_guncelle.php">Not Güncelle</a></li>
                <li><a href="not_sil.php">Not Sİl</a></li>
                
           
        </ul>
        <form action="cikis.php" method="POST" class="cikis-btn">
            <button type="submit" class="btn btn-danger btn-block" >Çıkış Yap</button>
        </form>
    </div>

    <div class="content">
        <h2><?php echo $username; ?> HOŞGELDİNİZ</h2>
        
        <div class="content">

        <div class="card-container" style="display: flex; overflow-x: auto; gap: 20px; padding: 20px; margin-top: 40px;">
        <?php while ($not = mysqli_fetch_assoc($notlar_sorgu)) : ?>
            <div class="card" style="min-width: 18rem; flex: 0 0 auto;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($not['title']); ?></h5>
                    <p class="card-text">
                        <?php
                            $ozet = mb_substr($not['content'], 0, 10, 'UTF-8');
                            echo htmlspecialchars($ozet) . (mb_strlen($not['content'], 'UTF-8') > 10 ? "..." : "");
                        ?>
                    </p>
                    <a href="not_goruntule.php?id=<?php echo $not['note_id']; ?>" class="card-link">Notu Görüntüle</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    </div>
</div>


        

    </div>
    

</body>
</html>
