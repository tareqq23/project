<!DOCTYPE html>
<html>
<head>
    <title>About - E-Survey</title>
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
        nav .logo {
            color: white;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
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
            margin-left: 250px; 
            margin-top: 250px;
            width: calc(100% - 250px);
            max-width: 800px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
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
        <h2>Admin Dashboard</h2>
    </div>

    
</body>
</html>
