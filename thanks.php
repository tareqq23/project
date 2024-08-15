<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(background.jpg);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }
        nav {
            width: 100%;
            background-color: #006241;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixcen
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
            background-color: rgba(255, 255, 255, 0.9);  
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .thank-you {
            font-size: 24px;
            margin-bottom: 20px;
        }
        img.team {
            width: 300px;
            height: auto;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="content">
        <h1 class="thank-you">Terima Kasih Telah Mengisi Survey</h1>
        <img src="team.png" alt="Team" class="team">
        <p>Tim kami mengapresiasi partisipasi Anda dalam survey ini. <br>Kontribusi Anda sangat berharga bagi kami dalam meningkatkan kualitas layanan kami. <br>Terima kasih atas waktu dan perhatiannya.</p>
    </div>
    <script>
        setTimeout(function(){
            window.location.href = "d_responden.php";
        }, 3000);  
    </script>
</body>
</html>
