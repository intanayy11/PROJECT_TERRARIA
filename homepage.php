<?php
include 'backend/db_config.php';
// Ganti: Logika untuk memastikan user sudah login di sini (misalnya cek session)
// if (!isset($_SESSION['user_id'])) { header('Location: index.php'); exit; } 

get_header("Homepage");
get_top_bar("Home"); // Panggil top bar dengan menu navigasi
?>

<div class="container" style="text-align: center;">
    <h2>Welcome Back!</h2>
    
    <a href="maps.php" class="card-section"> <h3>Maps</h3>
        <p>Explore the Royal Citadel, Arcane Witchspire, and Abyssal Voidrealm.</p>
    </a>
    
    <a href="avatar_library.php" class="card-section"> <h3>Avatar Library</h3>
        <p>View and confirm your selected avatar and loadout.</p>
    </a>
    
    <a href="build_editor.php" class="card-section"> <h3>Build Editor</h3>
        <p>Customize your loadout. Define your playstyle.</p>
    </a>
</div>

<?php get_footer(); ?>