<?php
session_start();


$con = mysqli_connect("localhost", "root", "", "foodinfo");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Login check
if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = $_POST['password']; // No md5, plain text check

    $sql = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['admin'] = $row['username'];
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<h3 style='color:red; text-align:center;'>Invalid username or password</h3>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - Grill & Bite</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }
        .login-container {
            width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
            color: #333;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            font-weight: bold;
            margin-top: 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .navbar {
            background-color: #333;
            padding: 15px;
        }
        .navbar .logo {
            color: white;
            font-size: 24px;
            font-weight: bold;
            float: left;
        }
        .navbar .nav-links {
            list-style: none;
            float: right;
        }
        .navbar .nav-links li {
            display: inline-block;
            margin-left: 20px;
        }
        .navbar .nav-links li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <div class="logo">Grill & Bite</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
            <div style="clear:both;"></div>
        </div>
    </header>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <input type="submit" name="submit" value="Login">
        </form>
    </div>
</body>
</html>
