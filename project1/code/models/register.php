<?php
require_once 'auth.php';
require_once 'sessionauth.php';

$auth = new auth();
$session = new sessionauth();


$success_message = '';
$error_message = '';

if ($_POST) {
    try {
        // Get form data
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Basic validation
        if (empty($username) || empty($email) || empty($password)) {
            throw new Exception('All fields are required');
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format');
        }
        
        if ($password !== $confirm_password) {
            throw new Exception('Passwords do not match');
        }
        
        // Register user with Auth class
        $user = $auth->register($username, $password, $email);
        
        $success_message = "Registration successful! User ID: {$user['id']}. You can now <a href='login.php'>login</a>.";
        
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
    <title>User Registration</title>
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
    </style>
</head>
<body>
    <h1>User Registration</h1>
    <p>Create a new account to access the authentication system.</p>
    
    <?php if ($success_message): ?>
        <div class="success">
            <strong>✅ Success!</strong><br>
            <?= $success_message ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
        <div class="error">
            <strong>⚠️ Registration Failed:</strong><br>
            <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>
    
    <div class="form-container">
        <form method="post">
            <div class="form-group">
                <label><strong>Username:</strong> *</label>
                <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                <div class="help">Choose a unique username (3-20 characters)</div>
            </div>
            
            <div class="form-group">
                <label><strong>Email:</strong> *</label>
                <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                <div class="help">We'll use this for account recovery</div>
            </div>
            
            <div class="form-group">
                <label><strong>Password:</strong> *</label>
                <input type="password" name="password" required>
                <div class="help">At least 8 characters with uppercase, lowercase, number, and a special character.</div>
            </div>
            
            <div class="form-group">
                <label><strong>Confirm Password:</strong> *</label>
                <input type="password" name="confirm_password" required>
                <div class="help">Must match the password above</div>
            </div>
            
            <button type="submit">🚀 Create Account</button>
        </form>
    </div>
    
    <div class="links">
        <p><a href="mainindex.php">← Back to main menu</a></p>
    </div>
    
