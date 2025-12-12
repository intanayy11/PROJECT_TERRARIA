<?php
// backend/db_config.php

// Ganti: Konfigurasi Koneksi Database
$servername = "localhost"; // Gantii
$username = "root"; // Gantii
$password = ""; // Gantii
$dbname = "game_build_db"; // Gantii

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Start Session untuk mengelola login
session_start();

// Ganti: Fungsi get_header, get_top_bar, get_footer (diletakkan di sini, seperti di bagian Front-end)
// ... [CODE FUNGSI get_header(), get_top_bar(), get_footer() DI SINI] ...



// (Disini nanti akan ada konfigurasi DB)

function get_header($title = "Proyek Wireframe Game") {
    echo '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . $title . '</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    ';
}

function get_top_bar($active_page = 'Home') {
    // Menu Dropdown yang akan muncul saat tombol hamburger diklik
    $menu_items = [
        'Home' => 'homepage.php',
        'Maps' => 'maps.php',
        'Avatar Library' => 'avatar_library.php',
        'Build Editor' => 'build_editor.php',
        'Logout' => 'index.php?logout=true' // Ganti: Link logout
    ];

    echo '<div class="top-bar">
        <button class="pixel-button menu-toggle" style="padding: 5px 10px;">☰</button>
        <div class="top-bar-logo">Logo</div> <a href="profile.php" class="pixel-button">Profile</a> </div>
    
    <div class="dropdown-menu" style="display:none; position:absolute; top:50px; left:0; background:var(--color-secondary); border:var(--pixel-border) solid var(--color-text); z-index:100;">
        <ul>';
    foreach ($menu_items as $name => $link) {
        echo '<li><a href="' . $link . '" class="' . ($active_page == $name ? 'active-link' : '') . '">' . $name . '</a></li>'; // Ganti
    }
    echo '</ul>
    </div>';
    
    // Ganti: Tambahkan script.js untuk fungsionalitas menu
    echo '<script>
        document.querySelector(".menu-toggle").addEventListener("click", function() {
            document.querySelector(".dropdown-menu").style.display = (document.querySelector(".dropdown-menu").style.display === "none" ? "block" : "none");
        });
    </script>';
}

function get_footer() {
    echo '
    <script src="assets/js/script.js"></script>
</body>
</html>';
}