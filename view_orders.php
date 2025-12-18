<?php
session_start();
if (!isset($_SESSION['admin'])) { 
    header("Location: admin_login.php"); 
    exit(); 
}

$con = new mysqli("localhost", "root", "", "foodinfo");
if ($con->connect_error) { 
    die("DB Connection Failed: " . $con->connect_error); 
}

// Handle order status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $stmt = $con->prepare("UPDATE orders SET status=? WHERE id=?");
    $stmt->bind_param("si", $_POST['status'], $_POST['order_id']);
    $stmt->execute();
    $stmt->close();
    header("Location:view_orders.php"); 
    exit();
}

// Handle payment verification for online orders
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_payment'], $_POST['txn_id'], $_POST['order_id'])) {
    $stmt = $con->prepare("UPDATE orders SET payment_status='Paid', txn_id=? WHERE id=?");
    $stmt->bind_param("si", $_POST['txn_id'], $_POST['order_id']);
    $stmt->execute();
    $stmt->close();
    header("Location:view_orders.php"); 
    exit();
}

// Fetch all orders with user verification info
$sql = "SELECT o.*, u.name AS user_name, u.verified 
        FROM orders o 
        LEFT JOIN users u ON o.user_id=u.id 
        ORDER BY o.order_date DESC, o.order_time DESC";
$result = $con->query($sql);
if (!$result) { die("Query Failed: " . $con->error); }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>View Orders</title>
<style>
body { font-family: Arial, sans-serif; background:#f7f7f7; padding:20px; }
h2 { text-align:center; margin-bottom:20px; }
table { width:100%; border-collapse: collapse; background:#fff; margin-bottom:20px; }
th, td { border:1px solid #ddd; padding:8px; text-align:center; }
th { background:#333; color:#fff; }
.status-select, input[type=text] { padding:4px; }
.btn { padding:5px 10px; background:#28a745; border:none; color:#fff; cursor:pointer; }
.btn:hover { background:#218838; }
.items-table { width:90%; margin:0 auto; border-collapse:collapse; }
.items-table th, .items-table td { border:1px solid #ccc; padding:5px; }
</style>
</head>
<body>

<h2>All Orders</h2>

<?php if($result->num_rows > 0): ?>
<table>
<tr>
<th>ID</th>
<th>User</th>
<th>Total</th>
<th>Date</th>
<th>Time</th>
<th>Order Type</th>
<th>Payment Method</th>
<th>Payment Status</th>
<th>Status</th>
<th>Update</th>
<th>Items</th>
</tr>

<?php while($order = $result->fetch_assoc()): ?>
<tr>
<td><?= $order['id'] ?></td>
<td><?= htmlspecialchars($order['user_name'] ?? 'Guest') ?></td>
<td><?= number_format($order['total_amount'],2) ?></td>
<td><?= $order['order_date'] ?></td>
<td><?= $order['order_time'] ?></td>
<td><?= $order['order_type'] ?></td>
<td><?= $order['payment_method'] ?></td>
<td>
<?= $order['payment_status'] ?>
<?php if($order['payment_method']==='Online' && $order['payment_status']==='Pending' && $order['verified']==1): ?>
<br>
<form method="post">
<input type="hidden" name="order_id" value="<?= $order['id'] ?>">
<input type="text" name="txn_id" placeholder="Txn ID" required>
<button type="submit" name="verify_payment" class="btn">Verify</button>
</form>
<?php endif; ?>
</td>
<td>
<form method="post">
<input type="hidden" name="order_id" value="<?= $order['id'] ?>">
<select name="status" class="status-select" <?= $order['verified']==0 ? 'disabled' : '' ?>>
<option value="Pending" <?= $order['status']==='Pending'?'selected':'' ?>>Pending</option>
<option value="Delivered" <?= $order['status']==='Delivered'?'selected':'' ?>>Delivered</option>
</select>
</td>
<td><button type="submit" class="btn" <?= $order['verified']==0 ? 'disabled' : '' ?>>Update</button></td>
</form>
<td>
<table class="items-table">
<tr><th>Food ID</th><th>Qty</th><th>Price</th><th>Total</th></tr>
<?php
$itemStmt = $con->prepare("SELECT food_id, quantity, price FROM order_items WHERE order_id=?");
$itemStmt->bind_param("i", $order['id']);
$itemStmt->execute();
$itemsRes = $itemStmt->get_result();
while($item = $itemsRes->fetch_assoc()):
$lineTotal = $item['quantity'] * $item['price'];
?>
<tr>
<td><?= $item['food_id'] ?></td>
<td><?= $item['quantity'] ?></td>
<td><?= number_format($item['price'],2) ?></td>
<td><?= number_format($lineTotal,2) ?></td>
</tr>
<?php endwhile; $itemStmt->close(); ?>
</table>
</td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p>No orders found.</p>
<?php endif; ?>

</body>
</html>
