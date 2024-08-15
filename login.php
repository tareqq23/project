<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            background-image: url('background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        form input[type="text"],
        form input[type="password"] {
            width: 90%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #cccccc;
            border-radius: 4px;
        }
        form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        form button:hover {
            background-color: #45a049;
        }
        form a {
            color: #4CAF50;
            text-decoration: none;
        }
        form a:hover {
            text-decoration: underline;
        }
        .position{
            text-align: left;
        }
        .logo{
            border-radius: 4px;
            background-color: grey;
            fill-opacity: 10px;
        }
    </style>
</head>
<body>
    <form method="post" action="login_process.php">
        <div class="logo">  
            <img src="logos.png" alt="Logo" style="height: 50px;">
        </div><br>
        <label class="position">Username:</label>
        <input type="text" name="username" required><br>
        <label class="position">Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button><br><br>
        <a href="forgot_password.php">Forgot Password?</a><br><br>
        Don't have an account? <a href="register.php">Register</a>
    </form>
</body>
</html>
