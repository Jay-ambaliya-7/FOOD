<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Connect to DB
$conn = new mysqli("localhost", "root", "", "foodinfo");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle Add to Cart
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['food_id'])) {
    $food_id = intval($_POST['food_id']);
    $stmt = $conn->prepare("SELECT id, name, price FROM food_menu WHERE id=?");
    $stmt->bind_param("i", $food_id);
    $stmt->execute();
    $item = $stmt->get_result()->fetch_assoc();

    if ($item) {
        $id = $item['id'];
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$id] = [
                "id" => $id,
                "name" => $item['name'],
                "price" => $item['price'],
                "quantity" => 1
            ];
        }
    }

    // If request came via AJAX
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        echo $item['name'] . " added to cart!";
        exit;
    }
}

// Get search query
$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

// Define categories
$categories = [
    "Starters",
    "Soups",
    "Salads",
    "Veg Burgers",
    "Wraps & Rolls",
    "Main Course",
    "Rice & Biryani",
    "Noodles & Pasta",
    "Sides & Snacks",
    "Beverages",
    "Desserts",
    "Combos & Meals"
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Menu - Grill & Bite</title>
<style>
/* same styles as before */
:root {
    --primary: #DA291C;
    --accent: #FFC72C;
    --bg-light: #FFF5E1;
    --white: #fff;
    --dark: #333;
}
body { background-color: var(--bg-light); font-family: Arial,sans-serif; margin:0; padding:0; color:var(--dark); display:flex; flex-direction:column; min-height:100vh; }
.navbar { display:flex; justify-content:space-between; align-items:center; background:var(--primary); padding:15px 20px; flex-wrap:wrap; }
.logo { color: white; font-size:22px; font-weight:bold; }
.nav-links { list-style:none; display:flex; gap:15px; margin:10px 0 0 0; padding:0; flex-wrap: wrap; }
.nav-links a { color:#fff; text-decoration:none; font-weight:bold; transition:.3s; }
.nav-links a:hover { color:var(--accent); }
h1 { text-align:center; color:var(--primary); margin-top:20px; }
.search-form { text-align:center; margin:20px 0; }
.search-form input[type="text"] { padding:8px; width:250px; border-radius:6px; border:1px solid #ccc; font-size:16px; }
.search-form button { padding:8px 12px; border:none; border-radius:6px; background:var(--accent); color:var(--dark); font-weight:bold; cursor:pointer; }
.search-form button:hover { background:#ffb300; }
.category-heading { text-align:center; color:var(--primary); margin-top:30px; font-size:35px; font-weight:bold; border-bottom:2px solid var(--accent); padding-bottom:5px; max-width:260px; margin-left:auto; margin-right:auto; }
.menu-container { display:flex; flex-wrap:wrap; justify-content:center; gap:20px; padding:22px; flex-grow:1; }
.card { background:#fff; width:100%; max-width:400px; border-radius:12px; box-shadow:0 0 12px rgba(0,0,0,0.1); overflow:hidden; border:4px solid var(--accent); transition:.3s; }
.card:hover { transform:scale(1.02); }
.card img { width:100%; height:auto; max-height:300px; object-fit:cover; }
.card-content { padding:16px; }
.card h3 { font-size:24px; margin:10px 0px 8px; color:var(--primary); }
.card .price { font-weight:bold; margin-top:8px; color:var(--primary); font-size:20px; }
.add-btn { margin-top:12px; background:var(--accent); color:var(--dark); border:2px solid black; padding:8px 0; border-radius:12px; cursor:pointer; width:100%; font-size:18px; font-weight:bold; transition:.3s; text-align:center; }
.add-btn:hover { background:#ffb300; }
footer { background:var(--primary); color:var(--accent); text-align:center; padding:12px 10px; font-weight:bold; font-size:13px; margin-top:auto; }
footer a { color:var(--accent); text-decoration:underline; }
footer a:hover { color:#fff; }
#backToTop { position:fixed; bottom:30px; right:30px; display:none; background:var(--primary); color:var(--accent); border:none; padding:10px 14px; border-radius:50%; font-size:18px; cursor:pointer; box-shadow:0 2px 8px rgba(0,0,0,0.3); transition:opacity 0.3s; z-index:100; }
#backToTop:hover { background:#ffb300; }
@media (max-width:600px){ .navbar{flex-direction:column;align-items:flex-start;} .nav-links{flex-direction:column;gap:10px;width:100%;} .card{max-width:100%;} .card img{max-height:250px;} .card h3{font-size:18px;} .card .price{font-size:18px;} .add-btn{font-size:16px;padding:6px 0;} }
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

<h1>Our Menu</h1>

<!-- Search form -->
<div class="search-form">
    <form method="GET" action="menu.php">
        <input type="text" name="search" placeholder="Search food..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>
</div>

<?php
foreach ($categories as $cat) {
    echo "<h2 class='category-heading'>" . htmlspecialchars($cat) . "</h2>";
    echo "<div class='menu-container'>";

    if ($search) {
        $stmt = $conn->prepare("SELECT * FROM food_menu WHERE category = ? AND name LIKE ?");
        $like = "%$search%";
        $stmt->bind_param("ss", $cat, $like);
    } else {
        $stmt = $conn->prepare("SELECT * FROM food_menu WHERE category = ?");
        $stmt->bind_param("s", $cat);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="card">
                <img src="uploads/<?php echo htmlspecialchars($row["image"]); ?>" alt="<?php echo htmlspecialchars($row["name"]); ?>">
                <div class="card-content">
                    <h3><?php echo htmlspecialchars($row["name"]); ?></h3>
                    <div class="price">₹<?php echo number_format($row["price"], 2); ?></div>
                    <form method="POST" action="menu.php" class="add-to-cart-form">
                        <input type="hidden" name="food_id" value="<?php echo htmlspecialchars($row["id"]); ?>">
                        <button type="submit" class="add-btn">Add to Cart</button>
                    </form>
                    <p><?php echo htmlspecialchars($row["description"]); ?></p>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<p style='text-align:center; width:100%;'>No items found in " . htmlspecialchars($cat) . ".</p>";
    }
    echo "</div>";
}
$conn->close();
?>

<button id="backToTop" title="Back to top">↑</button>

<footer>
    &copy; <?php echo date("Y"); ?> Grill & Bite. All rights reserved. &nbsp;|&nbsp; 
    <a href="privacy.php">Privacy Policy</a> &nbsp;|&nbsp; 
    <a href="contact.php">Contact Us</a>
</footer>

<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            fetch('menu.php', {
                method: 'POST',
                body: formData,
                headers: { "X-Requested-With": "XMLHttpRequest" }
            })
            .then(res => res.text())
            .then(msg => { alert(msg); });
        });
    });

    const backToTop = document.getElementById('backToTop');
    window.addEventListener('scroll', () => {
        backToTop.style.display = window.scrollY > 30 ? 'block' : 'none';
    });
    backToTop.addEventListener('click', () => {
        window.scrollTo({top: 0, behavior: 'smooth'});
    });
});
</script>
</body>
</html>
