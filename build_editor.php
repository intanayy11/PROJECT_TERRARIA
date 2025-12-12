<?php
include 'backend/db_config.php';
// Logika otentikasi

get_header("Build Editor");
get_top_bar("Build Editor");

// Reset sesi build lama saat masuk ke halaman utama editor
unset($_SESSION['current_build']); 
?>

<div class="container" style="text-align: center; margin-top: 50px;">
    <h1>Build Editor</h1>
    <h2>Customize your loadout. Define your playstyle.</h2>
    
    <a href="choose_basic.php" class="pixel-button" style="font-size: 24px; padding: 15px 30px; margin-top: 40px;">
        Start Editing
    </a> </div>

<?php get_footer(); ?>