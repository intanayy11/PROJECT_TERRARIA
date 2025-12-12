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

<div class="container">
    <h1>Preview Selection</h1>
    
    <form action="backend/build.php" method="POST" class="pixel-form" style="display: flex; gap: 20px;">
        
        <div style="flex: 2; border: 4px solid var(--color-text); padding: 20px; background-color: var(--color-secondary);">
            <h3>Build Summary</h3>
            
            <p style="font-size: 1.5em; margin-bottom: 20px; font-weight: bold;">Class: <?= $avatar_detail['name'] ?? 'N/A' ?></p>
            
            <h4>Weapon:</h4>
            <p>- <?= $weapon_detail['name'] ?? 'N/A' ?> (ATK: <?= $weapon_detail['attack_stat'] ?? 'N/A' ?>)</p>

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
        </div>
        
        <div style="flex: 1; text-align: right;">
            <input type="hidden" name="selected_avatar_id" value="<?= $build_data['avatar_id'] ?>">
            <input type="hidden" name="selected_weapon_id" value="<?= $build_data['weapon_id'] ?>">
            <?php foreach ($build_data['skills'] as $skill_id): ?>
                <input type="hidden" name="selected_skills[]" value="<?= $skill_id ?>">
            <?php endforeach; ?>

            <input type="text" name="character_name" placeholder="Enter character name" required style="width: 100%;">
            
            <button type="submit" name="save_build" class="pixel-button" style="margin-top: 10px; width: 100%;">Save Build</button> </div>
    </form>
</div>

<?php get_footer(); ?>