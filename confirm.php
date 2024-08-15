<?php
include 'koneksi.php';
$message = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Cari pengguna dengan token ini
    $sql = "SELECT * FROM users WHERE token = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update status konfirmasi
        $sql = "UPDATE users SET is_confirmed = 1, token = NULL WHERE token = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();

        $message = "Email confirmed successfully!";
    } else {
        $message = "Invalid token or email already confirmed.";
    }
} else {
    $message = "No token provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            background-image: url('background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }
        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .container p {
            font-size: 16px;
            color: #333;
        }
        .container a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        .container a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Email Confirmation</h1>
        <p><?php echo $message; ?></p>
        <a href="login.php">Go to Login</a>
    </div>
</body>
</html>
