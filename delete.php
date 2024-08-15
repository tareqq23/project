<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'superadmin') {
    echo "<script>alert('Anda tidak memiliki akses ke halaman ini.');window.location='login.php';</script>";
    exit();
}

if (isset($_GET['type']) && isset($_GET['id'])) {
    $type = $_GET['type'];
    $id = $_GET['id'];

    switch ($type) {
        case 'user':
            $sql = "DELETE FROM users WHERE id = ?";
            break;
        case 'category':
            $sql = "DELETE FROM categories WHERE id = ?";
            break;
        case 'question':
            $sql = "DELETE FROM questions WHERE id = ?";
            break;
        default:
            echo "<script>alert('Invalid type.');window.location='super_admin.php';</script>";
            exit();
    }

    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Item berhasil dihapus.');window.location='super_admin.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menghapus item.');window.location='super_admin.php';</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Invalid request.');window.location='super_admin.php';</script>";
}

$koneksi->close();
?>
