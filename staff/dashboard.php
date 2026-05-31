
<?php
require_once '../config/db.php';
require_once '../includes/auth.php';
checkRole(['staff', 'admin']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="navbar">
        <h2 style="color:#3498db;">SecureShop</h2>
        <div class="nav-links">
            <span>Welcome, <?= htmlspecialchars($_SESSION['fullname']) ?> (Staff)</span>
            <a href="../logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="card" style="text-align:center;">
            <h1>🛠️ Staff Dashboard</h1>
            <p style="font-size:1.2rem; margin:20px 0;">Process and manage orders</p>
            
            <div style="margin-top:40px;">
                <a href="orders.php" class="btn btn-primary" style="font-size:1.1rem; padding:18px 50px;">📋 Manage Orders</a>
            </div>
        </div>
    </div>
</body>
</html>

