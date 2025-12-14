<?php
include 'backend/db_config.php';
// Ganti: Logika untuk memastikan user sudah login di sini (misalnya cek session)
// if (!isset($_SESSION['user_id'])) { header('Location: index.php'); exit; } 

get_header("Homepage");
get_top_bar("Home"); // Panggil top bar dengan menu navigasi
?>

<body>
    <div class="kotak_bg">
        <img src="assets/images/homepage.png" alt="Background Image" style="width: 100%; height: auto;">
    </div>

    <div class="container_home" style="text-align: center;">
        <h2>Welcome Back!</h2>
        
        <div class="container-body-home">
            <div class="spasi-vertical">
                <a href="maps.php" class="card-home"> 
                <img src="assets/images/maps_1.png" alt="Maps Icon" style="width: 100px; height: 100px; object-fit: contain; margin-bottom: 10px;">
                <h3>Maps</h3><br>
                <p>Explore the Royal Citadel, Arcane Witchspire, and Abyssal Voidrealm.</p></a>
            </div>
            
            <div class="spasi-vertical">
                <a href="avatar_library.php" class="card-home"> 
                <img src="assets/images/character1.webp" alt="Avatar Library Icon" style="width: 100px; height: 100px; object-fit: contain; margin-bottom: 10px;">
                <h3>Avatar Library</h3><br>
                <p>View and confirm your selected avatar and loadout.</p></a>
            </div>

            <div class="spasi-vertical">
                <a href="build_editor.php" class="card-home"> 
                <img src="assets/images/weapon_1.png" alt="Build Editor Icon" style="width: 100px; height: 100px; object-fit: contain; margin-bottom: 10px;">
                <h3>Build Editor</h3><br>
                <p>Customize your loadout. Define your playstyle.</p></a>
            </div>
        </div>
</body>

<?php get_footer(); ?>