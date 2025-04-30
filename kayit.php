<?php

include("baglanti.php");

$username_err="";
$password_err="";
$passwordtkr_err="";

if(isset($_POST["Kaydet"])){
    $username="";
    $password="";

    if(empty($_POST["name"])){
        $username_err="kullanıcı adı boş geçilemez!";
    }
    else if(!preg_match('/^[a-zA-ZçÇğĞıİöÖşŞüÜ\s]{5,30}$/u', $_POST["name"])){
        $username_err = "Geçersiz karakter girdiniz (En az 5, en fazla 30 karakter. Türkçe karakter ve boşluk kullanılabilir).";
    }
    
    else{
        $username=$_POST["name"];
    }

    if(empty($_POST["password"])){
        $password_err="Parola boş geçilemez";
    }
    else{
        
        $password=$_POST["password"];
    }
    if(empty($_POST["passwordtkr"])){
        $passwordtkr_err="parola tekrar kısmı boş olamaz!";
    }
    else if($_POST["password"]!=$_POST["passwordtkr"]){
        $passwordtkr_err="parolar eşleşmiyor";
    }
    else{
        $passwordtkr=$_POST["passwordtkr"];
    }


    if (empty($username_err) && empty($password_err) && empty($passwordtkr_err)){
$ekle="INSERT INTO users (name,password) VALUES ('$username','$password')";
$calistirekle=mysqli_query($baglanti,$ekle);
if($calistirekle){
    header("Location: giris.php");
    exit();
}
else{
    echo '<div class="alert alert-secondary" role="alert">
  Kayıt işlemi başarısız!
</div>';
}

mysqli_close($baglanti);
    }



}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="kayit.css">
    <title>ÜYE KAYIT İŞLEMİ </title>
  </head>
  <body>
   <div class="container p-5">
    <div class="cards p-5">

    <form action="kayit.php" method="POST">
          
    
  <div class="form-group">
        <label for="exampleInputEmail1" style="color ;red">Kullanıcı Adı</label>
        <input type="text" class="form-control 
        <?php

        if(!empty($username_err)){
            echo "is-invalid";
        }
        ?>
        " id="name" name="name" placeholder="Adınız">
        <div class="invalid-feedback">
       <?php
       echo "$username_err";
       ?>
      </div>
  </div>
  <div class="form-group">
        <label for="exampleInputPassword1">Şİfre</label>
        <input type="password" class="form-control 
        <?php
        if(!empty($password_err)){
            echo "is-invalid";
        }

        ?>
        
        " id="password" name="password" placeholder="Şifre">
        <div class="invalid-feedback">
        <?php
       echo "$passwordtkr_err";
       ?>
      </div>
  </div>
  <div class="form-group">
        <label for="exampleInputPassword1">Şİfre</label>
        <input type="password" class="form-control 
         <?php
        if(!empty($passwordtkr_err)){
            echo "is-invalid";
        }

        ?>
        " id="passwordtkr" name="passwordtkr" placeholder="Şifre">
        <div class="invalid-feedback">
        <?php
       echo "$passwordtkr_err";
       ?>
      </div>
  </div>
  <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Beni Hatırla</label>
  </div>
  <button type="submit" class="btn btn-primary" name="Kaydet">Kaydet</button>
    </form>

    </div>
   </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>