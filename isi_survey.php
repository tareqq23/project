<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'responden') {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['responses'])) {
    $responses = $_POST['responses'] ?? [];
    $user_id = $_SESSION['user_id'];

    if (!empty($responses)) {
        foreach ($responses as $question_id => $response) {
            $stmt = $koneksi->prepare("INSERT INTO responses (user_id, question_id, response) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $user_id, $question_id, $response);
            $stmt->execute();
        }
        echo "<div class='success'>Survey submitted successfully</div>";
    } else {
        echo "<div class='error'>No responses provided.</div>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];
    $sql_questions = "SELECT * FROM questions WHERE category_id = $category_id";
    $result_questions = $koneksi->query($sql_questions);
} else {
    header("Location: thanks.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Take Survey</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }
        nav {
            width: 100%;
            background: #006241;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav .logo {
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
        nav .logo img {
            height: 50px;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }
        nav ul li {
            margin: 0 15px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
            transition: background 0.3s;
        }
        nav ul li a:hover {
            background-color: #004d37;
            border-radius: 4px;
        }
        .container {
            margin-top: 80px;
            width: 90%;
            max-width: 800px;
        }
        .question {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .question h2 {
            margin-top: 0;
        }
        .likert-scale {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 0;
        }
        .likert-scale input {
            display: none;
        }
        .likert-scale label {
            cursor: pointer;
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: #f1f1f1;
            border: 1px solid #ddd;
            transition: background-color 0.3s;
        }
        .likert-scale input:checked + label {
            background-color: #006241;
            color: white;
            border-color: #004d37;
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
        .note {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .note ul {
            list-style: none;
            padding: 0;
        }
        .note ul li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<nav>
    <div class="logo">  
        <a href="d_responden.php"><img src="logos.png" alt="Logo" style="height: 50px;"></a>
    </div>
    <ul>
        <li><a href="d_responden.php">Dashboard</a></li>
        <li><a href="take_survey.php">Take Survey</a></li>
        <li><a href="team.php">About Team</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>
<div class="container">
    <div class="note">
        <h2>Note:</h2>
        <ul>
            <li>1 = Sangat tidak setuju</li>
            <li>2 = Tidak setuju</li>
            <li>3 = Biasa saja</li>
            <li>4 = Setuju</li>
            <li>5 = Sangat setuju</li>
        </ul>
    </div>
        <form method="post" action="">
            <?php while ($row_question = $result_questions->fetch_assoc()) : ?>
                <div class="question">
                    <h2><?php echo $row_question['question']; ?></h2>
                    <div class="likert-scale">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <input type="radio" id="question_<?php echo $row_question['id']; ?>_<?php echo $i; ?>" name="responses[<?php echo $row_question['id']; ?>]" value="<?php echo $i; ?>" required>
                            <label for="question_<?php echo $row_question['id']; ?>_<?php echo $i; ?>"><?php echo $i; ?></label>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endwhile; ?>
            <button type="submit">Submit Survey</button>
        </form>
    </div>
    
</body>
</html>
