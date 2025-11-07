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

// Handle user activation/deactivation
if ($_POST) {
    try {
        $action = $_POST['action'] ?? '';
        $user_id = $_POST['user_id'] ?? '';
        
        if (empty($action) || empty($user_id)) {
            throw new Exception('Invalid request parameters');
        }
        
        // Prevent users from deactivating themselves
        if ($user_id == $current_user['id'] && $action === 'deactivate') {
            throw new Exception('You cannot deactivate your own account');
        }
        
        if ($action === 'activate') {
            $auth->activate_user($user_id);
            $success_message = "User activated successfully!";
        } elseif ($action === 'deactivate') {
            $auth->deactivate_user($user_id);
            $success_message = "User deactivated successfully!";
        } else {
            throw new Exception('Invalid action specified');
        }
        
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Get user statistics and all users
$user_stats = $auth->get_user_stats();
$all_users = $auth->get_all_users(true); // Include inactive users
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 0 auto; padding: 20px; }
        .success { color: green; background: #eeffee; padding: 15px; margin: 15px 0; border: 1px solid green; }
        .error { color: red; background: #ffeeee; padding: 15px; margin: 15px 0; border: 1px solid red; }
        .stats { background: #f0f8ff; padding: 15px; margin: 15px 0; border: 1px solid #007cba; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin: 15px 0; }
        .stat-card { background: white; padding: 15px; border: 1px solid #ddd; text-align: center; }
        .stat-number { font-size: 2em; font-weight: bold; color: #007cba; }
        .users-table { background: #f9f9f9; padding: 20px; margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #007cba; color: white; }
        .status-active { color: green; font-weight: bold; }
        .status-inactive { color: red; font-weight: bold; }
        .action-btn { padding: 5px 10px; margin: 2px; border: none; cursor: pointer; text-decoration: none; display: inline-block; border-radius: 3px; }
        .btn-activate { background: #28a745; color: white; }
        .btn-deactivate { background: #dc3545; color: white; }
        .btn-disabled { background: #6c757d; color: white; cursor: not-allowed; }
        .links { margin: 20px 0; }
        .user-info { background: #fff8e1; padding: 10px; margin: 15px 0; }
    </style>
</head>
<body>
    <h1>👥 User Management</h1>
    
    <div class="user-info">
        <strong>Current User:</strong> <?= htmlspecialchars($current_user['username']) ?> (ID: <?= $current_user['id'] ?>)
    </div>
    
    <?php if ($success_message): ?>
        <div class="success">
            <strong>✅ Success!</strong><br>
            <?= htmlspecialchars($success_message) ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
        <div class="error">
            <strong>⚠️ Action Failed:</strong><br>
            <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>
    
    <div class="stats">
        <h2>📊 User Statistics</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?= $user_stats['total_users'] ?></div>
                <div>Total Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $user_stats['active_users'] ?></div>
                <div>Active Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $user_stats['inactive_users'] ?></div>
                <div>Inactive Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $user_stats['recent_registrations'] ?></div>
                <div>New This Week</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $user_stats['recent_logins'] ?></div>
                <div>Logged In Today</div>
            </div>
        </div>
    </div>
    
    <div class="users-table">
        <h2>👤 All Users</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Registered</th>
                    <th>Last Login</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['email'] ?? 'Not set') ?></td>
                    <td>
                        <?php if ($user['is_active']): ?>
                            <span class="status-active">✅ Active</span>
                        <?php else: ?>
                            <span class="status-inactive">❌ Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td><?= date('M j, Y', strtotime($user['created_at'])) ?></td>
                    <td>
                        <?php if (isset($user['last_login'])): ?>
                            <?= date('M j, Y g:i A', strtotime($user['last_login'])) ?>
                        <?php else: ?>
                            Never
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($user['id'] == $current_user['id']): ?>
                            <span class="action-btn btn-disabled">Self</span>
                        <?php else: ?>
                            <?php if ($user['is_active']): ?>
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="action" value="deactivate">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <button type="submit" class="action-btn btn-deactivate" 
                                            onclick="return confirm('Are you sure you want to deactivate this user?')">
                                        🚫 Deactivate
                                    </button>
                                </form>
                            <?php else: ?>
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="action" value="activate">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <button type="submit" class="action-btn btn-activate">
                                        ✅ Activate
                                    </button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="links">
        <p><a href="index.php">← Back to Main Menu</a></p>
    </div>
</body>
</html>