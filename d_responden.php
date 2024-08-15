<!DOCTYPE html>
<html>
<head>
    <title>About - Green Insight</title>
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
            margin-top: 100px; 
            width: 90%;
            max-width: 800px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        p {
            margin-bottom: 20px;
        }
        .content {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .content .card {
            width: 200px;
            background-color: #006241; 
            color: white;
            padding: 10px;
            margin-top: 10px;
            border-radius: 8px;
            text-align: center;
        }
        .footer {
            width: 100%;
            background: #006241;
            padding: 10px 0;
            text-align: center;
            color: white;
            position: fixed;
            bottom: 0;
            left: 0;
        }
        .illust {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .illust img {
            width: 30%;
            border-radius: 10px;
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
        <h2>About Green Insight</h2>
        <div class="illust">
            <img src="contens.jpg" alt="contens">
            <p>Welcome to Green Insight, your go-to platform for comprehensive environmental insights and sustainability surveys. At Green Insight, we aim to promote awareness and action towards a greener future by providing users with insightful surveys and data-driven results. Whether you are a respondent looking to contribute your thoughts on environmental topics or an administrator managing and analyzing survey data, Green Insight is here to support your needs. Thank you for choosing Green Insight as your partner in sustainability!</p>
        </div>
        
        <div class="content">
            <div class="card">
                <h3>Our Mission</h3>
                <p>Promoting sustainability through comprehensive insights.</p>
            </div>
            <div class="card">
                <h3>Our Vision</h3>
                <p>A world where every decision is guided by environmental awareness.</p>
            </div>
            <div class="card">
                <h3>Get Involved</h3>
                <p>Join our community and contribute to meaningful change.</p>
            </div>
        </div>
    </div>
    
    <div class="footer">
        <p>&copy; 2024 Green Insight. All rights reserved.</p>
    </div>
</body>
</html>
