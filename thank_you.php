<?php 
session_start();
$con = mysqli_connect("localhost", "root", "", "foodinfo");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['last_bill'])) {
    header("Location: menu.php");
    exit();
}

$bill_id = $_SESSION['last_bill'];
$username = $_SESSION['username'] ?? 'Guest';

// Fetch order details
$sql = "
    SELECT fm.name AS food_name, oi.quantity, oi.price 
    FROM order_items oi 
    JOIN food_menu fm ON oi.food_id = fm.id 
    WHERE oi.order_id = ?
";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $bill_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
$order_items = [];

while ($row = $result->fetch_assoc()) {
    $row['subtotal'] = $row['quantity'] * $row['price'];
    $order_items[] = $row;
    $total += $row['subtotal'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Receipt - Grill & Bite</title>
    <style>
        /* McDonald's Theme */
        :root {
            --primary: #DA291C;
            --accent: #FFC72C;
            --bg-light: #FFF5E1;
            --white: #fff;
            --dark: #333;
        }

        body {
            background-color: var(--bg-light);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--primary);
            padding: 15px 30px;
        }

        .logo {
            color: var(--accent);
            font-size: 26px;
            font-weight: bold;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        .nav-links a {
            color: var(--white);
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        /* Main container */
        .bill-container {
            background-color: var(--white);
            max-width: 700px;
            margin: 60px auto 40px;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            flex-grow: 1;
        }

        .bill-container h2 {
            text-align: center;
            color: var(--primary);
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 1.8rem;
        }

        .bill-container p {
            font-size: 16px;
            margin: 5px 0 15px;
        }

        .bill-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .bill-table th, .bill-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }

        .bill-table th {
            background-color: var(--bg-light);
            color: var(--dark);
        }

        .bill-summary {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            margin-top: 10px;
            color: var(--primary);
        }

        /* Buttons */
        .actions {
            text-align: center;
            margin-top: 30px;
        }

        .actions button,
        .actions a {
            display: inline-block;
            margin: 10px 8px;
            padding: 12px 20px;
            background-color: var(--primary);
            color: var(--accent);
            border: none;
            border-radius: 6px;
            font-size: 16px;
            text-decoration: none;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s ease;
        }

        .actions button:hover,
        .actions a:hover {
            background-color: #b01e1b;
            color: var(--white);
        }

        /* Cancel Button */
        .cancel-btn {
            background-color: #444;
            color: white;
        }

        .cancel-btn:hover {
            background-color: #222;
        }

        /* Footer */
        footer {
            background-color: var(--primary);
            color: var(--accent);
            padding: 20px 30px;
            text-align: center;
            font-weight: bold;
            margin-top: auto;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .bill-container {
                margin: 40px 15px 30px;
                padding: 20px;
            }
            .bill-container h2 {
                font-size: 1.5rem;
            }
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
            <li><a href="logout.php">Logout</a></li>
            <li><a href="admin_login.php">Admin</a></li>
        </ul>
    </div>
</header>

<div class="bill-container">
    <h2>Grill & Bite - Order Receipt</h2>
    <p><strong>Customer:</strong> <?php echo htmlspecialchars($username); ?></p>
    <p><strong>Order ID:</strong> <?php echo htmlspecialchars($bill_id); ?></p>

    <table class="bill-table">
        <tr>
            <th>Item</th>
            <th>Quantity</th>
            <th>Price (₹)</th>
            <th>Subtotal (₹)</th>
        </tr>
        <?php foreach ($order_items as $item): ?>
        <tr>
            <td><?php echo htmlspecialchars($item['food_name']); ?></td>
            <td><?php echo (int)$item['quantity']; ?></td>
            <td>₹<?php echo number_format($item['price'], 2); ?></td>
            <td>₹<?php echo number_format($item['subtotal'], 2); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="bill-summary">
        Grand Total: ₹<?php echo number_format($total, 2); ?>
    </div>

    <div class="actions">
        <button onclick="window.print()">🖨️ Print / Save as PDF</button>

        <!-- Cancel Order Button -->
        <form action="cancel_order.php" method="POST" style="display:inline;">
    <input type="hidden" name="order_id" value="<?php echo $bill_id; ?>">
    <button type="submit" onclick="return confirm('Are you sure you want to cancel this order?')">
        ❌ Cancel Order
    </button>
</form>


        <a href="menu.php">← Back to Menu</a>
    </div>
</div>

<footer>
    &copy; <?= date('Y') ?> Grill & Bite. All rights reserved.
</footer>

</body>
</html>
