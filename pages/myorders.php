<?php
session_start();
include '../includes/db.php';

// If a guest tries to access this page directly, boot them to login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user orders (Adjust table/column names if yours are named differently)
try {
    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC");
    $stmt->execute(['user_id' => $user_id]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Fallback if your database table isn't created yet
    $orders = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .orders-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            font-family: Arial, sans-serif;
        }
        .empty-message {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
            font-size: 18px;
        }
        .order-card {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f8fafc;
        }
        .back-home {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #3498db;
        }
    </style>
</head>
<body>

    <div class="orders-container">
        <a href="../index.php" class="back-home">← Back to Store</a>
        <h2>Your Order History</h2>
        
        <?php if (empty($orders)): ?>
            <div class="empty-message">
                <p>🛒 You have not ordered any product yet.</p>
            </div>
        <?php else: ?>
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <h4>Order #<?= htmlspecialchars($order['id']); ?></h4>
                    <p>Total Paid: $<?= number_format($order['total_price'] ?? 0, 2); ?></p>
                    <p>Status: <span style="color: #2ecc71; font-weight: bold;"><?= htmlspecialchars($order['status'] ?? 'Processed'); ?></span></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</body>
</html>