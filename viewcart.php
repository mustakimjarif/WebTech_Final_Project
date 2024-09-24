<?php
session_start();

// Retrieve cart data from the URL query parameter and decode it from JSON format
$cartData = isset($_GET['cart']) ? json_decode($_GET['cart'], true) : [];

$subtotal = 0;
$shipping = 5; // Fixed shipping cost for demonstration
$total = 0;

if (!empty($cartData)) {
    foreach ($cartData as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    $total = $subtotal + $shipping;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="viewcart.css">
    <title>View Cart</title>
</head>
<body>
    <header>
        <h1>Your Shopping Cart</h1>
    </header>

    <section>
        <table border="1">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($cartData)): ?>
                    <tr>
                        <td colspan="3">Your cart is empty.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($cartData as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="summary">
            <h3>Order Summary</h3>
            <p>Subtotal: $<?php echo number_format($subtotal, 2); ?></p>
            <p>Shipping: $<?php echo number_format($shipping, 2); ?></p>
            <p>Total: $<?php echo number_format($total, 2); ?></p>
        </div>
    </section>

    <footer>
        <button onclick="window.location.href='dashboard.php'">Continue Shopping</button>
    </footer>
</body>
</html>
