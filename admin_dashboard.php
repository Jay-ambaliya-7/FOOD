<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
     <link rel="stylesheet" href="style.css">
</head>
<body>
    <style>
        /* Reset some defaults */
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #f7f7f7;
}

/* Navbar styling */
.navbar {
    background-color: #333;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    font-size: 24px;
    font-weight: bold;
    color: #fff;
}

.nav-links {
    list-style: none;
    display: flex;
    gap: 20px;
}

.nav-links li a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
}

.nav-links li a:hover {
    color: #fbb034;
}

/* Admin Dashboard Content */
h1 {
    text-align: center;
    margin-top: 40px;
    color: red;
    font-size: 28px;
    font-family:arial;
    
}

ul {
    list-style: none;
    padding: 0;
    max-width: 400px;
    margin: 50px auto;
}

ul li {
    margin: 15px 0;
}

ul li a {
    display: block;
    text-align: center;
    padding: 12px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: bold;
    transition: 0.3s;
}

ul li a:hover {
    background-color: #45a049;
}

        </style>
    <header>
        <div class="navbar">
            <div class="logo">Grill & Bite</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="admin_login.php">Admin</a></li>

            </ul>
        </div>
    </header>
   <h1>
    Welcome Admin: <?php echo htmlspecialchars($_SESSION['admin']); ?>
    <?php 
        if ($_SESSION['admin'] === 'jay') 
            {
            echo " (The Boss)";
        }
         if ($_SESSION['admin'] === 'mohitrajsinh') 
            {
            echo " (The Gangster)";
        }
    ?>
    
</h1>

    <ul>
        <li><a href="view_users.php">View Users</a></li>
        <li><a href="view_orders.php">View Orders</a></li>
        <li><a href="manage_items.php">Manage Menu</a></li>
       
         <li><a href="view_feedback.php">Feedback</a></li>
         <li><a href="admin_logout.php">Logout</a></li>
        
    </ul>
</body>
</html>
