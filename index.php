<?php
// Ganti: Termasuk file konfigurasi dan koneksi database di sini
include 'backend/db_config.php'; 
get_header("Welcome");
?>
<head>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    
    <div class="kotak_bg">
        <img src="assets/images/first_page.png" alt="Background Image" style="width: 100%; height: auto;">
    </div>
        <div class="container-index" style="max-width: 400x; margin: 100px auto; text-align: center;" >
        <div class="logo">
            <img src="assets/images/Logo.png" alt="Logo Proyek"> 
        </div>
        <h1>Welcome to Terraria Build Editor</h1>
    
        <div class="button_container" style="display: flex; justify-content: center; gap: 40px;">
            <a href="signin.php"><img src="assets/images/SignIn.png" alt="Sign In"></a> 
            <a href="signup.php" ><img src="assets/images/SignUp.png" alt="Sign Up"></a> 
        </div>
    </div>
<body>

<?php get_footer(); ?>