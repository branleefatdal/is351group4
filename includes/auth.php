<?php
// Security Headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Content-Security-Policy: default-src 'self'");

// Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// CSRF Token Generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function checkRole($allowedRoles) {
    if (!in_array($_SESSION['role'], $allowedRoles)) {
        header("Location: ../dashboard.php");
        exit();
    }
}

// Function to validate CSRF
function validateCSRF() {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF Token Validation Failed!");
    }
}
?>