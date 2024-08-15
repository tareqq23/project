<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

$categories = [];
$sql_categories = "SELECT * FROM categories";
$result_categories = $koneksi->query($sql_categories);
while ($row_cat = $result_categories->fetch_assoc()) {
    $categories[] = $row_cat;
}

function getCategoryData($koneksi, $category_id) {
    $data = [];
    $sql_questions = "SELECT * FROM questions WHERE category_id = $category_id";
    $result_questions = $koneksi->query($sql_questions);
    while ($row_question = $result_questions->fetch_assoc()) {
        $question_id = $row_question['id'];

        $responses = [0, 0, 0, 0, 0];
        $sql_responses = "SELECT response FROM responses WHERE question_id = $question_id";
        $result_responses = $koneksi->query($sql_responses);
        while ($row_response = $result_responses->fetch_assoc()) {
            $response_value = intval($row_response['response']);
            if ($response_value >= 1 && $response_value <= 5) {
                $responses[$response_value - 1]++;
            }
        }
        $data[$row_question['question']] = $responses;
    }
    return $data;
}

$selected_category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : $categories[0]['id'];
$data = getCategoryData($koneksi, $selected_category_id);

$questions = json_encode(array_keys($data));
$sangat_tidak_puas = json_encode(array_column($data, 0));
$tidak_puas = json_encode(array_column($data, 1));
$netral = json_encode(array_column($data, 2));
$puas = json_encode(array_column($data, 3));
$sangat_puas = json_encode(array_column($data, 4));
?>

<!DOCTYPE html>
<html lang="eng">
<head>
    <title>View Survey Results</title>
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
            margin-top: 50px;
            width: calc(100% - 250px);
            max-width: 800px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
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
        .category {
            margin-bottom: 40px;
        }
        .category h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .question {
            margin-bottom: 20px;
        }
        .response {
            margin-left: 20px;
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
        .note {
            background-color: #f0f0f0; 
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
        .save-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #006241;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .save-button:hover {
            background-color: #004d37;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <h1>Survey Results</h1>

        <form method="GET" action="">
            <label for="category_id">Select Category:</label>
            <select name="category_id" id="category_id" onchange="this.form.submit()">
                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $selected_category_id) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <canvas id="surveyChart" width="400" height="200"></canvas>
        <script>
            var ctx = document.getElementById('surveyChart').getContext('2d');
            var surveyChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo $questions; ?>,
                    datasets: [{
                        label: 'Sangat Tidak Puas',
                        data: <?php echo $sangat_tidak_puas; ?>,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Tidak Puas',
                        data: <?php echo $tidak_puas; ?>,
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Netral',
                        data: <?php echo $netral; ?>,
                        backgroundColor: 'rgba(255, 205, 86, 0.2)',
                        borderColor: 'rgba(255, 205, 86, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Puas',
                        data: <?php echo $puas; ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Sangat Puas',
                        data: <?php echo $sangat_puas; ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </div>
</body>
</html>
