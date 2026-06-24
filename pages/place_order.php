<?php
// 1. Start the session so we can access and clear the cart
session_start();

// 2. Check if the form was actually submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 3. Collect the user's information securely from the form
    // htmlspecialchars prevents malicious script injections
    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $phone   = htmlspecialchars($_POST['phone']);

    /* NOTE: This is where you would normally insert this data into a database.
       For now, we will simulate a successful order processing.
    */

    // 4. Clear the shopping cart session since the order is placed
    unset($_SESSION['cart']); 
    
    // 5. Display a success receipt to the user
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order Success</title>
        <style>
            body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; background-color: #f4f4f4; }
            .success-card { background: white; padding: 40px; max-width: 500px; margin: 0 auto; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
            h1 { color: #28a745; }
            .btn-home { display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; }
            .btn-home:hover { background-color: #0056b3; }
        </style>
    </head>
    <body>

    <div class="success-card">
        <h1>🎉 Order Placed Successfully!</h1>
        <p>Thank you for your purchase, <strong><?php echo $name; ?></strong>!</p>
        <hr>
        <p><strong>Shipping Details:</strong></p>
        <p><?php echo $address; ?></p>
        <p>A confirmation email has been sent to <em><?php echo $email; ?></em>.</p>
        
        <a href="http://localhost/ecommerce/index.php" class="btn-home">Continue Shopping</a>
    </div>

    </body>
    </html>
    <?php

} else {
    // If someone tries to access place_order.php directly without submitting the form, send them back to the shop
    header("Location: index.php");
    exit();
}
?>