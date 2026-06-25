<?php
// 1. Always start the session first
session_start();

// 2. Include your database connection
include 'includes/db.php'; 

// 3. Check if the user is logged in (Set the flag)
if (!isset($_SESSION['user_id'])) {
    $is_logged_in = false;
} else {
    $is_logged_in = true;
}

// 4. Fetch products from the database
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Store</title>
    <link rel="stylesheet" href="css/style.css?v=1.8">
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Welcome to Our Store</h1>
            <nav style="display: flex; align-items: center; gap: 15px;">
                
                <?php if ($is_logged_in): ?>
                    <a href="pages/myorders.php" class="orders-link" style="text-decoration: none; color: white; display: flex; align-items: center; gap: 5px;">
                        <span style="font-size: 26px; vertical-align: middle;">📋</span> My Orders
                    </a>
                <?php endif; ?>

                <a href="pages/cart.php" class="cart-link" style="text-decoration: none; color: white; display: inline-flex; align-items: center; gap: 5px; font-weight: 600;">
                  <img src="images/cart-icon.png" alt="Cart" class="cart-icon" style="height: 20px; display: block;">
                   CART
                 </a>

                <?php if ($is_logged_in): ?>
                    <a href="pages/logout.php" class="logout-button" style="text-decoration: none; padding: 5px 10px; background-color: #e74c3c; color: white; border-radius: 4px;">Logout</a>
                <?php else: ?>
                    <a href="pages/login.php">Login</a>
                    <a href="pages/register.php">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <div class="main-container">
        <main style="width: 100%;">
            <h2>Products</h2>
            <div class="product-list">
                <?php if (empty($products)) : ?>
                    <p>No products available.</p>
                <?php else : ?>
                    <?php foreach ($products as $product) : ?>
                        <div class="product">
                            <h3><?= htmlspecialchars($product['name']); ?></h3>
                            
                            <p class="product-price">Price: $<?= number_format($product['price'], 2); ?></p>
                            
                            <p class="product-desc"><?= htmlspecialchars($product['description']); ?></p>
                            
                            <div class="image-container">
                                <?php if (!empty($product['image'])) : ?>
                                    <a href="images/<?= htmlspecialchars($product['image']); ?>" title="Click to view full image" style="display: block; width: 100%; height: 110%;">
                                        <img src="images/<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="product-image">
                                    </a>
                                <?php else: ?>
                                    <div class="no-image">No Image Available</div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="button-wrapper">
                                <?php if ($is_logged_in): ?>
                                    <form method="POST" action="pages/cart.php" style="width: 100%; margin: 0;">
                                        <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                        <button type="submit" name="add_to_cart" class="add-to-cart-button">Add to Cart</button>
                                    </form>
                                <?php else: ?>
                                    <a href="pages/login.php" class="add-to-cart-button" style="display: block; text-align: center; text-decoration: none; box-sizing: border-box;">Login to Add to Cart</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
    <footer>
        <p>&copy; <?= date('Y'); ?> Online Store. All rights reserved.</p>
    </footer>
</body>
</html>