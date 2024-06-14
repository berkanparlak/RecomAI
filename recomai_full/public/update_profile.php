<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

$user_id = $_SESSION['user_id'];

$ad_soyad = $_POST['fullname'];
$email = $_POST['email'];
$tel_no = !empty($_POST['telno']) ? $_POST['telno'] : null;
$kullanici_adi = $_POST['username'];
$sifre = password_hash($_POST['password'], PASSWORD_DEFAULT);

$current_profile_picture = $_POST['profile_image'];

// Profil resmi yükleme işlemi
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
    log("basarili");
    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    $file_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);

    if (in_array(strtolower($file_extension), $allowed_extensions)) {
        $profile_picture = 'images/users' . $user_id . '.' . $file_extension;
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $profile_image);
    } else {
        // Geçersiz dosya uzantısı durumunda hata ver
        die("Invalid file type. Only JPG and PNG are allowed.");
    }
} else {
    $profile_picture = $current_profile_picture;
}

$query = "UPDATE users SET fullname = ?, email = ?, telno = ?, username = ?, password = ?, profile_image = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssssi", $ad_soyad, $email, $tel_no, $kullanici_adi, $sifre, $profile_picture, $user_id);
$stmt->execute();

header("Location: profile.php");
?>