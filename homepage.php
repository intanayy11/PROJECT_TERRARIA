<?php
include 'backend/db_config.php';

get_header("Homepage");
get_top_bar("Home"); 
?>

<body>
    <div class="kotak_bg">
        <img src="assets/images/homepage.png" alt="Background Image" style="width: 100%; height: auto;">
    </div>

    <div class="container_home" style="text-align: center; ">
        
        <div class="homepage-header-area">
            <h1>Welcome Back, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Player') ?>!</h1>
        </div>
        
        <h3 style="color: var(--color-primary);">Choose a feature below to continue your journey</h3> <br><br>

        <div class="container-body-home">
            <div class="spasi-vertical">
                <a href="maps.php" class="card-home"> 
                <img src="assets/images/maps_awal.webp" alt="Maps Icon" style="width: 150px; height: 150px; object-fit: contain; margin-left: 40px; margin-bottom: 10px;">
                <h3>Maps</h3><br>
                <p>Explore the Royal Citadel, Arcane Witchspire, and Abyssal Voidrealm.</p></a>
            </div>
            
            <div class="spasi-vertical">
                <a href="avatar_library.php" class="card-home"> 
                <img src="assets/images/character1.webp" alt="Avatar Library Icon" style="width: 100px; height: 100px; object-fit: contain;  margin-left: 50px; margin-bottom: 10px;">
                <h3>Avatar Library</h3><br>
                <p>View and confirm your selected avatar and loadout.</p></a>
            </div>

            <div class="spasi-vertical">
                <a href="build_editor.php" class="card-home"> 
                <img src="assets/images/icon_build.webp" alt="Build Editor Icon" style="width: 90px; height: 90px; object-fit: contain; margin-left: 70px; margin-bottom: 10px;">
                <h3>Build Editor</h3><br>
                <p>Customize your loadout. Define your playstyle.</p></a>
            </div>
        </div>
</body>

<?php get_footer(); ?>