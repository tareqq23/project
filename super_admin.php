<?php
session_start();
include 'koneksi.php';

// Periksa apakah pengguna sudah login dan merupakan super admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'superadmin') {
    echo "<script>alert('Anda tidak memiliki akses ke halaman ini.');window.location='login.php';</script>";
    exit();
}

$users = $koneksi->query("SELECT * FROM users");
$categories = $koneksi->query("SELECT * FROM categories");
$questions = $koneksi->query("SELECT * FROM questions");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Super Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .delete-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .delete-button:hover {
            background-color: #d32f2f;
        }
        .logout-button {
            background-color: #2196F3;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            float: right;
            margin-bottom: 20px;
        }
        .logout-button:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Super Admin Dashboard</h1>

        <!-- Logout Button -->
        <a href="logout.php">
            <button class="logout-button">Logout</button>
        </a>

        <h2>Users</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Username</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php while ($user = $users->fetch_assoc()): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['first_name']; ?></td>
                <td><?php echo $user['last_name']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['role']; ?></td>
                <td><button class="delete-button" onclick="deleteItem('user', <?php echo $user['id']; ?>)">Delete</button></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <h2>Categories</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
            <?php while ($category = $categories->fetch_assoc()): ?>
            <tr>
                <td><?php echo $category['id']; ?></td>
                <td><?php echo $category['name']; ?></td>
                <td><button class="delete-button" onclick="deleteItem('category', <?php echo $category['id']; ?>)">Delete</button></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <h2>Questions</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Category ID</th>
                <th>Question Text</th>
                <th>Action</th>
            </tr>
            <?php while ($question = $questions->fetch_assoc()): ?>
            <tr>
                <td><?php echo $question['id']; ?></td>
                <td><?php echo $question['category_id']; ?></td>
                <td><?php echo $question['question']; ?></td>
                <td><button class="delete-button" onclick="deleteItem('question', <?php echo $question['id']; ?>)">Delete</button></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <script>
        function deleteItem(type, id) {
            if (confirm('Are you sure you want to delete this ' + type + '?')) {
                window.location.href = 'delete.php?type=' + type + '&id=' + id;
            }
        }
    </script>
</body>
</html>
