<?php
include 'navbar.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Düzenle - RecomAI</title>
    <link rel="stylesheet" href="profil_duzenle.css">
</head>
<body>
    <div class="container">
        <div class="profile-picture-section">
            <img src="images/<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profil Fotoğrafı" class="profile-picture" id="profile-img" name="profile_img">
            <input type="file" name="profile_image" id="file-input" style="display: none;" accept="image/*">
            <button type="button" class="change-picture-button">Profil Fotoğrafını Değiştir</button>
        </div>
        <div class="profile-info-section">
            <h2>Bilgiler</h2>
            <form action="update_profile.php" method="post" enctype="multipart/form-data">
                <input type="text" class="input-text" name="fullname" placeholder="İsim Soyisim" value="<?php echo htmlspecialchars($user['fullname']); ?>">
                <input type="email" class="input-text" name="email" placeholder="Email" value="<?php echo htmlspecialchars($user['email']); ?>">
                <input type="text" class="input-text" name="telno" placeholder="Tel No" value="<?php echo htmlspecialchars($user['telno']); ?>">
                <input type="text" class="input-text" name="username" placeholder="Kullanıcı Adı" value="<?php echo htmlspecialchars($user['username']); ?>">
                <input type="password" class="input-text" name="password" placeholder="Şifre">
                <div class="button-group">
                    <button type="submit" class="input-submit">Bilgileri Düzenle</button>
                    <button type="button" class="delete-account" onclick="confirmDeletion()">Hesabı Sil</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        document.querySelector('.change-picture-button').addEventListener('click', function() {
        document.getElementById('file-input').click();
    });

    document.getElementById('file-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        
        const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-img').src = e.target.result;
            };
            reader.readAsDataURL(file);
    });


        function confirmDeletion() {
            if (confirm('Hesabınızı silmek istediğinize emin misiniz?')) {
                window.location.href = 'delete_account.php';
            }
        }
    </script>
</body>
</html>
