<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "<script>alert('Password tidak cocok.');window.location='reset_password.php?token={$token}';</script>";
    } else {
        $password_hashed = password_hash($password, PASSWORD_BCRYPT);

        $sql = "UPDATE users SET password = ?, token = NULL WHERE token = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("ss", $password_hashed, $token);
        if ($stmt->execute()) {
            echo "<script>alert('Password berhasil diubah.');window.location='login.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan. Silakan coba lagi.');window.location='reset_password.php?token={$token}';</script>";
        }
        $stmt->close();
    }
}
$koneksi->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
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
        form input[type="password"] {
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
    </style>
</head>
<body>
    <form method="post" action="">
        <h2>Reset Password</h2>
        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
        <label for="password">Password Baru:</label>
        <input type="password" name="password" id="password" required>
        <label for="confirm_password">Konfirmasi Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
