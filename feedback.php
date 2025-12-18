<?php
session_start();

// Connect to DB
$conn = new mysqli("localhost", "root", "", "foodinfo");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $feedback = trim($_POST['feedback']);

    if (!empty($name) && !empty($feedback)) {
        $stmt = $conn->prepare("INSERT INTO feedback (name, feedback) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $feedback);

        if ($stmt->execute()) {
            $message = "✅ Thank you for your feedback!";
        } else {
            $message = "❌ Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "⚠️ Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #FFF8E1;
            text-align: center;
            padding: 50px;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            max-width: 400px;
            margin: auto;
        }
        input, textarea {
            width: 90%;
            margin: 10px 0;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            background: #DA291C;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background: #FFC72C;
            color: black;
        }
        .msg {
            margin: 15px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>We Value Your Feedback ❤️</h1>
    <form method="POST">
        <input type="text" name="name" placeholder="Your Name" required><br>
        <textarea name="feedback" rows="4" placeholder="Your Feedback..." required></textarea><br>
        <button type="submit">Submit</button>
    </form>
    <div class="msg"><?php echo $message; ?></div>
</body>
</html>
<?php $conn->close(); ?>
