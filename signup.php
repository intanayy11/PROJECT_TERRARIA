<?php
include 'backend/db_config.php';
// Tampilkan pesan error jika ada
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

get_header("Sign Up");
?>
<div class="logo" style="margin-bottom: 20px;">
    <img src="assets/images/Logo.png" alt="Logo Proyek">
</div>

<div class="container" style="max-width: 400px; margin: 100px auto; text-align: center;">
    <div class="kotak_bg">
        <img src="assets/images/first_page.png" alt="Background Image" style="width: 100%; height: auto;">
    </div>
<div class="pixel-form" style="padding: 20px; border: var(--pixel-border) solid var(--color-text); background: linear-gradient(135deg, var(--color-background) 0%, #FFFACD 100%); box-shadow: 4px 4px 0 var(--color-text);">
    <h2>Create Account</h2>
        <?php if ($error): ?>
            <p style="color: red; border: 2px solid red; padding: 5px;"><?= $error ?></p>
        <?php endif; ?>

        <form action="backend/auth.php" method="POST">
            <input type="text" name="nama" placeholder="Nama" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="signup" class="pixel-button" style="width: 100%;">Sign Up</button>
        </form>

        <p style="margin-top: 15px;">Sudah punya akun? <a href="signin.php" style="color: var(--color-text);">Sign In</a></p>
    </div>
</div>

<?php get_footer(); ?>