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
    <style>
        /* Ensures the text and image inside the Cart link line up perfectly */
        .cart-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            color: white;
            font-weight: 600;
        }

        /* Standardizes the cart image vertical alignment and size bounds */
        .cart-icon {
            height: 22px;
            width: auto;
            display: inline-block;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px;">
            <h1>Welcome to Our Store</h1>
            
            <nav style="display: flex; align-items: center; gap: 20px;">
                
                <?php if ($is_logged_in): ?>
                    <a href="pages/myorders.php" class="orders-link" style="text-decoration: none; color: white; display: inline-flex; align-items: center; gap: 6px; font-weight: 600;">
                        <span style="font-size: 20px; line-height: 1;">📋</span> MY ORDERS
                    </a>
                <?php endif; ?>

                <a href="pages/cart.php" class="cart-link">
                    <img src="images/cart-icon.png" alt="Cart" class="cart-icon"> CART
                </a>

                <?php if ($is_logged_in): ?>
                    <a href="pages/logout.php" class="logout-button" style="text-decoration: none; padding: 6px 14px; background-color: #e74c3c; color: white; border-radius: 4px; font-weight: bold; font-size: 14px;">LOGOUT</a>
                <?php else: ?>
                    <a href="pages/login.php" style="color: white; text-decoration: none; font-weight: 600;">Login</a>
                    <a href="pages/register.php" style="color: white; text-decoration: none; font-weight: 600;">Register</a>
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