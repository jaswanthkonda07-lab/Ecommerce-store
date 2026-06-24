<?php
include '../includes/db.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// 1. Fetch the product details based on the ID passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // If product doesn't exist, send back to manage page
    if (!$product) {
        header("Location: manage_products.php");
        exit();
    }
} else if (!isset($_POST['update_product'])) { 
    // Only redirect if we aren't handling a POST submission
    header("Location: manage_products.php");
    exit();
}

// 2. Handle the form submission to update product details
if (isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    
    // Check if a new image was uploaded
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = "../images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        
        // Update query including the new image
        $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ?, image = ? WHERE id = ?");
        $stmt->execute([$name, $price, $description, $image, $id]);
    } else {
        // Update query keeping the old image
        $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ? WHERE id = ?");
        $stmt->execute([$name, $price, $description, $id]);
    }

    header("Location: manage_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7fa; }
        .container { width: 50%; margin: 50px auto; padding: 30px; background: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        input[type="submit"] { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-size: 16px; }
        input[type="submit"]:hover { background-color: #0056b3; }
        .btn-back { display: block; text-align: center; margin-top: 15px; color: #555; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Product</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $product['id']; ?>">

        <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']); ?>" required>
        </div>

        <div class="form-group">
            <label>Price ($)</label>
            <input type="number" step="0.01" name="price" value="<?= $product['price']; ?>" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4" required><?= htmlspecialchars($product['description']); ?></textarea>
        </div>

        <div class="form-group">
            <label>Product Image (Leave blank to keep current image)</label>
            <input type="file" name="image">
            <p style="font-size: 0.9em; color: #666;">Current: <?= htmlspecialchars($product['image'] ?? 'None'); ?></p>
        </div>

        <input type="submit" name="update_product" value="Update Product">
        <a href="manage_products.php" class="btn-back">Cancel</a>
    </form>
</div>

</body>
</html>