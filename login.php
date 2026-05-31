<?php
session_start();
require_once 'config/db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, fullname, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            // Secure session setup
            session_regenerate_id(true);
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['verified'] = false; // Will be set true after OTP

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Secure Shop</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="card" style="max-width: 500px; margin: 50px auto;">
            <h2>Login to Your Account</h2>
            
            <?php if($error): ?>
                <div class="alert error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="Password" required>
                
                <button type="submit" class="btn btn-primary" style="width:100%; margin-top:15px;">Login</button>
            </form>
			
			<div style="text-align:center; margin:25px 0;">
				<p>OR</p>
				<a href="google-login.php" class="btn" style="background:#db4437; color:white; font-size:1.1rem;">
					🔵 Login with Google
				</a>
			</div>
            
            <p style="text-align:center; margin-top:15px;">
                Don't have an account? <a href="register.php">Register here</a>
            </p>
        </div>
    </div>
</body>
</html>
