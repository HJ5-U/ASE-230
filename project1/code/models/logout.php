<?php
require_once 'sessionauth.php';

$session = new sessionauth();

// Check if user was logged in
$was_logged_in = $session->is_logged_in();
$username = $session->get_current_user()['username'] ?? 'User';

// Logout user
$session->logout();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Logged Out</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 0 auto; padding: 20px; text-align: center; }
        .success { color: green; background: #eeffee; padding: 20px; margin: 20px 0; border: 1px solid green; }
        .info { background: #f0f8ff; padding: 15px; margin: 15px 0; }
        .links { margin: 30px 0; }
        .links a { 
            display: inline-block; 
            margin: 10px; 
            padding: 10px 20px; 
            background: #007cba; 
            color: white; 
            text-decoration: none; 
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <?php if ($was_logged_in): ?>
        <div class="success">
            <h2>✅ Logout Successful</h2>
            <p>Goodbye, <?= htmlspecialchars($username) ?>! You have been safely logged out.</p>
        </div>
    <?php else: ?>
        <div class="info">
            <h2>ℹ️ Already Logged Out</h2>
            <p>You are not currently logged in.</p>
        </div>
    <?php endif; ?>
    
    
    <div class="links">
        <a href="login.php">🔑 Login Again</a>
        <a href="register.php">📝 Register New Account</a>
        <a href="index.php">🏠 Main Menu</a>
    </div>
    
    <p><em>Always logout when using shared or public computers!</em></p>
</body>
</html>
