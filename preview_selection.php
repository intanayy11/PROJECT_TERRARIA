<?php
include 'backend/db_config.php';

if (!isset($_SESSION['current_build']['skills'])) {
    header('Location: select_skills.php'); 
    exit;
}

get_header("Preview Selection");
get_top_bar("Build Editor");

$build_data = $_SESSION['current_build'];

$avatar_detail = $conn->query("SELECT name FROM avatars WHERE id = " . (int)$build_data['avatar_id'])->fetch_assoc();
$weapon_detail = $conn->query("SELECT name, attack_stat FROM weapons WHERE id = " . (int)$build_data['weapon_id'])->fetch_assoc();

$skills_details = [];
if (!empty($build_data['skills'])) {
    $skill_ids = implode(',', array_map('intval', $build_data['skills']));
    $skills_result = $conn->query("SELECT id, name, description FROM skills WHERE id IN ($skill_ids)");
    while ($row = $skills_result->fetch_assoc()) {
        $skills_details[] = $row;
    }
}
?>
<div class="kotak_bg">
        <img src="assets/images/homepage.png" alt="Background Image" style="width: 100%; height: auto;">
    </div>
<div class="container" style="max-width: 1000px;">
    <h1 class="preview-title">Preview Selection</h1> <br>
    
    <form action="backend/build.php" method="POST" class="pixel-form">
        <div style="border: 4px solid var(--color-text); padding: 20px; background-color: var(--color-secondary); max-width: 800px; margin: 0 auto;">
            <h3 class="build-title">Build Summary</h3>
            
            <div style="text-align: center; margin-bottom: 20px;">
                <img src="assets/images/character_<?= $build_data['avatar_id'] ?>.png" alt="Avatar" style="max-width: 150px; height: auto; display: block; margin: 0 auto 10px;">
                <p style="font-size: 1.5em; font-weight: bold;">Class: <?= $avatar_detail['name'] ?? 'N/A' ?></p>
            </div>
            
            <h4>Weapon:</h4>
            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                <img src="assets/images/weapon<?= $build_data['weapon_id'] ?>.png" alt="Weapon" style="max-width: 100px; height: auto; margin-right: 10px;">
                <p>- <?= $weapon_detail['name'] ?? 'N/A' ?> (ATK: <?= $weapon_detail['attack_stat'] ?? 'N/A' ?>)</p>
            </div>

            <h4>Skills:</h4><br>
            <?php if (empty($skills_details)): ?>
                <p>Tidak ada skill dipilih.</p>
            <?php else: ?>
                <?php foreach ($skills_details as $skill): ?>
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <img src="assets/images/skill<?= $skill['id'] ?>.png" alt="Skill" style="max-width: 80px; height: auto; margin-right: 10px;">
                        <div>
                            <p style="font-weight: bold; margin: 0;">- <?= $skill['name'] ?></p><br>
                            <p style="font-size: 0.9em; margin: 0;"><?= $skill['description'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <hr style="margin: 20px 0; border: 1px solid var(--color-text);">
            
            <input type="hidden" name="selected_avatar_id" value="<?= $build_data['avatar_id'] ?>">
            <input type="hidden" name="selected_weapon_id" value="<?= $build_data['weapon_id'] ?>">
            <?php foreach ($build_data['skills'] as $skill_id): ?>
                <input type="hidden" name="selected_skills[]" value="<?= $skill_id ?>">
            <?php endforeach; ?>

            <input type="text" name="character_name" placeholder="Enter character name" required style="width: 100%; margin-bottom: 10px;">
            
            <a href="select_skills.php" class="pixel-button" style="margin-top: 15px; margin-left: 100px; margin-right: 130px; text-decoration: none; "> Back (Skills) </a>
            <button type="submit" name="save_build" class="pixel-button" style=" flex; justify-content: space-between; margin-top: 12px;;">Save Build</button>
            
        </form>
    </div>
</div>
        

<?php get_footer(); ?>