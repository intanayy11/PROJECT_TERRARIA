<?php
include 'backend/db_config.php';
// Tampilkan pesan error jika ada
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

get_header("Sign Up");
?>

<div class="container" style="max-width: 400px; margin-top: 50px; text-align: center;">
    <div class="top-bar-logo" style="margin-bottom: 30px;">Logo</div> <div class="pixel-form" style="padding: 20px; border: 4px solid var(--color-text); background-color: var(--color-secondary);">
        <h2>Create Account</h2>

        <?php if ($error): ?>
            <p style="color: red; border: 2px solid red; padding: 5px;"><?= $error ?></p>
        <?php endif; ?>

        <form action="backend/auth.php" method="POST"> <input type="text" name="nama" placeholder="Nama" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            
            <button type="submit" name="signup" class="pixel-button" style="width: 100%;">Sign Up</button> </form>
        
        <p style="margin-top: 15px;">Sudah punya akun? <a href="signin.php" style="color: var(--color-text);">Sign In</a></p> </div>
</div>

<?php get_footer(); ?>