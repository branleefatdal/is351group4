<?php
require_once '../config/db.php';
require_once '../includes/auth.php';
checkRole(['customer', 'staff', 'admin']);

if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - SecureShop</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="navbar">
        <h2 style="color:#3498db;">SecureShop</h2>
        <div class="nav-links">
            <span>Welcome, <?= htmlspecialchars($_SESSION['fullname']) ?>!</span>
            <a href="shop.php">Continue Shopping</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h1>🛒 Your Cart</h1>

            <?php if (empty($_SESSION['cart'])): ?>
                <p>Your cart is empty. <a href="shop.php">Browse products</a></p>
            <?php else: ?>
                <table style="width:100%; border-collapse:collapse;">
                    <tr style="background:#f1f1f1;">
                        <th style="padding:12px; text-align:left;">Product</th>
                        <th style="padding:12px;">Price</th>
                        <th style="padding:12px;">Qty</th>
                        <th style="padding:12px;">Total</th>
                        <th>Action</th>
                    </tr>
                    <?php 
                    $total = 0;
                    foreach($_SESSION['cart'] as $id => $item): 
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td style="padding:12px;"><?= htmlspecialchars($item['name']) ?></td>
                        <td style="padding:12px;">$<?= number_format($item['price'], 2) ?></td>
                        <td style="padding:12px;"><?= $item['quantity'] ?></td>
                        <td style="padding:12px;">$<?= number_format($subtotal, 2) ?></td>
                        <td><a href="?remove=<?= $id ?>" class="btn btn-danger" style="padding:6px 12px; font-size:0.9rem;">Remove</a></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                
                <h2 style="margin-top:30px;">Total: $<?= number_format($total, 2) ?></h2>
                <a href="place_order.php" class="btn btn-primary" style="font-size:1.2rem; padding:16px 40px;">Place Order</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>