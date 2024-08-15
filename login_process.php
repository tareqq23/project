<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == 'adminsuper' && $password == 'superadmin') {
        $_SESSION['user_id'] = 'superadmin';
        $_SESSION['username'] = 'adminsuper';
        $_SESSION['role'] = 'superadmin';
        header("Location: super_admin.php");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Tidak memeriksa is_confirmed jika pengguna adalah admin
                if ($user['role'] != 'admin' && $user['is_confirmed'] == 0) {
                    echo "<script>alert('Email Anda belum dikonfirmasi. Silakan periksa email Anda untuk mengonfirmasi akun.');window.location='login.php';</script>";
                } else {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    if ($user['role'] == 'admin') {
                        header("Location: dashboard.php");
                    } else if ($user['role'] == 'responden') {
                        header("Location: d_responden.php");
                    }
                    exit();
                }
            } else {
                echo "<script>alert('Password salah.');window.location='login.php';</script>";
            }
        } else {
            echo "<script>alert('Pengguna tidak ditemukan.');window.location='login.php';</script>";
        }
        $stmt->close();
    }
}
$koneksi->close();
?>
