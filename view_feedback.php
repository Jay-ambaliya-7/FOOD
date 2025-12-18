<?php
session_start();

// (Optional) Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Connect to DB
$conn = new mysqli("localhost", "root", "", "foodinfo");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all feedback
$sql = "SELECT id, name, feedback, submitted_at FROM feedback ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Feedback - Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #FFF8E1;
            padding: 30px;
        }
        h1 {
            text-align: center;
            color: #DA291C;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            background: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #DA291C;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .btn {
            background: #DA291C;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 6px;
        }
        .btn:hover {
            background: #FFC72C;
            color: black;
        }
    </style>
</head>
<body>
    <h1>User Feedback</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Feedback</th>
            <th>Submitted At</th>
            <th>Action</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['feedback']); ?></td>
                    <td><?php echo $row['submitted_at']; ?></td>
                    <td>
                        <a class="btn" href="delete_feedback.php?id=<?php echo $row['id']; ?>" 
                           onclick="return confirm('Delete this feedback?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5" style="text-align:center;">No feedback available</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
<?php $conn->close(); ?>
