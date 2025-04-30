<?php

include("baglanti.php");
mysqli_set_charset($baglanti, "utf8mb4");


if(isset($_POST["giris"])){
    $username="";
    $Password="";

    if(empty($_POST["name"])){
        $username_err="kullanıcı adı boş geçilemez!";
    }
    
    else{
        $username=$_POST["name"];
    }

    if(empty($_POST["password"])){
        $password_err="Parola boş geçilemez";
    }
    else{
        $Password=$_POST["password"];
    }

    if (empty($username_err) && empty($password_err) ){
         $secim= "SELECT * FROM users WHERE name='$username'";
         $calistir=mysqli_query($baglanti,$secim);
         $kayitsayisi=mysqli_num_rows($calistir);
         if($kayitsayisi>0){
            $ilgilikayit=mysqli_fetch_assoc($calistir);
            $hashlisifre=$ilgilikayit["password"];
            
            
         }

            if(($Password==$hashlisifre)){
                session_start();
                $_SESSION["name"]=$ilgilikayit["name"];
                $_SESSION["Password"]=$ilgilikayit["password"];
                header("Location: profile.php");
                exit();
                //echo "şifre doğru";
                

            }
            else{
               /* echo '<div class="alert alert-danger" role="alert">
                Şifre Yanlış!!<br>
               
            </div>';*/
                
            }

         }
         else{
           /* echo '<div class="alert alert-danger" role="alert">
                    Kullanıcı adı yanlış!
                  </div>';*/
         }
         
        
mysqli_close($baglanti);
    
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
    <link rel="stylesheet" href="giris.css">
    <title>ÜYE GiRİŞ İŞLEMİ </title>
  </head>
  <body>
   <div class="container p-5">
    <div class="cards p-5">

    <form action="giris.php" method="POST">
          
    
  <div class="form-group">
        <label for="exampleInputEmail1">Kullanıcı Adı</label>
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
       echo "$password_err";
       ?>
      </div>
  </div>
 
  <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
  </div>
  <button type="submit" class="btn btn-primary" name="giris">Giriş Yap</button>
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