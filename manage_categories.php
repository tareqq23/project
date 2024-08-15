<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_category'])) {
        $name = htmlspecialchars($_POST['name']);
        $description = htmlspecialchars($_POST['description']); 
        
        // Proses upload gambar
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["cover_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file adalah gambar asli atau tidak
        $check = getimagesize($_FILES["cover_image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "<div class='error'>File is not an image.</div>";
            $uploadOk = 0;
        }

        // Cek jika file sudah ada
        if (file_exists($target_file)) {
            echo "<div class='error'>Sorry, file already exists.</div>";
            $uploadOk = 0;
        }

        // Cek ukuran file
        if ($_FILES["cover_image"]["size"] > 500000) { // 500KB
            echo "<div class='error'>Sorry, your file is too large.</div>";
            $uploadOk = 0;
        }

        // Cek format file
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            echo "<div class='error'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
            $uploadOk = 0;
        }

        // Cek jika $uploadOk adalah 0 karena ada error
        if ($uploadOk == 0) {
            echo "<div class='error'>Sorry, your file was not uploaded.</div>";
        // Jika semua cek lulus, kemudia upload file
        } else {
            if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO categories (name, cover_image, description) VALUES ('$name', '$target_file', '$description')";
                if ($koneksi->query($sql) === TRUE) {
                    echo "<div class='success'>Category added successfully</div>";
                } else {
                    echo "<div class='error'>Error: " . $sql . "<br>" . $koneksi->error . "</div>";
                }
            } else {
                echo "<div class='error'>Sorry, there was an error uploading your file.</div>";
            }
        }
    }

    if (isset($_POST['delete_category'])) {
        $category_id = $_POST['category_id'];

        // Hapus semua entri terkait di tabel responses yang mengacu pada pertanyaan di kategori ini
        $sql_get_questions = "SELECT id FROM questions WHERE category_id = ?";
        $stmt_get_questions = $koneksi->prepare($sql_get_questions);
        $stmt_get_questions->bind_param("i", $category_id);
        $stmt_get_questions->execute();
        $result_get_questions = $stmt_get_questions->get_result();

        while ($row_question = $result_get_questions->fetch_assoc()) {
            $question_id = $row_question['id'];
            $sql_delete_responses = "DELETE FROM responses WHERE question_id = ?";
            $stmt_delete_responses = $koneksi->prepare($sql_delete_responses);
            $stmt_delete_responses->bind_param("i", $question_id);
            $stmt_delete_responses->execute();
        }

        // Hapus semua pertanyaan yang terkait dengan kategori ini
        $sql_delete_questions = "DELETE FROM questions WHERE category_id = ?";
        $stmt_delete_questions = $koneksi->prepare($sql_delete_questions);
        $stmt_delete_questions->bind_param("i", $category_id);
        $stmt_delete_questions->execute();

        // Hapus kategori setelah semua pertanyaan dan respons yang terkait dihapus
        $sql_delete_category = "DELETE FROM categories WHERE id = ?";
        $stmt_delete_category = $koneksi->prepare($sql_delete_category);
        $stmt_delete_category->bind_param("i", $category_id);
        $stmt_delete_category->execute();

        if ($stmt_delete_category->affected_rows > 0) {
            echo "<div class='success'>Category deleted successfully</div>";
        } else {
            echo "<div class='error'>Error deleting category</div>";
        }
    }

    if (isset($_POST['update_category'])) {
        $category_id = $_POST['category_id'];
        $name = htmlspecialchars($_POST['name']);
        $description = htmlspecialchars($_POST['description']);  // Add description field
        $cover_image = '';

        if (!empty($_FILES['cover_image']['name'])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["cover_image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Periksa apakah file gambar adalah gambar asli atau gambar palsu
            $check = getimagesize($_FILES["cover_image"]["tmp_name"]);
            if($check !== false) {
                if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_file)) {
                    $cover_image = $target_file;
                } else {
                    echo "<div class='error'>Sorry, there was an error uploading your file.</div>";
                }
            } else {
                echo "<div class='error'>File is not an image.</div>";
            }
        }

        if ($cover_image) {
            $sql_update_category = "UPDATE categories SET name = ?, cover_image = ?, description = ? WHERE id = ?";
            $stmt_update_category = $koneksi->prepare($sql_update_category);
            $stmt_update_category->bind_param("sssi", $name, $cover_image, $description, $category_id);
        } else {
            $sql_update_category = "UPDATE categories SET name = ?, description = ? WHERE id = ?";
            $stmt_update_category = $koneksi->prepare($sql_update_category);
            $stmt_update_category->bind_param("ssi", $name, $description, $category_id);
        }
        
        $stmt_update_category->execute();

        if ($stmt_update_category->affected_rows > 0) {
            echo "<div class='success'>Category updated successfully</div>";
        } else {
            echo "<div class='error'>Error updating category</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Categories</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #333;
            position: static;
        }
        nav .logo {
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
        nav {
            height: 100%;
            width: 250px;
            background-color: #006241; 
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
        }
        nav ul li {
            margin: 10px 0;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: background 0.3s;
            border-radius: 4px;
            padding: 10px 20px;
        }
        nav ul li a:hover {
            background-color: #004d37;  
        }
        .container {
            margin-left: 200px; 
            margin-top: 80px;
            width: 90%;
            max-width: 800px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .container h1, .container h2 {
            text-align: center;
        }
        form {
            margin-bottom: 20px;
        }
        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        form input[type="text"], form input[type="file"], form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #cccccc;
            border-radius: 4px;
        }
        form button {
            background-color: #006241;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        form button:hover {
            background-color: #004d37;
        }
        .success {
            color: green;
            margin-bottom: 20px;
            text-align: center;
        }
        .error {
            color: red;
            margin-bottom: 20px;
            text-align: center;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidesbar {
            display: flex;
            justify-content: left;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        ul li form {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        ul li form input[type="text"] {
            width: auto;
            flex-grow: 1;
            padding: 5px;
        }
        ul li form input[type="file"] {
            width: auto;
            flex-grow: 1;
            padding: 5px;
        }
        ul li form textarea {
            width: auto;
            flex-grow: 1;
            padding: 5px;
        }
        ul li form button {
            width: auto;
            padding: 5px 10px;
        }
        img.icon {
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }
        img.category-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            margin-right: 10px;
        }
        
        .existing-categories {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .existing-categories li {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .existing-categories li img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .existing-categories li form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .existing-categories li form input[type="text"],
        .existing-categories li form textarea {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .existing-categories li form button {
            padding: 10px 15px;
            background-color: #006241;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .existing-categories li form button:hover {
            background-color: #004d37;
        }

    </style>
</head>
<body>
    <nav>
        <div class="logo">  
            <a href="dashboard.php"><img src="logos.png" alt="Logo" style="height: 50px;"></a>
        </div>
        <ul>
            <li class="sidesbar"><a href="manage_categories.php"><img class="icon" src="icon/manage.png" alt="Dashboard Icon">Manage Categories</a></li>
            <li class="sidesbar"><a href="manage_questions.php"><img class="icon" src="icon/question_icon.png" alt="Logout Icon">Manage Questions</a></li>
            <li class="sidesbar"><a href="view_results.php"><img class="icon" src="icon/view_icon.png" alt="View Icon">View Survey Results</a></li>
            <li class="sidesbar"><a href="logout.php"><img class="icon" src="icon/logout_icon.png" alt="Logout Icon">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1>Manage Categories</h1>
        <!-- adding new category -->
        <form method="post" action="" enctype="multipart/form-data">
            <label for="name">Category Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            <label for="cover_image">Cover Image (maximal size 500Kb):</label>
            <input type="file" id="cover_image" name="cover_image" accept="image/*" required>
            <button type="submit" name="add_category">Add Category</button>
        </form>

        <h2>Existing Categories</h2>
            <ul class="existing-categories">
                <?php
                $sql = "SELECT * FROM categories";
                $result = $koneksi->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<li>";
                    if (!empty($row['cover_image'])) {
                        echo "<img src='" . htmlspecialchars($row['cover_image']) . "' alt='Category Image'>";
                    }
                    echo "<form method='post' action='' enctype='multipart/form-data'>";
                    echo "<input type='text' name='name' value='".htmlspecialchars($row['name'])."' required>";
                    echo "<textarea name='description' required>".htmlspecialchars($row['description'])."</textarea>";
                    echo "<input type='file' name='cover_image' accept='image/*'>";
                    echo "<input type='hidden' name='category_id' value='{$row['id']}'>";
                    echo "<button type='submit' name='update_category'>Update</button>";
                    echo "</form>";
                    echo "<form method='post' action='' style='margin-top: 10px;'>";
                    echo "<input type='hidden' name='category_id' value='{$row['id']}'>";
                    echo "<button type='submit' name='delete_category'>Delete</button>";
                    echo "</form>";
                    echo "</li>";
                }
                ?>
            </ul>
    </div>
</body>
</html>
