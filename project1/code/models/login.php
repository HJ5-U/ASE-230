<?php
require_once 'auth.php';
require_once 'sessionauth.php';

$auth = new auth();
$session = new sessionauth();

// Check if already logged in
if ($session->is_logged_in()) {
    header('Location: index.php');
    exit;
}

$error_message = '';
$timeout_message = '';

// Check for session timeout
if (isset($_GET['timeout'])) {
    $timeout_message = 'Your session has expired. Please login again.';
}

if ($_POST) {
    try {
        // Get form data
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // Basic validation
        if (empty($username) || empty($password)) {
            throw new Exception('Username and password are required');
        }
        
        // Attempt login with Auth class
        $user = $auth->login($username, $password);
        
        // Login successful - create session
        $session->login_user($user);
        
        // Redirect to main index
        header('Location: index.php');
        exit;
        
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 0 auto; padding: 20px; }
        .error { color: red; background: #ffeeee; padding: 15px; margin: 15px 0; border: 1px solid red; }
        .warning { color: orange; background: #fff8e1; padding: 15px; margin: 15px 0; border: 1px solid orange; }
        .form-group { margin: 15px 0; }
        input { padding: 8px; width: 100%; border: 1px solid #ddd; box-sizing: border-box; }
        button { padding: 10px 20px; background: #007cba; color: white; border: none; cursor: pointer; width: 100%; }
        .form-container { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
        .links { margin: 20px 0; text-align: center; }
        .demo-accounts { background: #f0f8ff; padding: 15px; margin: 20px 0; }
    </style>
</head>
<body>
    <h1>Login</h1>
    <p>Enter your credentials to access your account.</p>
    
    <?php if ($timeout_message): ?>
        <div class="warning">
            <strong>⏰ Session Timeout:</strong><br>
            <?= htmlspecialchars($timeout_message) ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
        <div class="error">
            <strong>⚠️ Login Failed:</strong><br>
            <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>
    
    <div class="form-container">
        <form method="post">
            <div class="form-group">
                <label><strong>Username:</strong></label>
                <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label><strong>Password:</strong></label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit">🔑 Login</button>
        </form>
    </div>
    
    <div class="links">
        <p><a href="register.php">If you don't have an account; please make one here.</a>.</p>
        <p><a href="index.php">← Back to main menu</a></p>
    </div>
</body>
</html>

<?php
?>
