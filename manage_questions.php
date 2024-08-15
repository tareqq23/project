<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_id = htmlspecialchars($_POST['category_id']);
    $question = htmlspecialchars($_POST['question']);
    $question_type = htmlspecialchars($_POST['question_type']);
    $sql = "INSERT INTO questions (category_id, question, question_type) VALUES ('$category_id', '$question', '$question_type')";
    if ($koneksi->query($sql) === TRUE) {
        echo "<div class='success'>Question added successfully</div>";
    } else {
        echo "<div class='error'>Error: " . $sql . "<br>" . $koneksi->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Questions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            color: #333;
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
            margin-top: 90px;  
            width: 90%;
            max-width: 800px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            margin-left: 200px;
            margin-bottom: 90px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        form input[type="text"],
        form textarea,
        form select {
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
        }
        .error {
            color: red;
            margin-bottom: 20px;
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
        ul li form button {
            width: auto;
            padding: 5px 10px;
        }
        img.icon {
            width: 24px;
            height: 24px;
            margin-right: 10px;
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
        <h2>Manage Questions</h2>
        <form method="post" action="">
            <label>Category:</label>
            <select name="category_id">
                <?php
                $sql = "SELECT * FROM categories";
                $result = $koneksi->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                }
                ?>
            </select><br>
            <label>Question:</label>
            <textarea name="question" required></textarea><br>
            <label>Question Type:</label>
            <select name="question_type" required>
                <option value="multiple_choice">Multiple Choice</option>
                <option value="rating_scale">Rating Scale</option>
                <option value="star_rating">Star Rating</option>
                <option value="ranking">Ranking</option>
                <option value="single_line">Single Line</option>
                <option value="multiple_line">Multiple Line</option>
            </select><br>
            <button type="submit">Add Question</button>
        </form>

        <h2>Existing Questions</h2>
        <ul>
            <?php
            $sql = "SELECT q.*, c.name as category_name FROM questions q JOIN categories c ON q.category_id = c.id";
            $result = $koneksi->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row['category_name']) . ": " . htmlspecialchars($row['question']) . " (" . htmlspecialchars($row['question_type']) . ")</li>";
            }
            ?>
        </ul>
    </div>
</body>
</html>
