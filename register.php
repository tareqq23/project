<?php
include 'koneksi.php';
require 'vendor/autoload.php';  

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $name = $first_name . ' ' . $last_name;
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validasi username
    if (strlen($username) < 5) {
        $errors['username'] = 'Username must be at least 5 characters long.';
    }

    // Validasi password
    if (!preg_match('/[A-Z]/', $password) || !preg_match('/\d/', $password) || strlen($password) < 5) {
        $errors['password'] = 'Password must be at least 5 characters long, contain at least one number, and one uppercase letter.';
    }

    // Validasi email dan username
    $sql = "SELECT * FROM users WHERE email = ? OR username = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['email'] == $email) {
                $errors['email'] = 'Email is already registered.';
            }
            if ($row['username'] == $username) {
                $errors['username'] = 'Username is already taken.';
            }
        }
    }

    // Jika tidak ada kesalahan, masukkan data ke database
    if (empty($errors)) {
        $password_hashed = password_hash($password, PASSWORD_BCRYPT);
        $token = bin2hex(random_bytes(50)); // Token untuk konfirmasi email

        $sql = "INSERT INTO users (first_name, last_name, email, username, password, role, is_confirmed, token) VALUES (?, ?, ?, ?, ?, ?, 0, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("sssssss", $first_name, $last_name, $email, $username, $password_hashed, $role, $token);

        if ($stmt->execute()) {
            // Kirim email konfirmasi dengan PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->SMTPDebug = SMTP::DEBUG_OFF;  
                $mail->isSMTP();  
                $mail->Host = 'smtp.gmail.com';  
                $mail->SMTPAuth = true; 
                $mail->Username = 'mohamadhaidar0604@gmail.com'; // SMTP username
                $mail->Password = 'qahh twwk euaa yuwb'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  
                $mail->Port = 465;  

                // Recipients
                $mail->setFrom('greeninsight@gmail.com', 'Green Insight');
                $mail->addAddress($email, $name); 

                // Content
                $mail->isHTML(true);  
                $mail->Subject = 'Verifikasi';
                $mail->Body = 'Hi! ' . $name . ', terima kasih telah mendaftar di website Green Insight. <br>Mohon verifikasi akun kamu! <br><a href="http://localhost/esurvey/confirm.php?token=' . $token . '">Verifikasi</a>';
                $mail->AltBody = 'Tolong Lakukan Verifikasi';

                if ($mail->send()) {
                    echo "<script>alert('Registrasi berhasil. Silakan cek email Anda untuk konfirmasi akun.'); window.location='login.php';</script>";
                } else {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $errors['general'] = "Error: " . $stmt->error;
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
            filter: blur();
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
        .input-group {
            display: flex;
            justify-content: space-between;
        }
        .input-group input {
            width: 48%;
        }
        form input[type="text"],
        form input[type="password"],
        form input[type="email"] {
            width: 90%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #cccccc;
            border-radius: 4px;
        }
        .error {
            color: red;
            font-size: 12px;
            text-align: left;
            margin-bottom: 10px;
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
        form a {
            color: #4CAF50;
            text-decoration: none;
        }
        form a:hover {
            text-decoration: underline;
        }
        .logo {
            background-color: gray;
            border-radius: 4px;
            height: 50px;
        }
        .position {
            text-align: left;
        }
    </style>
</head>
<body>
    <form method="post" action="">
        <div class="logo">  
            <img src="logos.png" alt="Logo" style="height: 50px;">
        </div><br>

        <div class="input-group">
            <div style="padding-right: 20px;">
                <label class="position">First Name:</label>
                <input type="text" name="first_name" required>
                <?php if (!empty($errors['first_name'])): ?>
                    <div class="error"><?php echo $errors['first_name']; ?></div>
                <?php endif; ?>
            </div>
            <div>
                <label class="position">Last Name:</label>
                <input type="text" name="last_name" required>
                <?php if (!empty($errors['last_name'])): ?>
                    <div class="error"><?php echo $errors['last_name']; ?></div>
                <?php endif; ?>
            </div>
        </div>
        <br>
        <label class="position">Email:</label>
        <input type="email" name="email" required>
        <?php if (!empty($errors['email'])): ?>
            <div class="error"><?php echo $errors['email']; ?></div>
        <?php endif; ?><br>

        <label class="position">Username:</label>
        <input type="text" name="username" required>
        <?php if (!empty($errors['username'])): ?>
            <div class="error"><?php echo $errors['username']; ?></div>
        <?php endif; ?><br>

        <label class="position">Password:</label>
        <input type="password" name="password" required>
        <?php if (!empty($errors['password'])): ?>
            <div class="error"><?php echo $errors['password']; ?></div>
        <?php endif; ?><br>

        <label>Role:</label>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="responden">Responden</option>
        </select><br><br>
        
        <button type="submit">Register</button>
        
        <?php if (!empty($errors['general'])): ?>
            <div class="error"><?php echo $errors['general']; ?></div>
        <?php endif; ?><br><br>

        Already have an account? <a href="login.php" class="button">Login</a>
    </form>
</body>
</html>
