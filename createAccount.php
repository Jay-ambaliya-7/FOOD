<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grill & Bite - Create Account</title>
    <link rel="stylesheet" href="style.css">
    <style>
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 90vh;
            background-color: #f5f5f5;
        }

        .form {
            background-color: #fff;
            padding: 30px 35px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        .form label {
            font-weight: bold;
            font-size: 18px;    
            color: #333;
            display: block;
            margin-top: 17px;
        }

        .form input[type="text"],
        .form input[type="email"],
        .form input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 25px;
            background-color: #28a745;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form input[type="submit"]:hover {
            background-color: #218838;
        }

        .success {
            color: green;
            text-align: center;
            margin-top: 20px;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 20px;
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
        </div>
    </header>

    <main>
        <form method="POST" class="form" action="">
            <label for="name">Full Name (use underscores only):</label>
            <input type="text" name="name" id="name" required pattern="^[A-Za-z_]+$" title="Only letters and underscores allowed">

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" required pattern="[0-9]{10}" title="Enter 10-digit phone number">

            <input type="submit" name="submit" value="Create Account">
        </form>
    </main>
</body>
</html>

<?php
// Connection
$con = mysqli_connect("localhost", "root", "", "foodinfo");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// When submitted
if (isset($_POST['submit'])) {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $phone    = $_POST['phone'];

    // Name validation
    if (!preg_match('/^[A-Za-z_]+$/', $name)) {
        echo "<p class='error'>Name can only contain letters and underscores.</p>";
        exit;
    }

    // Check duplicate
    $check = mysqli_query($con, "SELECT * FROM users WHERE email='$email' OR phone='$phone'");
    if (mysqli_num_rows($check) > 0) {
        echo "<p class='error'>Email or Phone already exists.</p>";
        exit;
    }

    // Insert
    $sql = "INSERT INTO users (name, email, password, phone) 
            VALUES ('$name', '$email', '$password', '$phone')";

    if (mysqli_query($con, $sql)) {
        echo "<p class='success'>Account created successfully!</p>";
        header('Location: index.php');
    } else {
        echo "<p class='error'>Error: " . mysqli_error($con) . "</p>";
    }
}
?>
