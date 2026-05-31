<?php
require_once '../config/db.php';
require_once '../includes/auth.php';
checkRole(['customer', 'staff', 'admin']);

// Initialize Cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add to Cart
if (isset($_GET['add']) && is_numeric($_GET['add'])) {
    $product_id = intval($_GET['add']);
    $result = $conn->query("SELECT * FROM products WHERE id = $product_id");
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $_SESSION['cart'][$product_id] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => isset($_SESSION['cart'][$product_id]) ? $_SESSION['cart'][$product_id]['quantity'] + 1 : 1
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - SecureShop</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        .product-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2 style="color:#3498db;">SecureShop</h2>
        <div class="nav-links">
            <span>Welcome, <?= htmlspecialchars($_SESSION['fullname']) ?>!</span>
            <a href="cart.php">🛒 Cart (<?= array_sum(array_column($_SESSION['cart'], 'quantity')) ?>)</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h1>🛒 Our Products</h1>
            
            <div class="product-grid">
                <?php
                $result = $conn->query("SELECT * FROM products WHERE stock > 0");
                while($product = $result->fetch_assoc()):
                ?>
                <div class="product-card">
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p><?= htmlspecialchars($product['description']) ?></p>
                    <p style="font-size:1.4rem; color:#27ae60; font-weight:bold;">
                        $<?= number_format($product['price'], 2) ?>
                    </p>
                    <p>Stock: <?= $product['stock'] ?></p>
                    <a href="?add=<?= $product['id'] ?>" class="btn btn-primary">Add to Cart</a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>
</html>