<?php
include 'backend/db_config.php'; 

get_header("Welcome");
?>
<style>
    body {
        padding: 0 !important;
        background: none; 
    }
</style>

<div class="kotak_bg">
    <img src="assets/images/first_page.png" alt="Background Image" style="width: 100%; height: auto;">
</div>

<div class="container-index" style="max-width: 400px; margin: 0 auto; padding-top: 100px; text-align: center;">
    <div class="logo" style="widht=100px; margin-bottom: 30px;">
        <img src="assets/images/Logo.png" alt="Logo Proyek"> 
    </div>
    <h2>Welcome to Terraria Build Editor</h2><br>

    <div class="button_container img" style="display: flex; justify-content: center; margin-bottom: 120px; gap: 40px;">
        <a href="signin.php"><img src="assets/images/SignIn.png" alt="Sign In"></a> 
        <a href="signup.php" ><img src="assets/images/SignUp.png" alt="Sign Up"></a> 
    </div>
</div>

<?php get_footer(); ?>