<?php
require_once 'config/db.php';
require_once 'includes/auth.php';

// Redirect user to their role dashboard
if ($_SESSION['role'] == 'admin') {
    header("Location: admin/dashboard.php");
    exit();
} elseif ($_SESSION['role'] == 'staff') {
    header("Location: staff/dashboard.php");
    exit();
} else {
    header("Location: customer/dashboard.php");
    exit();
}
?>