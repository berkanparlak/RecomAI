<?php
session_start();

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
    // Giriş formu gönderildi
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Giriş başarılı
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username;
            $_SESSION['profile_image'] = $row['profile_image'];
            header("Location: index.php");
            exit;
        } else {
            $error_message = "Yanlış şifre!";
        }
    } else {
        $error_message = "Kullanıcı bulunamadı!";
    }
}

// Veritabanı bağlantısını kapat
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>YazilimProje</title>
    <link rel="stylesheet" href="reg_log.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="div_baslik2">
        <h1>Hoşgeldiniz</h1>
    </div>
    <div>
        <form method="POST" action="">
            <ul class="kayit_ul">
                <li class="kayit_li">
                    <input type="text" name="username" placeholder="Kullanıcı Adı" required>
                </li>
                <li class="kayit_li">
                    <input type="password" name="password" placeholder="Şifre" required><br>
                </li>
                <li>
                    <button class="button_li" type="submit" name="login">Giriş Yap</button>
                </li>
            </ul>
            <?php if (!empty($error_message)) { ?>
                <div class="error_message"><?php echo $error_message; ?></div>
            <?php } ?>
        </form>
    </div>
    <div>
        <h4>Hesabınız yok mu? <a href="register.php">Kaydolun.</a></h4>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>
