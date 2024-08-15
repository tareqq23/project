<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(background.jpg);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }
        nav {
            width: 100%;
            background-color: #006241;
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
        nav .logo img {
            height: 40px;
            width: auto;
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
            margin: 0 10px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        nav ul li a:hover {
            background-color: #004d37;
        }
        .content {
            text-align: center;
            margin-top: 80px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 20px;
            color: #006241;
        }
        .team-member {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 30px;
            margin-top: 30px;
        }
        .team-member .member {
            width: 200px;
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .team-member .member:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
        .team-member .member img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .team-member .member h2 {
            margin: 0;
            color: #006241;
        }
        .team-member .member p {
            color: #333;
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
    <div class="content">
        <h1>Tentang Kami</h1>
        <div class="team-member">
            <div class="member">
                <img src="team1.jpg" alt="Team Member">
                <h2>M. Tareq</h2>
                <p>11222070</p>
            </div>
            <div class="member">
                <img src="team2.jpg" alt="Team Member">
                <h2>M. Hafi Dimas</h2>
                <p>11222073</p>
            </div>
            <div class="member">
                <img src="team3.jpg" alt="Team Member">
                <h2>Mohamad Haidar</h2>
                <p>11222074</p>
            </div>
            <div class="member">
                <img src="team4.jpg" alt="Team Member">
                <h2>Sadam Alamsyah</h2>
                <p>11222124</p>
            </div>
        </div>
    </div>
</body>
</html>
