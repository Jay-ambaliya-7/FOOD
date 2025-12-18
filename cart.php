<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Connect to DB
$conn = new mysqli("localhost", "root", "", "foodinfo");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// -------------------- ADD ITEM TO CART --------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['food_id'])) {
    $id = $_POST['food_id'];
    $stmt = $conn->prepare("SELECT * FROM food_menu WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $food = $result->fetch_assoc();

    if ($food) {
        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = [
                'id' => $food['id'],
                'name' => $food['name'],
                'price' => $food['price'],
                'quantity' => 1
            ];
        } else {
            if (!isset($_SESSION['cart'][$id]['quantity'])) {
                $_SESSION['cart'][$id]['quantity'] = 1;
            } else {
                $_SESSION['cart'][$id]['quantity']++;
            }
        }
    }
    header("Location: cart.php");
    exit();
}

// -------------------- INCREASE QUANTITY --------------------
if (isset($_GET['increase']) && isset($_SESSION['cart'][$_GET['increase']])) {
    $id = $_GET['increase'];
    if (!isset($_SESSION['cart'][$id]['quantity'])) {
        $_SESSION['cart'][$id]['quantity'] = 1;
    } else {
        $_SESSION['cart'][$id]['quantity']++;
    }
    header("Location: cart.php");
    exit();
}

// -------------------- DECREASE QUANTITY --------------------
if (isset($_GET['decrease']) && isset($_SESSION['cart'][$_GET['decrease']])) {
    $id = $_GET['decrease'];
    if (!isset($_SESSION['cart'][$id]['quantity'])) {
        $_SESSION['cart'][$id]['quantity'] = 1;
    } elseif ($_SESSION['cart'][$id]['quantity'] > 1) {
        $_SESSION['cart'][$id]['quantity']--;
    }
    header("Location: cart.php");
    exit();
}

// -------------------- REMOVE SINGLE ITEM --------------------
if (isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header("Location: cart.php");
    exit();
}

// -------------------- CLEAR ENTIRE CART --------------------
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <style>
        :root {
            --primary: #DA291C;
            --accent: #FFC72C;
            --bg-light: #FFF5E1;
            --white: #fff;
            --dark: #333;
        }
        body { background-color: var(--bg-light); font-family: Arial, sans-serif; margin:0; padding:0; color:var(--dark); min-height:100vh; display:flex; flex-direction:column; }
        .navbar { display:flex; justify-content:space-between; align-items:center; background-color:var(--primary); padding:15px 30px; }
        .logo { color:white; font-size:26px; font-weight:bold; }
        .nav-links { list-style:none; display:flex; gap:20px; margin:0; padding:0; }
        .nav-links a { color:var(--white); text-decoration:none; font-weight:bold; transition:color 0.3s; }
        .nav-links a:hover { color:var(--accent); }
        h1 { color:var(--primary); margin:30px auto 20px auto; text-align:center; font-weight:bold; font-size:2rem; }
        table { width:80%; max-width:900px; background-color:var(--white); border-collapse:collapse; box-shadow:0 0 15px rgba(0,0,0,0.1); border-radius:10px; overflow:hidden; margin:0 auto 40px auto; }
        th, td { padding:15px 20px; text-align:center; border-bottom:1px solid #ddd; color:var(--dark); }
        th { background-color:var(--primary); color:var(--accent); font-weight:bold; text-transform:uppercase; font-size:1rem; }
        td { font-size:1rem; }
        .actions a { margin:0 8px; padding:8px 12px; background-color:var(--accent); color:var(--dark); font-weight:bold; text-decoration:none; border-radius:6px; transition:background-color 0.3s ease; display:inline-block; min-width:30px; user-select:none; }
        .actions a:hover { background-color:#ffdb4d; }
        td a { background-color:var(--primary); color:var(--accent); font-weight:bold; padding:8px 14px; border-radius:6px; text-decoration:none; transition:background-color 0.3s ease; display:inline-block; }
        td a:hover { background-color:#b21a16; }
        footer { background-color:var(--primary); color:var(--accent); padding:20px 30px; text-align:center; font-weight:bold; margin-top:auto; }
        .footer { margin-top:20px; text-align:center; width:80%; max-width:900px; display:flex; justify-content:center; gap:20px; margin-left:auto; margin-right:auto; }
        .footer a { background-color:var(--primary); color:var(--accent); font-weight:bold; padding:12px 25px; border-radius:8px; text-decoration:none; transition:background-color 0.3s ease; display:inline-block; min-width:130px; text-align:center; }
        .footer a:hover { background-color:#b21a16; }
        .checkout { background-color:var(--accent); color:var(--dark); }
        .checkout:hover { background-color:#ffdb4d; }
        @media (max-width:768px) {
            table { width:95%; }
            .footer { flex-direction:column; gap:15px; width:95%; }
            .footer a { min-width:auto; padding:12px; }
            .navbar { flex-direction:column; gap:10px; padding:15px 20px; }
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
            <li><a href="logout.php">Logout</a></li>
            <li><a href="admin_login.php">Admin</a></li>
        </ul>
    </div>
</header>

<h1>🛒 Your Cart</h1>

<?php if (!empty($_SESSION['cart'])): ?>
    <table>
        <tr>
            <th>Item</th>
            <th>Price (₹)</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Actions</th>
        </tr>
        <?php
        $total = 0;
        foreach ($_SESSION['cart'] as $id => $item):
            $quantity = isset($item['quantity']) ? $item['quantity'] : 1;
            $subtotal = $item['price'] * $quantity;
            $total += $subtotal;
        ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= number_format($item['price'], 2) ?></td>
            <td>
                <div class="actions">
                    <a href="?decrease=<?= $id ?>">−</a>
                    <?= $quantity ?>
                    <a href="?increase=<?= $id ?>">+</a>
                </div>
            </td>
            <td><?= number_format($subtotal, 2) ?></td>
            <td>
                <a href="?remove=<?= $id ?>">Remove</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <th colspan="3">Total</th>
            <th colspan="2">₹ <?= number_format($total, 2) ?></th>
        </tr>
    </table>

    <div class="footer">
        <a href="?clear">Clear Cart</a>
        <a href="menu.php">Back to Menu</a>
        <a href="place_order.php" class="checkout">Place Order</a>
    </div>

<?php else: ?>
    <p style="text-align:center; font-size:18px;">Your cart is empty.</p>
    <div style="text-align:center; margin-top:20px;">
        <a href="menu.php">Browse Menu</a>
    </div>
<?php endif; ?>

<footer>
    &copy; <?= date('Y') ?> Grill & Bite. All rights reserved.
</footer>

</body>
</html>
