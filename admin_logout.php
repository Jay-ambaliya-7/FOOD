<?php
session_start();

// Save the name before destroying session
$name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Admin';

// Destroy session data
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Logout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .box {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
        }
        h1 {
            color: #e74c3c;
        }
        p {
            font-size: 18px;
            color: #555;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            text-decoration: none;
            background: #3498db;
            color: white;
            border-radius: 5px;
            transition: background 0.3s;
        }
        a:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="box">
        <h1>You have been logged out</h1>
        <p>Goodbye, <?php echo htmlspecialchars($name); ?>!</p>
        <a href="admin_login.php">Go to Login</a>
    </div>
</body>
</html>
