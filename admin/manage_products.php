<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $target = "../images/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $stmt = $conn->prepare("INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $price, $description, $image]);

        echo "<p style='color:green;'>Product added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Image upload failed!</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Product</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f7fa;
        }

        .container {
            width: 400px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
        }

        input,
        textarea {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: green;
            color: white;
            border: none;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Add Product</h2>

        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Product Name" required>
            <input type="number" step="0.01" name="price" placeholder="Price" required>
            <textarea name="description" placeholder="Description"></textarea>
            <input type="file" name="image" required>

            <button type="submit" name="add_product">Add Product</button>
        </form>

        <a href="manage_products.php">Back</a>
    </div>

</body>

</html>