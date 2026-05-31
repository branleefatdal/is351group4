<?php
require_once '../config/db.php';
require_once '../includes/auth.php';
checkRole(['admin']);

// Handle Add Product
if (isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $name, $description, $price, $stock);

    if ($stmt->execute()) {
        echo "<div class='alert success'>Product added successfully!</div>";
    } else {
        echo "<div class='alert error'>Failed to add product.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="navbar">
        <h2 style="color:#3498db;">SecureShop - Admin</h2>
        <div class="nav-links">
            <span>Welcome, <?= htmlspecialchars($_SESSION['fullname']) ?></span>
            <a href="dashboard.php">Dashboard</a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h1>📦 Manage Products</h1>

            <!-- Add New Product Form -->
            <h2>Add New Product</h2>
            <form method="POST" action="">
                <input type="text" name="name" placeholder="Product Name" required>
                <input type="text" name="description" placeholder="Description" required>
                <input type="number" name="price" step="0.01" placeholder="Price" required>
                <input type="number" name="stock" placeholder="Stock Quantity" required>
                <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
            </form>

            <hr style="margin:30px 0;">

            <!-- Product List -->
            <h2>Existing Products</h2>
            <table style="width:100%; border-collapse:collapse;">
                <tr style="background:#f1f1f1;">
                    <th style="padding:10px; text-align:left;">Name</th>
                    <th style="padding:10px; text-align:left;">Price</th>
                    <th style="padding:10px; text-align:left;">Stock</th>
                </tr>

                <?php
                $result = $conn->query("SELECT * FROM products");
                while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td style="padding:10px;"><?= htmlspecialchars($row['name']) ?></td>
                    <td style="padding:10px;">$<?= number_format($row['price'], 2) ?></td>
                    <td style="padding:10px;"><?= $row['stock'] ?></td>
                </tr>
                <?php endwhile; ?>

            </table>
        </div>
    </div>
</body>
</html>