<?php
require_once 'auth.php';
require_once 'sessionauth.php';

$auth = new auth();
$session = new sessionauth();

// Require authentication
$session->require_auth();

// Get current user
$current_user = $session->get_current_user();
$user_details = $auth->find_user_by_id($current_user['id']);

$success_message = '';
$error_message = '';

if ($_POST) {
    try {
        // Get form data
        $email = trim($_POST['email'] ?? '');
        
        // Basic validation
        if (empty($email)) {
            throw new Exception('Email is required');
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format');
        }
        
        // Update profile using Auth class
        $updated_user = $auth->update_profile($current_user['id'], [
            'email' => $email
        ]);
        
        $success_message = 'Profile updated successfully!';
        
        // Refresh user details
        $user_details = $auth->find_user_by_id($current_user['id']);
        
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
        .success { color: green; background: #eeffee; padding: 15px; margin: 15px 0; border: 1px solid green; }
        .error { color: red; background: #ffeeee; padding: 15px; margin: 15px 0; border: 1px solid red; }
        .form-group { margin: 15px 0; }
        input { padding: 8px; width: 100%; border: 1px solid #ddd; box-sizing: border-box; }
        input[readonly] { background: #f5f5f5; }
        button { padding: 10px 20px; background: #007cba; color: white; border: none; cursor: pointer; }
        .form-container { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
        .help { color: #666; font-size: 0.9em; margin-top: 5px; }
        .links { margin: 20px 0; }
        .user-info { background: #f0f8ff; padding: 15px; margin: 15px 0; }
        .readonly-info { background: #fff8e1; padding: 10px; margin: 10px 0; border-left: 4px solid orange; }
    </style>
</head>
<body>
    <h1>👤 Update Profile</h1>
    
    <div class="user-info">
        <h3>Current Profile Information</h3>
        <p><strong>Username:</strong> <?= htmlspecialchars($user_details['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user_details['email'] ?? 'Not set') ?></p>
        <p><strong>Member Since:</strong> <?= date('F j, Y', strtotime($user_details['created_at'])) ?></p>
        <p><strong>Last Updated:</strong> <?= isset($user_details['updated_at']) ? date('F j, Y g:i A', strtotime($user_details['updated_at'])) : 'Never' ?></p>
    </div>
    
    <?php if ($success_message): ?>
        <div class="success">
            <strong>✅ Success!</strong><br>
            <?= htmlspecialchars($success_message) ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
        <div class="error">
            <strong>⚠️ Update Failed:</strong><br>
            <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>
    
    <div class="form-container">
        <h3>Edit Profile</h3>
        <form method="post">
            <div class="form-group">
                <label><strong>Username:</strong></label>
                <input type="text" value="<?= htmlspecialchars($user_details['username']) ?>" readonly>
                <div class="help">Username cannot be changed for security reasons</div>
            </div>
            
            <div class="form-group">
                <label><strong>Email:</strong> *</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user_details['email'] ?? '') ?>" required>
                <div class="help">Valid email address for account recovery</div>
            </div>
            
            <div class="form-group">
                <label><strong>User ID:</strong></label>
                <input type="text" value="<?= $user_details['id'] ?>" readonly>
                <div class="help">Unique identifier - cannot be changed</div>
            </div>
            
            <button type="submit">💾 Update Profile</button>
        </form>
    </div>
    
    <div class="links">
        <p><a href="change_pwd.php">🔑 Change Password</a></p>
        <p><a href="user_dash.php">← Back to Dashboard</a></p>
    </div>
</body>
</html>