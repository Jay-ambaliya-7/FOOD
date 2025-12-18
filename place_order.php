<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "foodinfo");
if (!$con) { die("Connection failed: " . mysqli_connect_error()); }

// Must be logged in and have items in cart
if (!isset($_SESSION['username']) || empty($_SESSION['cart'])) {
    header("Location: menu.php");
    exit();
}

$username = $_SESSION['username'];
$cart = $_SESSION['cart'];

// Force correct structure of cart (auto-fix missing id/quantity)
foreach ($cart as $k => $item) {
    if (!isset($item['id'])) $cart[$k]['id'] = $item['food_id'] ?? 0;
    if (!isset($item['quantity'])) $cart[$k]['quantity'] = 1;
}
$_SESSION['cart'] = $cart;

// Step 1: Show selection form (order type + payment)
if (!isset($_POST['submit_order']) && !isset($_POST['submit_txn'])) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Order Type & Payment</title>
        <style>
            body { font-family: Arial; background:#FFF5E1; display:flex; justify-content:center; align-items:center; height:100vh; }
            .box { background:#fff; padding:30px; border-radius:10px; text-align:center; box-shadow:0 0 10px rgba(0,0,0,0.1);}
            select, button { padding:10px; margin:10px; font-size:16px; border-radius:5px;}
            button { background:#DA291C; color:#FFC72C; border:none; cursor:pointer; font-weight:bold;}
            button:hover { background:#b21a16; }
        </style>
    </head>
    <body>
        <div class="box">
            <h2>Choose Order Type & Payment</h2>
            <form method="POST">
                <label>Order Type:</label><br>
                <select name="order_type" required>
                    <option value="Dine-in">Dine-in</option>
                    <option value="Home Delivery">Home Delivery</option>
                </select><br>

                <label>Payment Method:</label><br>
                <select name="payment_method" required>
                    <option value="COD">Cash on Delivery</option>
                    <option value="Online">Online Payment</option>
                </select><br>

                <button type="submit" name="submit_order">Continue</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit();
}

// Step 2: Save order type + payment method
$order_type = $_POST['order_type'];
$payment_method = $_POST['payment_method'];

$_SESSION['order_type'] = $order_type;
$_SESSION['payment_method'] = $payment_method;

// Step 3: Ask online payment ID
if ($payment_method === "Online" && !isset($_POST['submit_txn'])) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Enter Payment ID</title>
        <style>
            body { font-family: Arial; background:#FFF5E1; display:flex; justify-content:center; align-items:center; height:100vh; }
            .box { background:#fff; padding:30px; border-radius:10px; text-align:center; box-shadow:0 0 10px rgba(0,0,0,0.1);}
            input, button { padding:10px; margin:10px; font-size:16px; border-radius:5px;}
            button { background:#DA291C; color:#FFC72C; border:none; cursor:pointer; font-weight:bold;}
            button:hover { background:#b21a16; }
        </style>
    </head>
    <body>
        <div class="box">
            <h2>Enter Online Payment Transaction ID</h2>
            <form method="POST">
                <input type="text" name="txn_id" placeholder="Enter payment ID" required><br>
                <button type="submit" name="submit_txn">Confirm Payment</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit();
}

// Step 4: Insert final order into DB
$order_type = $_SESSION['order_type'];
$payment_method = $_SESSION['payment_method'];

$payment_status = ($payment_method === "COD") ? "Pending" : "Paid";
$payment_ref = ($payment_method === "Online") ? ($_POST['txn_id'] ?? "") : "";

// Get user_id from users table
$user_query = mysqli_prepare($con, "SELECT id FROM users WHERE name=?");
mysqli_stmt_bind_param($user_query, "s", $username);
mysqli_stmt_execute($user_query);
mysqli_stmt_bind_result($user_query, $user_id);
mysqli_stmt_fetch($user_query);
mysqli_stmt_close($user_query);

if (!$user_id) die("Error: User not found");

// Calculate total price
$total_price = 0;
foreach ($cart as $item) {
    $total_price += ($item['price'] * $item['quantity']);
}

$order_date = date('Y-m-d');
$order_time = date('H:i:s');
$order_status = "Pending";

// Insert into orders
$sql = "INSERT INTO orders (user_id,total_amount,order_date,order_time,status,order_type,payment_method,payment_status,payment_ref)
        VALUES (?,?,?,?,?,?,?,?,?)";

$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "idsssssss", $user_id, $total_price, $order_date, $order_time,
                                       $order_status, $order_type, $payment_method,
                                       $payment_status, $payment_ref);
mysqli_stmt_execute($stmt);
$order_id = mysqli_insert_id($con);
mysqli_stmt_close($stmt);

// Insert items into order_items table
foreach ($cart as $item) {

    $food_id = $item['id'];
    $quantity = $item['quantity'];
    $price = $item['price'];

    $item_sql = "INSERT INTO order_items (order_id, food_id, quantity, price)
                 VALUES (?,?,?,?)";

    $item_stmt = mysqli_prepare($con, $item_sql);
    mysqli_stmt_bind_param($item_stmt, "iiid", $order_id, $food_id, $quantity, $price);
    mysqli_stmt_execute($item_stmt);
    mysqli_stmt_close($item_stmt);
}

// Clear session
unset($_SESSION['cart']);
unset($_SESSION['order_type']);
unset($_SESSION['payment_method']);
$_SESSION['last_bill'] = $order_id;

// Redirect
header("Location: thank_you.php");
exit();
?>
