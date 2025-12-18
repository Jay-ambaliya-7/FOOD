<?php
session_start();

// ---- DB CONNECTION ----
$conn = new mysqli("localhost", "root", "", "foodinfo");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// ---- ADD TO CART ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $id = intval($_POST['add_to_cart']);
    $res = $conn->query("SELECT * FROM food_menu WHERE id=$id");
    if ($res && $res->num_rows) {
        $item = $res->fetch_assoc();
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name'=>$item['name'],
                'price'=>$item['price'],
                'image'=>$item['image'],
                'qty'=>1
            ];
        }
    }
    header("Location: index.php");
    exit;
}

// ---- FETCH PREMIUM ITEMS ----
$items = [];
$q = $conn->query("SELECT * FROM food_menu WHERE price >= 500");
while ($row = $q->fetch_assoc()) $items[] = $row;

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Grill & Bite - Home</title>
<style>
:root{--red:#DA291C;--yellow:#FFC72C;}
body{margin:0;font-family:Arial,sans-serif;background:#fff8e1;display:flex;flex-direction:column;min-height:100vh;}
header{background:var(--red);padding:12px 20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;color:white;}
header .logo{font-weight:800;font-size:20px;}
header nav a{color:white;text-decoration:none;margin:0 10px;font-weight:bold;}
header nav a:hover{text-decoration:underline;}
.hero{display:flex;flex-wrap:wrap;justify-content:center;align-items:center;padding:20px;gap:20px;}
.hero img{width:100%;max-width:450px;border-radius:10px;}
.hero-text{max-width:400px;}
.hero-text h2{color:var(--red);}
.deli {color: red; font-size: 20px; font-weight: bold; white-space: nowrap; text-align: center;}
.slider-container {position: relative; padding:20px; overflow:hidden;}
.slider {display:flex; gap:15px; transition: transform 0.5s ease;}
.card {flex:0 0 calc(33.333% - 10px); /* 3 items per view */ background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.1);padding:10px;text-align:center;}
.card img{width:100%;height:180px;object-fit:cover;border-radius:10px;}
.card h3{color:var(--red);margin:10px 0 5px;}
.price{color:var(--yellow);font-weight:bold;margin-bottom:10px;}
button{background:var(--red);color:#fff;border:none;padding:8px 12px;border-radius:6px;cursor:pointer;margin:4px;}
button:hover{background:#b51e12;}
.prev, .next {background: var(--red); color:white; border:none; font-size:30px; cursor:pointer; border-radius:50%; padding:5px 10px; position:absolute; top:50%; transform:translateY(-50%); z-index:5;}
.prev {left:0;}
.next {right:0;}
footer{background:var(--red);color:white;text-align:center;padding:15px;margin-top:auto;}
.modal{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);display:none;justify-content:center;align-items:center;}
.modal-content{background:#fff;padding:20px;border-radius:10px;max-width:400px;text-align:center;}
.modal-content img{width:100%;border-radius:10px;}
.close{background:#ccc;color:#000;margin-top:10px;}
@media(max-width:900px){.card{flex:0 0 calc(50% - 10px);}} /* 2 items on smaller screens */
@media(max-width:600px){.card{flex:0 0 100%;}} /* 1 item on mobile */
</style>
</head>
<body>

<header>
  <div class="logo">Grill & Bite</div>
  <nav>
    <a href="index.php">Home</a>
    <a href="menu.php">Menu</a>
    <a href="cart.php">Cart</a>
    <a href="login.php">Login</a>
    <a href="logout.php">Logout</a>
    <a href="admin_login.php">Admin</a>
  </nav>
</header>

<section class="hero">
  <div class="hero-text">
    <h2>Our Premium Picks</h2>
    <div class="deli">Delicious Dishes Specially Selected For Food Lovers.</div>
  </div>
  <img src="images/hero-food.jpg" alt="Delicious Food">
</section>

<!-- Slider Section -->
<section class="slider-container">
  <button class="prev" onclick="scrollSlider(-1)">&#10094;</button>
  <div class="slider" id="slider">
    <?php if(count($items) > 0): foreach($items as $it): ?>
      <div class="card">
        <img src="uploads/<?php echo htmlspecialchars($it['image']); ?>" alt="<?php echo htmlspecialchars($it['name']); ?>">
        <h3><?php echo htmlspecialchars($it['name']); ?></h3>
        <div class="price">₹<?php echo number_format($it['price'],2); ?></div>
        <form method="post">
          <button type="submit" name="add_to_cart" value="<?php echo $it['id']; ?>">Add to Cart</button>
          <button type="button" onclick="openModal('<?php echo htmlspecialchars($it['name']); ?>','<?php echo htmlspecialchars($it['image']); ?>','₹<?php echo number_format($it['price'],2); ?>')">Quick View</button>
        </form>
      </div>
    <?php endforeach; else: ?>
      <p style="text-align:center;width:100%;">No premium items available.</p>
    <?php endif; ?>
  </div>
  <button class="next" onclick="scrollSlider(1)">&#10095;</button>
</section>

<!-- Quick View Modal -->
<div class="modal" id="modal">
  <div class="modal-content">
    <img id="mImg" src="" alt="">
    <h3 id="mName"></h3>
    <p id="mPrice"></p>
    <button class="close" onclick="closeModal()">Close</button>
  </div>
</div>

<footer>
  <p>© 2025 Grill & Bite | Made with ❤️</p>
</footer>

<script>
const slider = document.getElementById('slider');
const totalCards = slider.children.length;
let currentIndex = 0;
const itemsPerView = 3;

function scrollSlider(direction){
  currentIndex += direction * itemsPerView;
  if(currentIndex < 0) currentIndex = 0;
  if(currentIndex > totalCards - itemsPerView) currentIndex = totalCards - itemsPerView;
  slider.style.transform = `translateX(-${currentIndex * (slider.children[0].offsetWidth + 15)}px)`;
}

// Auto scroll every 3 seconds
setInterval(() => {
  if(currentIndex >= totalCards - itemsPerView){
    currentIndex = -itemsPerView; // reset to start
  }
  scrollSlider(1);
}, 3000);

function openModal(name,img,price){
  document.getElementById('mName').innerText=name;
  document.getElementById('mPrice').innerText=price;
  document.getElementById('mImg').src="uploads/"+img;
  document.getElementById('modal').style.display="flex";
}

function closeModal(){
  document.getElementById('modal').style.display="none";
}

window.onclick=function(e){
  if(e.target==document.getElementById('modal')) closeModal();
}
</script>

</body>
</html>
