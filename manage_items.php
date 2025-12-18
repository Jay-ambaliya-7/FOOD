<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "foodinfo");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

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

// DELETE ITEM
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $imgResult = mysqli_query($con, "SELECT image FROM food_menu WHERE id=$id");
    $imgData = mysqli_fetch_assoc($imgResult);
    if ($imgData && file_exists("uploads/" . $imgData['image'])) {
        unlink("uploads/" . $imgData['image']);
    }

    mysqli_query($con, "DELETE FROM food_menu WHERE id=$id");
    header("Location: manage_items.php");
    exit();
}

// ADD ITEM
if (isset($_POST['add'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = floatval($_POST['price']);
    $desc = mysqli_real_escape_string($con, $_POST['description']);
    $category = mysqli_real_escape_string($con, $_POST['category']);

    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    if (is_uploaded_file($tmp)) {
        // Rename image to avoid duplicates
        $img = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', basename($img));
        move_uploaded_file($tmp, "uploads/" . $img);

        mysqli_query($con, "INSERT INTO food_menu (name, price, description, image, category)
                             VALUES ('$name', '$price', '$desc', '$img', '$category')");
    }
    header("Location: manage_items.php");
    exit();
}

// EDIT ITEM
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = floatval($_POST['price']);
    $desc = mysqli_real_escape_string($con, $_POST['description']);
    $category = mysqli_real_escape_string($con, $_POST['category']);

    if (!empty($_FILES['image']['name'])) {
        $img = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        if (is_uploaded_file($tmp)) {
            // Rename image to avoid duplicates
            $img = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', basename($img));
            move_uploaded_file($tmp, "uploads/" . $img);

            $old = mysqli_fetch_assoc(mysqli_query($con, "SELECT image FROM food_menu WHERE id=$id"));
            if ($old && file_exists("uploads/" . $old['image'])) {
                unlink("uploads/" . $old['image']);
            }
            mysqli_query($con, "UPDATE food_menu SET name='$name', price='$price', description='$desc', image='$img', category='$category' WHERE id=$id");
        }
    } else {
        mysqli_query($con, "UPDATE food_menu SET name='$name', price='$price', description='$desc', category='$category' WHERE id=$id");
    }

    header("Location: manage_items.php");
    exit();
}

$result = mysqli_query($con, "SELECT * FROM food_menu");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Menu - Admin</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f2f5;
            color: #333;
            padding: 20px;
            margin: 0;
            line-height: 1.6;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        h2, h3 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-top: 40px;
        }

        form {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        input[type="text"], input[type="number"], textarea, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: inherit;
            box-sizing: border-box; /* Ensures padding doesn't affect width */
            transition: border-color 0.3s;
        }

        input[type="text"]:focus, input[type="number"]:focus, textarea:focus, select:focus {
            border-color: #3498db;
            outline: none;
        }

        input[type="file"] {
            margin-bottom: 15px;
        }

        button {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            transition: background-color 0.3s;
        }
        
        button[name="add"] {
            background-color: #28a745;
        }

        button[name="add"]:hover {
            background-color: #218838;
        }

        button[name="update"] {
            background-color: #007bff;
        }

        button[name="update"]:hover {
            background-color: #0056b3;
        }

        .edit-form {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            border-radius: 12px;
            overflow: hidden; /* For rounded corners */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        th, td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #343a40;
            color: #fff;
            font-weight: 600;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        .action-links a {
            padding: 6px 10px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s, color 0.3s;
        }

        .action-links .edit {
            color: #007bff;
        }
        
        .action-links .edit:hover {
            background-color: #e9ecef;
        }

        .action-links .delete {
            background-color: #dc3545;
            color: #fff;
        }

        .action-links .delete:hover {
            background-color: #c82333;
        }
        
        .action-links span {
            color: #ced4da;
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🍽️ Manage Menu Items - Admin Panel</h2>
        <p>Use this panel to add, edit, or delete items from your food menu.</p>

        <form method="POST" enctype="multipart/form-data">
            <h3>➕ Add New Item</h3>
            <input type="text" name="name" placeholder="Food Name" required>
            <input type="number" name="price" placeholder="Price ₹" required step="0.01" min="0">
            <textarea name="description" placeholder="Description"></textarea>
            <select name="category" required>
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="file" name="image" required accept="image/*">
            <button type="submit" name="add">➕ Add Item</button>
        </form>
        
        ---

        <h3>📋 Available Items</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>₹ Price</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td>
                        <?= $row['image'] ? "<img src='uploads/" . htmlspecialchars($row['image']) . "' alt='Image'>" : "No image" ?>
                    </td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td>₹<?= number_format($row['price'], 2) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['category']) ?></td>
                    <td class="action-links">
                        <a href="manage_items.php?edit=<?= $row['id'] ?>" class="edit">✏️ Edit</a>
                        <span>|</span>
                        <a class="delete" href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this item?')">🗑️ Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        
        ---

        <?php
        if (isset($_GET['edit'])):
            $edit_id = intval($_GET['edit']);
            $edit_result = mysqli_query($con, "SELECT * FROM food_menu WHERE id=$edit_id");
            $item = mysqli_fetch_assoc($edit_result);
        ?>
        <form method="POST" class="edit-form" enctype="multipart/form-data">
            <h3>✏️ Edit Item ID <?= $item['id'] ?></h3>
            <input type="hidden" name="id" value="<?= $item['id'] ?>">
            <input type="text" name="name" value="<?= htmlspecialchars($item['name']) ?>" required>
            <input type="number" name="price" value="<?= $item['price'] ?>" required step="0.01" min="0">
            <textarea name="description"><?= htmlspecialchars($item['description']) ?></textarea>
            <select name="category" required>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>" <?= ($item['category'] == $cat ? "selected" : "") ?>>
                        <?= htmlspecialchars($cat) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <p>Current Image: <?= $item['image'] ? "<img src='uploads/" . htmlspecialchars($item['image']) . "' width='60' height='60' style='object-fit:cover;'>" : "None" ?></p>
            <input type="file" name="image" accept="image/*">
            <button type="submit" name="update">✔️ Update</button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>