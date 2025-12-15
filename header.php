<?php
function get_top_bar($page_title = "") {
    $is_logged_in = isset($_SESSION['user_id']);
    $user_name = $_SESSION['user_name'] ?? 'Guest';
    $profile_link = $is_logged_in ? 'profile.php' : 'signin.php';
    $profile_text = $is_logged_in ? 'Profile' : 'Sign In';
    $menu_items = $is_logged_in ? [
        'Dashboard' => 'homepage.php',
        'Avatar Library' => 'avatar_library.php',
        'Build Editor' => 'build_editor.php',
        'World Maps' => 'maps.php',
        'Logout' => 'backend/auth.php?action=logout'
    ] : [
        'Sign Up' => 'signup.php',
        'Sign In' => 'signin.php'
    ];
?>
    <div class="site-header">
        <div class="container logo-main-area">
            <a href="homepage.php"><img src="assets/images/Logo.png" alt="Logo Proyek"></a> 
        </div>

        <nav class="top-bar">
            <div class="side-menu">
                <?php foreach ($menu_items as $text => $link): ?>
                    <a href="<?= $link ?>" class="pixel-button menu-item"><?= $text ?></a>
                <?php endforeach; ?>
            </div>
            
            <nav class="profile-nav" style="margin-left: auto;">
                <a href="<?= $profile_link ?>" class="pixel-button"><?= $profile_text ?></a>
            </nav>
        </nav>
    </div>
<?php
}

?>