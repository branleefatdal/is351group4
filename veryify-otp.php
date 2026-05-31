
<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entered_otp = $_POST['otp'];

    $stmt = $conn->prepare("SELECT otp_code, otp_expiry FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $user['otp_code'] == $entered_otp && strtotime($user['otp_expiry']) > time()) {
        $_SESSION['verified'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid or expired OTP!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="card" style="max-width: 500px; margin: 80px auto; text-align:center;">
            <h2>Enter OTP</h2>
            <p>Check your email for the 6-digit code</p>
            
            <?php if($error): ?>
                <div class="alert error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="text" name="otp" maxlength="6" placeholder="123456" required style="font-size:1.5rem; text-align:center;">
                <button type="submit" class="btn btn-primary" style="width:100%; margin-top:20px;">Verify OTP</button>
            </form>
        </div>
    </div>
</body>
</html>