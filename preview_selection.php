<?php
include 'backend/db_config.php';
// Logika otentikasi

// Pastikan semua sesi build sudah ada
if (!isset($_SESSION['current_build']['skills'])) {
    // Gantii: Arahkan kembali ke langkah 3 jika sesi hilang
    header('Location: select_skills.php'); 
    exit;
}

get_header("Preview Selection");
get_top_bar("Build Editor");

$build_data = $_SESSION['current_build'];

// Ambil detail dari database
$avatar_detail = $conn->query("SELECT name FROM avatars WHERE id = " . (int)$build_data['avatar_id'])->fetch_assoc();
$weapon_detail = $conn->query("SELECT name, attack_stat FROM weapons WHERE id = " . (int)$build_data['weapon_id'])->fetch_assoc();

$skill_names = [];
if (!empty($build_data['skills'])) {
    $skill_ids = implode(',', array_map('intval', $build_data['skills']));
    $skills_result = $conn->query("SELECT name FROM skills WHERE id IN ($skill_ids)");
    while ($row = $skills_result->fetch_assoc()) {
        $skill_names[] = $row['name'];
    }
}
?>
<div class="kotak_bg">
        <img src="assets/images/homepage.png" alt="Background Image" style="width: 100%; height: auto;">
    </div>
<div class="container">
    <h1>Preview Selection</h1>
    
    <form action="backend/build.php" method="POST" class="pixel-form">
        
        <div style="border: 4px solid var(--color-text); padding: 20px; background-color: var(--color-secondary); max-width: 800px; margin: 0 auto;">
            <h3>Build Summary</h3>
            
            <div style="text-align: center; margin-bottom: 20px;">
                <img src="assets/images/character<?= $build_data['avatar_id'] ?>.webp" alt="Avatar" style="max-width: 150px; height: auto; border: 2px solid var(--color-text); display: block; margin: 0 auto 10px;">
                <p style="font-size: 1.5em; font-weight: bold;">Class: <?= $avatar_detail['name'] ?? 'N/A' ?></p>
            </div>
            
            <h4>Weapon:</h4>
            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                <img src="assets/images/weapon_<?= $build_data['weapon_id'] ?>.png" alt="Weapon" style="max-width: 100px; height: auto; border: 2px solid var(--color-text); margin-right: 10px;">
                <p>- <?= $weapon_detail['name'] ?? 'N/A' ?> (ATK: <?= $weapon_detail['attack_stat'] ?? 'N/A' ?>)</p>
            </div>

            <h4>Skills:</h4>
            <ul>
            <?php if (empty($skill_names)): ?>
                <li>Tidak ada skill dipilih.</li>
            <?php else: ?>
                <?php foreach ($skill_names as $name): ?>
                    <li>- <?= $name ?></li>
                <?php endforeach; ?>
            <?php endif; ?>
            </ul>
            
            <hr style="margin: 20px 0; border: 1px solid var(--color-text);">
            
            <input type="hidden" name="selected_avatar_id" value="<?= $build_data['avatar_id'] ?>">
            <input type="hidden" name="selected_weapon_id" value="<?= $build_data['weapon_id'] ?>">
            <?php foreach ($build_data['skills'] as $skill_id): ?>
                <input type="hidden" name="selected_skills[]" value="<?= $skill_id ?>">
            <?php endforeach; ?>

            <input type="text" name="character_name" placeholder="Enter character name" required style="width: 100%; margin-bottom: 10px;">
            
            <button type="submit" name="save_build" class="pixel-button" style="width: 100%;">Save Build</button>
        </div>
    </form>
</div>

<?php get_footer(); ?>