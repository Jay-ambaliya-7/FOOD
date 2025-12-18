<?php
session_start();

// DB Connection
$con = mysqli_connect("localhost", "root", "", "foodinfo");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$error = ""; // initialize error

// Handle form submission
if (isset($_POST['submit'])) {
    $user_input = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Check using username OR email
    $sql = "SELECT * FROM users WHERE (name='$user_input' OR email='$user_input') AND password='$password'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['name'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username/email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* ==========================
           McDonald's Theme Colors
        ========================== */
        :root {
            --primary: #DA291C;  /* McDonald's Red */
            --accent: #FFC72C;   /* McDonald's Yellow */
            --background: #FFF5E1;
            --text-dark: #333;
            --white: #fff;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: var(--background);
            color: var(--text-dark);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar */
        header .navbar {
            background-color: var(--primary);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-weight: bold;
            font-size: 26px;
            color: var(--accent);
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        .nav-links li a {
            text-decoration: none;
            font-weight: bold;
            color: var(--white);
            transition: color 0.3s;
        }

        .nav-links li a:hover {
            color: var(--accent);
        }

        /* Login Form */
        h2 {
            text-align: center;
            margin-top: 40px;
            font-size: 28px;
            color: var(--primary);
        }

        #login-form {
            width: 320px;
            margin: 40px auto;
            padding: 25px 30px;
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
        }

        #login-form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: var(--primary);
        }

        #login-form input[type="text"],
        #login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 2px solid var(--accent);
            border-radius: 5px;
            outline: none;
        }

        #login-form input[type="text"]:focus,
        #login-form input[type="password"]:focus {
            border-color: var(--primary);
        }

        #login-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: var(--accent);
            color: var(--text-dark);
            border: none;
            border-radius: 5px;
            margin-top: 20px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        #login-form input[type="submit"]:hover {
            background-color: #ffb300;
        }

        #login-form div {
            text-align: center;
            margin-top: 15px;
        }

        #login-form div a {
            text-decoration: none;
            font-weight: bold;
            padding: 6px 12px;
            color: var(--primary);
            border: 2px solid var(--primary);
            border-radius: 5px;
            transition: 0.3s;
        }

        #login-form div a:hover {
            background-color: var(--primary);
            color: var(--white);
        }

        .error {
            color: var(--primary);
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }

        /* Footer */
        footer {
            background-color: var(--primary);
            color: var(--white);
            padding: 20px;
            text-align: center;
            margin-top: auto;
        }

        footer a {
            color: var(--accent);
            text-decoration: none;
            font-weight: bold;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
      <header>
        <div class="navbar">
            <div class="logo">Eat & Repeat</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a href="admin_login.php">Admin</a></li>
            </ul>
        </div>
    </header>

    <h2>Login Page</h2>

    <div id="login-form">
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="POST" action="">
            <label>Email or Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <input type="submit" name="submit" value="Login">

            <div>
                <a href="createAccount.php">Create Your Account!</a>
            </div>
        </form>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Grill & Bite. All Rights Reserved.</p>
        <p>
            <a href="about.php">About Us</a> |
            <a href="contact.php">Contact</a> |
            <a href="privacy.php">Privacy Policy</a>
        </p>
    </footer>
</body>
</html>
