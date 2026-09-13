<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password-AgriLand Ecosystem</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/auth/Resetpass.css">
</head>
<body>

<div class="reset-container">
    <div class="icon-box">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
    </div>

    <h2>Set New Password</h2>
    <p>Your identity has been verified. Please choose a new secure password to access your account.</p>

    <?php if(isset($_GET['token'])): ?>
        <form action="index.php?url=reset_password&token=<?php echo htmlspecialchars($_GET['token']); ?>" method="POST">
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="password" placeholder="Min. 6 characters" required minlength="6">
            </div>

            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" placeholder="Repeat your password" required minlength="6">
            </div>

            <button type="submit" class="btn-reset">Update Password</button>
        </form>
    <?php else: ?>
        <div style="color: red; padding: 20px; background: #fff5f5; border-radius: 10px;">
            <strong>Error:</strong> No reset token found. Please request a new link from the login page.
        </div>
    <?php endif; ?>

    <a href="index.php?url=login" class="back-to-login">← Back to Sign In</a>
</div>

</body>
</html>