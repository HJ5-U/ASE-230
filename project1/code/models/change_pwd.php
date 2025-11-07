<?php
require_once 'auth.php';
require_once 'sessionauth.php';

$auth = new auth();
$session = new sessionauth();

// Require authentication
$session->require_auth();

// Get current user
$current_user = $session->get_current_user();

$success_message = '';
$error_message = '';

if ($_POST) {
    try {
        // Get form data
        $old_password = $_POST['old_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Basic validation
        if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
            throw new Exception('All fields are required');
        }
        
        if ($new_password !== $confirm_password) {
            throw new Exception('New passwords do not match');
        }
        
        if ($old_password === $new_password) {
            throw new Exception('New password must be different from current password');
        }
        
        // Change password using Auth class
        $auth->change_password($current_user['id'], $old_password, $new_password);
        
        $success_message = 'Password changed successfully! Your new password is now active.';
        
        // Clear form on success
        $_POST = [];
        
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
        .success { color: green; background: #eeffee; padding: 15px; margin: 15px 0; border: 1px solid green; }
        .error { color: red; background: #ffeeee; padding: 15px; margin: 15px 0; border: 1px solid red; }
        .form-group { margin: 15px 0; }
        input { padding: 8px; width: 100%; border: 1px solid #ddd; box-sizing: border-box; }
        button { padding: 10px 20px; background: #007cba; color: white; border: none; cursor: pointer; }
        .form-container { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
        .help { color: #666; font-size: 0.9em; margin-top: 5px; }
        .links { margin: 20px 0; }
        .user-info { background: #f0f8ff; padding: 10px; margin: 15px 0; }
    </style>
</head>
<body>
    <h1>🔑 Change Password</h1>
    
    <div class="user-info">
        <strong>Current User:</strong> <?= htmlspecialchars($current_user['username']) ?>
    </div>
    
    <?php if ($success_message): ?>
        <div class="success">
            <strong>✅ Success!</strong><br>
            <?= htmlspecialchars($success_message) ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
        <div class="error">
            <strong>⚠️ Password Change Failed:</strong><br>
            <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>
    
    <div class="form-container">
        <form method="post">
            <div class="form-group">
                <label><strong>Current Password:</strong> *</label>
                <input type="password" name="old_password" required>
                <div class="help">Enter your current password to verify your identity</div>
            </div>
            
            <div class="form-group">
                <label><strong>New Password:</strong> *</label>
                <input type="password" name="new_password" required>
                <div class="help">At least 8 characters with uppercase, lowercase, and number</div>
            </div>
            
            <div class="form-group">
                <label><strong>Confirm New Password:</strong> *</label>
                <input type="password" name="confirm_password" required>
                <div class="help">Must match the new password above</div>
            </div>
            
            <button type="submit">🔄 Update Password</button>
        </form>
    </div>
    
    <div class="links">
        <p><a href="user_dash.php">← Back to Dashboard</a></p>
    </div>
    
    <h2>💡 Password Security Tips:</h2>
    <div style="background: #f0f8ff; padding: 15px; margin: 20px 0;">
        <h3>Strong Password Requirements:</h3>
        <ul>
            <li><strong>Length:</strong> At least 8 characters (longer is better)</li>
            <li><strong>Uppercase:</strong> At least one capital letter (A-Z)</li>
            <li><strong>Lowercase:</strong> At least one small letter (a-z)</li>
            <li><strong>Numbers:</strong> At least one digit (0-9)</li>
            <li><strong>Special Characters:</strong> Optional but recommended (!@#$%^&* etc.)</li>
        </ul>
        
        <h3>Password Best Practices:</h3>
        <ul>
            <li><strong>Unique:</strong> Don't reuse passwords across different sites</li>
            <li><strong>Complex:</strong> Mix letters, numbers, and symbols</li>
            <li><strong>Memorable:</strong> Use passphrases like "Coffee2Morning!"</li>
            <li><strong>Private:</strong> Never share your password with anyone</li>
        </ul>
    </div>

</body>
</html>
