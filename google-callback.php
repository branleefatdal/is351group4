<?php
session_start();
require_once 'vendor/autoload.php';
require_once 'config/db.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = new Google_Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    $oauth = new Google_Service_Oauth2($client);
    $profile = $oauth->userinfo->get();

    $email = $profile->email;
    $fullname = $profile->name;
    $google_id = $profile->id;

    // Check if user exists
    $stmt = $conn->prepare("SELECT id, fullname, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        // Create new user
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, google_id, role) VALUES (?, ?, ?, 'customer')");
        $stmt->bind_param("sss", $fullname, $email, $google_id);
        $stmt->execute();
        
        $user = ['id' => $conn->insert_id, 'fullname' => $fullname, 'role' => 'customer'];
    }

    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['fullname'] = $user['fullname'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['verified'] = true;

    header("Location: dashboard.php");
    exit();
} else {
    echo "Error: No authorization code received.";
}
?>
