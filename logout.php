<?php
session_start();

// Destroy session
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logout - Eat & Repeat</title>
    <meta http-equiv="refresh" content="3;url=login.php"> <!-- Redirect after 3 seconds -->
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .message-box {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        .message-box h1 {
            color: #e53935;
            margin-bottom: 15px;
        }

        .message-box p {
            color: #555;
        }

        .message-box a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background-color: #e53935;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .message-box a:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

<div class="message-box">
    <h1>You have been logged out.</h1>
    <p>Redirecting to login page...</p>
    <a href="login.php">Go to Login Now</a>
</div>

</body>
</html>
