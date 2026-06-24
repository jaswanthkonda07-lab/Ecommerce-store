<?php
// Start the session to access cart items
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f4f4f4; }
        .checkout-container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2, h3 { color: #333; }
        h3 { margin-top: 25px; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        
        /* Payment Section Styling */
        .payment-options { display: flex; gap: 20px; margin-bottom: 15px; flex-wrap: wrap; }
        .radio-label { font-weight: normal; cursor: pointer; display: flex; align-items: center; gap: 5px; }
        .card-details-fields { background: #f9f9f9; padding: 15px; border-radius: 4px; border: 1px solid #ddd; margin-top: 10px; }
        .form-row { display: flex; gap: 10px; }
        .form-row .form-group { flex: 1; }
        
        .btn-order { background-color: #28a745; color: white; padding: 12px; border: none; width: 100%; border-radius: 4px; font-size: 16px; cursor: pointer; margin-top: 15px; }
        .btn-order:hover { background-color: #218838; }
    </style>
</head>
<body>

<div class="checkout-container">
    <h2>Checkout Details</h2>
    <p>Please fill out your shipping information to complete your purchase.</p>
    <hr>
    
    <form action="place_order.php" method="POST">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required placeholder="John Doe">
        </div>
        
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required placeholder="john@example.com">
        </div>
        
        <div class="form-group">
            <label for="address">Shipping Address</label>
            <input type="text" id="address" name="address" required placeholder="123 Main St, Apt 4B">
        </div>
        
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" required placeholder="123-456-7890">
        </div>

        <h3>Payment Method</h3>
        <div class="payment-options">
            <label class="radio-label">
                <input type="radio" name="payment_method" value="credit_card" checked onclick="togglePaymentFields()">
                Credit / Debit Card
            </label>
            <label class="radio-label">
                <input type="radio" name="payment_method" value="paypal" onclick="togglePaymentFields()">
                PayPal
            </label>
            <label class="radio-label">
                <input type="radio" name="payment_method" value="phonepe" onclick="togglePaymentFields()">
                PhonePe
            </label>
        </div>

        <div id="credit-card-details" class="card-details-fields">
            <div class="form-group">
                <label for="card_name">Name on Card</label>
                <input type="text" id="card_name" name="card_name" placeholder="John Doe">
            </div>
            <div class="form-group">
                <label for="card_number">Card Number</label>
                <input type="text" id="card_number" name="card_number" placeholder="1111-2222-3333-4444">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="exp_date">Expiry Date</label>
                    <input type="text" id="exp_date" name="exp_date" placeholder="MM/YY">
                </div>
                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" placeholder="123">
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn-order">Place Order</button>
    </form>
</div>

<script>
function togglePaymentFields() {
    const creditCardRadio = document.querySelector('input[value="credit_card"]');
    const cardFields = document.getElementById('credit-card-details');
    const inputFields = cardFields.querySelectorAll('input');
    
    if (creditCardRadio && creditCardRadio.checked) {
        cardFields.style.display = 'block';
        // Make fields required if Credit Card is selected
        inputFields.forEach(input => input.required = true);
    } else {
        cardFields.style.display = 'none';
        // Remove required attribute so form submits cleanly for alternative methods
        inputFields.forEach(input => {
            input.required = false;
            input.value = ''; // Clears fields when hidden
        });
    }
}

// Run once on page load to initialize required states based on default selection
window.onload = togglePaymentFields;
</script>

</body>
</html>