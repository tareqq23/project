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

$sql = "SELECT * FROM categories";
$result = $koneksi->query($sql);
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
            background-attachment: fixed;
            margin: 0;
            padding: 80px;
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
            padding-right: 50px;
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
            background-color: rgba(255, 255, 255, 0.8);
            margin-top: 40px;
            padding: 40px;
            border-radius: 30px;
            width: 100%;
            max-width: 700px;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            gap: 20px;
        }
        .card {
            width: 300px;
            background-color: #fff;
            border-radius: 8px;
            margin-left: 25px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s, black-shadow 0.3s;
            
        }
        .card:hover{
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-content {
            padding: 20px;
            text-align: center;
        }
        .card-content h2 {
            margin-top: 0;
        }
        .card-content p {
            margin: 10px 0;
            color: #666;
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
    <?php while ($row_cat = $result->fetch_assoc()) : ?>
        <div class="card">
            <img src="<?php echo $row_cat['cover_image']; ?>" alt="<?php echo $row_cat['name']; ?>">
            <div class="card-content">
                <h2><?php echo $row_cat['name']; ?></h2>
                <p><?php echo $row_cat['description']; ?></p>
                <form method="post" action="isi_survey.php">
                    <input type="hidden" name="category_id" value="<?php echo $row_cat['id']; ?>">
                    <button type="submit">Take Survey</button>
                </form>
            </div>
        </div>
    <?php endwhile; ?>
</div>
</body>
</html>
