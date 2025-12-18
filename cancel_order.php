<?php
session_start();
$con = new mysqli("localhost", "root", "", "foodinfo");

if ($con->connect_error) {
    die("DB Connection Failed: " . $con->connect_error);
}

// user must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; 
$order_id = $_GET['id'] ?? 0;

// validate order belongs to logged in user
$check = $con->prepare("SELECT id FROM orders WHERE id = ? AND user_id = ?");
$check->bind_param("ii", $order_id, $user_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Invalid Order Access!'); window.location='my_orders.php';</script>";
    exit();
}

// cancel order
$update = $con->prepare("UPDATE orders SET status = 'Cancelled' WHERE id = ?");
$update->bind_param("i", $order_id);

if ($update->execute()) {
    echo "<script>alert('Order Cancelled Successfully'); window.location='my_orders.php';</script>";
} else {
    echo "<script>alert('Error cancelling order'); window.location='my_orders.php';</script>";
}

?>
