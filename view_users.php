<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "foodinfo");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Simple check — only allow admin username
/*if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    die("Access denied. Admins only.");
}*/

$result = mysqli_query($con, "SELECT id, name, email FROM users");

?>
<!DOCTYPE html>
<html>
<head>
    <title>View Users</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f44336; color: white; }
    </style>
</head>
<body>
<h2 style="text-align:center;">Registered Users</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['email'] ?></td>
    </tr>
    <?php } ?>
</table>
</body>
</html>
