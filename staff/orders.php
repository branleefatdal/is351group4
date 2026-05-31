<?php
require_once '../config/db.php';
require_once '../includes/auth.php';
checkRole(['staff', 'admin']);

// Update Order Status
if (isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = $_POST['status'];
    
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $order_id);
    $stmt->execute();
    echo "<div class='alert success'>Order status updated!</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Staff</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="navbar">
        <h2 style="color:#3498db;">SecureShop - Staff</h2>
        <div class="nav-links">
            <span>Welcome, <?= htmlspecialchars($_SESSION['fullname']) ?></span>
            <a href="dashboard.php">Dashboard</a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h1>📋 Manage Orders</h1>

            <table style="width:100%; border-collapse:collapse;">
                <tr style="background:#f1f1f1;">
                    <th style="padding:12px;">Order ID</th>
                    <th style="padding:12px;">Customer</th>
                    <th style="padding:12px;">Total</th>
                    <th style="padding:12px;">Date</th>
                    <th style="padding:12px;">Status</th>
                    <th>Action</th>
                </tr>
                <?php
                $result = $conn->query("SELECT o.*, u.fullname FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC");
                while($order = $result->fetch_assoc()):
                ?>
                <tr>
                    <td style="padding:12px;">#<?= $order['id'] ?></td>
                    <td style="padding:12px;"><?= htmlspecialchars($order['fullname']) ?></td>
                    <td style="padding:12px;">$<?= number_format($order['total_price'], 2) ?></td>
                    <td style="padding:12px;"><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                    <td style="padding:12px;"><?= htmlspecialchars($order['status']) ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <select name="status">
                                <option value="Pending" <?= $order['status']=='Pending'?'selected':'' ?>>Pending</option>
                                <option value="Processing" <?= $order['status']=='Processing'?'selected':'' ?>>Processing</option>
                                <option value="Delivered" <?= $order['status']=='Delivered'?'selected':'' ?>>Delivered</option>
                            </select>
                            <button type="submit" name="update_status" class="btn btn-primary" style="padding:6px 12px;">Update</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>