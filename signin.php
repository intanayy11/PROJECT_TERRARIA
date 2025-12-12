<?php
include 'backend/db_config.php';
// Tampilkan pesan error/success
$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';
unset($_SESSION['error']);
unset($_SESSION['success']);

get_header("Sign In");
?>

<div class="container" style="max-width: 400px; margin-top: 50px; text-align: center;">
    <div class="top-bar-logo" style="margin-bottom: 30px;">Logo</div> <div class="pixel-form" style="padding: 20px; border: 4px solid var(--color-text); background-color: var(--color-secondary);">
        <h2>Member Login</h2>

        <?php if ($error): ?>
            <p style="color: red; border: 2px solid red; padding: 5px;"><?= $error ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p style="color: var(--color-accent); border: 2px solid var(--color-accent); padding: 5px;"><?= $success ?></p>
        <?php endif; ?>

        <form action="backend/auth.php" method="POST"> <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            
            <button type="submit" name="signin" class="pixel-button" style="width: 100%;">Sign In</button> </form>
        
        <p style="margin-top: 15px;">Belum punya akun? <a href="signup.php" style="color: var(--color-text);">Sign Up</a></p> </div>
</div>
