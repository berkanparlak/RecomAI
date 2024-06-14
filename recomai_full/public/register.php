<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_db";

// Veritabanı bağlantısını oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kullanıcı girişi ve kaydı işlemlerini burada yapacağız
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Kayıt formu gönderildi
        $username = $conn->real_escape_string($_POST['username']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = password_hash($conn->real_escape_string($_POST['password']), PASSWORD_BCRYPT);
        $profile_image = 'profile.jpeg';

        $sql = "INSERT INTO users (username, email, password, profile_image) VALUES ('$username', '$email', '$password', '$profile_image')";

        if ($conn->query($sql) === TRUE) {
            // Kayıt başarılı, kullanıcı ID'sini oturuma kaydet
            session_start();
            $_SESSION['user_id'] = $conn->insert_id;
            // Ana sayfaya yönlendir
            header("Location: index.php");
            exit();
        } else {
            echo "Hata: " . $sql . "<br>" . $conn->error;
        }
}

// Veritabanı bağlantısını kapat
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="reg_log.css">
    <head>
        <meta charset="UTF-8">
        <title>YazilimProje</title>
    </head>

    <body>
    <!-- Navbar Başlangıç-->
    <?php include 'navbar.php' ?>
    <!-- Navbar Bitiş-->

        <div class="div_baslik2">
            <h1>Hoşgeldiniz</h1>
        </div>
        <div>
            <form action="register.php" method="post">
                <ul class="kayit_ul">
                    <li class="kayit_li">
                        <input type="email" name="email" placeholder="E-mail" required>
                    </li>
                    <li class="kayit_li">
                        <input type="text" name="username" placeholder="Kullanıcı Adı" required>
                    </li>
                    <li class="kayit_li">
                        <input type="password" name="password" placeholder="Şifre" required><br>
                    </li>
                    <li>
                        <button class="button_li" type="submit" name="register">Kayıt Ol</button>
                    </li>
                </ul>
            </form>
        </div>
        <div>
            <h4>Hesabınız varsa giriş yapın. <a href="login.php">Giriş Yap.</a></h4>
        </div>

        <!-- Footer -->
        <?php include 'footer.php' ?>
      
    </body>
</html>
