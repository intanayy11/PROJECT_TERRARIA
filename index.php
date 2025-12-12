<?php
// Ganti: Termasuk file konfigurasi dan koneksi database di sini
include 'backend/db_config.php'; 
get_header("Welcome");
?>

<div class="container" style="text-align: center; margin-top: 100px;">
    <div class="top-bar-logo" style="margin-bottom: 50px;">
        <img src="assets/images/logo.png" alt="Logo Proyek" style="width: 150px; height: auto;"> </div>
    
    <div style="display: flex; justify-content: center; gap: 40px;">
        <a href="signup.php" class="pixel-button" style="font-size: 20px;">Sign Up</a> <a href="signin.php" class="pixel-button" style="font-size: 20px;">Sign In</a> </div>
</div>

<?php get_footer(); ?>