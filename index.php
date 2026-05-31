<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IS351 Group 4 - Secure Shop</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="navbar">
        <h2 style="color:#3498db;">SecureShop</h2>
        <div class="nav-links">
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </div>
    </div>

    <div class="container">
        <div class="card" style="text-align:center; padding:60px 40px;">
            <h1>Welcome to Our Secure E-Commerce System</h1>
            <p style="font-size:1.3rem; color:#555; margin:25px 0;">IS351 Group 4 Project</p>
            
            <div style="margin-top:40px;">
                <a href="login.php" class="btn btn-primary" style="font-size:1.2rem; padding:16px 40px;">Login</a>
                <a href="register.php" class="btn btn-primary" style="font-size:1.2rem; padding:16px 40px;">Register</a>
            </div>
        </div>
    </div>
</body>
</html>