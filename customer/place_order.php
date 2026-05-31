<?php
require_once '../config/db.php';
require_once '../includes/auth.php';
checkRole(['customer', 'staff', 'admin']);

if (empty($_SESSION['cart'])) {
    header("Location: shop.php");
    exit();
}

$total = 0;
foreach($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Create Order
$stmt = $conn->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
$stmt->bind_param("id", $_SESSION['user_id'], $total);
$stmt->execute();
$order_id = $stmt->insert_id;

// Add Order Items
foreach($_SESSION['cart'] as $product_id => $item) {
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $order_id, $product_id, $item['quantity']);
    $stmt->execute();
}

// Clear Cart
unset($_SESSION['cart']);

echo "<div class='alert success' style='max-width:600px; margin:50px auto; padding:30px; text-align:center;'>
    <h1>✅ Order Placed Successfully!</h1>
    <p>Order ID: #{$order_id}</p>
    <p>Total: $" . number_format($total, 2) . "</p>
    <a href='orders.php' class='btn btn-primary'>View My Orders</a>
</div>";
?>