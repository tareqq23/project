<?php
include 'koneksi.php';
require 'vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emailOrUsername = $_POST['email'];

    $sql = "SELECT * FROM users WHERE email = ? OR username = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("ss", $emailOrUsername, $emailOrUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(50));

        $sql = "UPDATE users SET token = ? WHERE email = ? OR username = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("sss", $token, $emailOrUsername, $emailOrUsername);
        // Proses Pengiriman email
        if ($stmt->execute()) {
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = SMTP::DEBUG_OFF;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'mohamadhaidar0604@gmail.com';
                $mail->Password = 'qahh twwk euaa yuwb';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                $mail->setFrom('greeninsight@gmail.com', 'Green Insight');
                $mail->addAddress($user['email']); 

                $mail->isHTML(true);
                $mail->Subject = 'Reset Password';
                $mail->Body = 'Klik tautan berikut untuk mengatur ulang kata sandi Anda: <a href="http://localhost/esurvey/reset_password.php?token=' . $token . '">Reset Password</a>';
                $mail->AltBody = 'Klik tautan berikut untuk mengatur ulang kata sandi Anda: http://localhost/esurvey/reset_password.php?token=' . $token;

                $mail->send();
                echo "<script>alert('Silakan periksa email Anda untuk tautan reset kata sandi.');window.location='login.php';</script>";
            } catch (Exception $e) {
                echo "<script>alert('Gagal mengirim email. Kesalahan: {$mail->ErrorInfo}');window.location='forgot_password.php';</script>";
            }
        } else {
            echo "<script>alert('Terjadi kesalahan. Silakan coba lagi.');window.location='forgot_password.php';</script>";
        }
    } else {
        echo "<script>alert('Email atau username tidak ditemukan.');window.location='forgot_password.php';</script>";
    }
    $stmt->close();
}
$koneksi->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            background-image: url('background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        form input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #cccccc;
            border-radius: 4px;
        }
        form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        form button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-size: 12px;
        }
        p{
            text-align: left;
        }
    </style>
</head>
<body>
    <form method="post" action="">
        <h2>Mencari Akun Anda</h2>
        <p>Masukkan email atau username Anda untuk mencari akun Anda.</p>
        <input type="text" style="width: 95%;" name="email" id="email" placeholder="Email or Username" required>
        <?php if (!empty($errors['email'])): ?>
            <div class="error"><?php echo $errors['email']; ?></div>
        <?php endif; ?>
        <button type="submit">Kirim</button>
    </form>
</body>
</html>
