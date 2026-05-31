<?php
require_once '../config/db.php';
require_once '../includes/auth.php';
checkRole(['customer', 'staff', 'admin']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - SecureShop</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="navbar">
        <h2 style="color:#3498db;">SecureShop</h2>
        <div class="nav-links">
            <span>Welcome, <?= htmlspecialchars($_SESSION['fullname']) ?>!</span>
            <a href="shop.php">Shop</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h1>📦 My Orders</h1>

            <?php
            $stmt = $conn->prepare("SELECT o.id, o.total_price, o.status, o.created_at 
                                  FROM orders o 
                                  WHERE o.user_id = ? 
                                  ORDER BY o.created_at DESC");
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            ?>

            <?php if ($result->num_rows > 0): ?>
                <table style="width:100%; border-collapse:collapse; margin-top:20px;">
                    <tr style="background:#f1f1f1;">
                        <th style="padding:12px; text-align:left;">Order ID</th>
                        <th style="padding:12px;">Date</th>
                        <th style="padding:12px;">Total</th>
                        <th style="padding:12px;">Status</th>
                    </tr>
                    <?php while($order = $result->fetch_assoc()): ?>
                    <tr>
                        <td style="padding:12px;">#<?= $order['id'] ?></td>
                        <td style="padding:12px;"><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                        <td style="padding:12px;">$<?= number_format($order['total_price'], 2) ?></td>
                        <td style="padding:12px;">
                            <span style="padding:5px 12px; border-radius:20px; background:<?= $order['status']=='Delivered' ? '#27ae60' : '#f39c12' ?>; color:white;">
                                <?= htmlspecialchars($order['status']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>You have no orders yet. <a href="shop.php">Start shopping</a></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>