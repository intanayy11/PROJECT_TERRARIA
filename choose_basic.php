<?php
include 'backend/db_config.php';

get_header("Choose Basic");
get_top_bar("Build Editor");

$avatars_result = $conn->query("SELECT id, name, basic_skill_info FROM avatars");
$avatars = $avatars_result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['continue_basic'])) {
    $selected_avatar_id = (int)$_POST['avatar_id'];
    
    $_SESSION['current_build'] = [
        'avatar_id' => $selected_avatar_id,
        'weapon_id' => null,
        'skills' => []
    ];
    header('Location: choose_weapon.php'); 
    exit;
}
?>

<div class="container">
    <div class="kotak_bg">
        <img src="assets/images/homepage.png" alt="Background Image" style="width: 100%; height: auto;">
    </div>
    
    <h1 class="Basic-title">Choose Your Basic</h1><br>
    
    <form action="choose_basic.php" method="POST" class="pixel-form" style="display: flex; gap: 20px;">
        
        <div style="flex: 1; text-align: center; border: 4px solid var(--color-text); padding: 20px; background-color: var(--color-secondary);">
            <h3>Basic Avatar</h3><br>
            <div id="avatar_image_display">
                <img id="current_avatar_img" src="assets/images/default_avatar.png" alt="Basic Avatar" style="max-width: 100px; height: auto; display: block; margin: 0 auto;"> </div>
            
            <input type="hidden" name="avatar_id" id="selected_avatar_id" value="<?= $avatars[0]['id'] ?? '' ?>">
            
            <div style="display: flex; justify-content: space-between; margin-top: 10px;">
                <button type="button" class="pixel-button" onclick="prevAvatar()"> < </button>
                <button type="button" class="pixel-button" onclick="nextAvatar()"> > </button>
            </div>

            <button type="submit" name="continue_basic" class="pixel-button" style="margin-top: 15px;">Continue</button>
        </div>
        
        <div style="flex: 1; border: 4px solid var(--color-text); padding: 20px; background-color: var(--color-secondary);">
            <h3 class="Info-title">Basic Skill Info</h3><br><br>
            <p id="avatar_name_display" style="font-weight: bold; font-size: 1.2em;"><?= $avatars[0]['name'] ?? 'Pilih Avatar' ?></p><br>
            <p id="skill_info_display"><?= $avatars[0]['basic_skill_info'] ?? 'Info skill akan muncul di sini.' ?></p>
        </div>
    </form>
</div>

<script>
    const avatarsData = <?= json_encode($avatars) ?>;
    let currentIndex = 0;

    function updateAvatarDisplay() {
        if (avatarsData.length === 0) return;
        const currentAvatar = avatarsData[currentIndex];
        
        document.getElementById('current_avatar_img').src = `assets/images/character_${currentAvatar.id}.png`;
        document.getElementById('selected_avatar_id').value = currentAvatar.id;
        document.getElementById('avatar_name_display').innerText = currentAvatar.name;
        document.getElementById('skill_info_display').innerText = currentAvatar.basic_skill_info;
    }

    function prevAvatar() {
        currentIndex = (currentIndex - 1 + avatarsData.length) % avatarsData.length;
        updateAvatarDisplay();
    }

    function nextAvatar() {
        currentIndex = (currentIndex + 1) % avatarsData.length;
        updateAvatarDisplay();
    }
    
    document.addEventListener('DOMContentLoaded', updateAvatarDisplay);
</script>

<?php get_footer(); ?>