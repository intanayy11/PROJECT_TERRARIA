<?php
include 'backend/db_config.php';
// Logika otentikasi

get_header("Build Editor");
get_top_bar("Build Editor");

// Reset sesi build lama saat masuk ke halaman utama editor
unset($_SESSION['current_build']); 
?>

<div class="kotak_bg">
        <img src="assets/images/homepage.png" alt="Background Image" style="width: 100%; height: auto;">
    </div>
<div class="container" style="text-align: center; margin-top: 50px;">
    <h1>Build Editor</h1> <br><br>
    <h2>Customize your loadout. Define your playstyle.</h2>
    
    <div class="button_start" style="margin-top: 40px;" style="font-size: 24px; padding: 15px 30px;">
        <a href="choose_basic.php"> Start Editing </a> 
    </div>
</div>

<?php get_footer(); ?>