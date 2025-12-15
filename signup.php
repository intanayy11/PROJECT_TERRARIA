<?php
include 'backend/db_config.php';

$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';
unset($_SESSION['error']);
unset($_SESSION['success']);

get_header("Sign Up");
?>
<div class="logo">
    <img src="assets/images/Logo.png" alt="Logo Proyek">
</div>
<div class="kotak_bg">
    <img src="assets/images/first_page.png" alt="Background Image" style="width: 100%; height: auto;">
</div>

<div class="auth-wrapper">
    <div class="pixel-form" style="padding: 20px; border: var(--pixel-border) solid var(--color-text); background: linear-gradient(135deg, var(--color-background) 0%, #FFFACD 100%); box-shadow: 4px 4px 0 var(--color-text);">
        <h2>Create Account</h2><br>

        <?php if ($error): ?>
            <p style="color: red; border: 2px solid red; padding: 5px;"><?= $error ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p style="color: var(--color-accent); border: 2px solid var(--color-accent); padding: 5px;"><?= $success ?></p>
        <?php endif; ?>

        <form action="backend/auth.php" method="POST">
            <input type="text" name="nama" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="signup" class="pixel-button" style="width: 100%;">Sign Up</button>
        </form>

        <p style="margin-top: 15px;">Sudah punya akun? <a href="signin.php" style="color: var(--color-text);">Sign In</a></p>
    </div>
</div>

<?php get_footer(); ?>