<?php
session_start();

// Veritabanı bağlantısı (bu örnekte $conn değişkeninin zaten tanımlı olduğunu varsayıyoruz)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_db";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kullanıcı ID'sini oturumdan alın
$user_id = $_SESSION['user_id'] ?? null;

if ($user_id) {
    // Veritabanından kullanıcı bilgilerini alın
    $sql = "SELECT username, profile_image FROM users WHERE id = '$user_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $username = $user['username'];
        $profile_image = $user['profile_image'] ?: 'profile.jpeg';
    } else {
        // Kullanıcı bulunamazsa varsayılan değerleri kullan
        $username = 'Kullanıcı';
        $profile_image = 'profile.jpeg';
    }
} else {
    // Oturum açılmamışsa varsayılan değerleri kullan
    $username = 'Kullanıcı';
    $profile_image = 'profile.jpeg';
}

// Profil resmi yolunu belirleyin
$profile_image_path = "images/$profile_image";
?>

<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="navbar.css">
    </head>

    <body>
        <nav class="navbar_private">
            <ul>
                <li class="logo-container"><a href="index.php"><img src="images/logo.png" class="navImg" alt="Logo"></a></li>
                <li><a href="index.php" class="navButton">Ana Sayfa</a></li>
                <li><a href="movie_ai.php" class="navButton">Filmler</a></li>
                <li><a href="music_ai.php" class="navButton">Müzikler</a></li>
                <li><a href="register.php" id="signUp" class="navButton2">Kayıt Ol</a></li>
                <li><a href="login.php" id="login" class="navButton2">Giriş Yap</a></li>
                <li id="userProfile" class="navProfile" style="display: none;">
                    <img src="<?php echo $profile_image_path; ?>" class="profileImg" alt="Profil Fotoğrafı">
                    <a id="username"><?php echo $username; ?></a>
                    <a href="logout.php" onclick="logoutUser()" class="logoutButton">Çıkış Yap</a>
                </li>
            </ul>
        </nav>
    </body>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var isLoggedIn = <?php echo $user_id ? 'true' : 'false'; ?>;
            var username = <?php echo json_encode($username); ?>;
            
            if (isLoggedIn) {
                document.getElementById('signUp').style.display = 'none';
                document.getElementById('login').style.display = 'none';
                document.getElementById('userProfile').style.display = 'flex';
                document.getElementById('username').textContent = username;
            }
            
            document.getElementById('userProfile').addEventListener('click', function() {
                window.location.href = 'profile.php';
            });
        });

        function logoutUser() {
            localStorage.removeItem('isLoggedIn');
            localStorage.removeItem('username');
            console.log('Logout successful');         
            window.location.href = 'logout.php';
        }
    </script>

</html>




