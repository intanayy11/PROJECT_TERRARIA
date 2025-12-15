<?php
include 'backend/db_config.php';

if (!isset($_SESSION['user_id'])) { 
    header('Location: index.php'); 
    exit;
}

if (!isset($_SESSION['current_build']['weapon_id']) || !isset($_SESSION['current_build']['avatar_id'])) {
    header('Location: choose_weapon.php'); 
    exit;
}

get_header("Select Skills");
get_top_bar("Build Editor");

$build_data = $_SESSION['current_build'];

$avatar_detail = ['name' => 'N/A'];
$weapon_detail = ['name' => 'N/A', 'attack_stat' => 'N/A'];

if ($build_data['avatar_id'] > 0) {
    $avatar_id = (int)$build_data['avatar_id'];
    $avatar_result = $conn->query("SELECT name FROM avatars WHERE id = $avatar_id");
    if ($avatar_result && $avatar_result->num_rows > 0) {
        $avatar_detail = $avatar_result->fetch_assoc();
    }
}

if ($build_data['weapon_id'] > 0) {
    $weapon_id = (int)$build_data['weapon_id'];
    $weapon_result = $conn->query("SELECT name, attack_stat FROM weapons WHERE id = $weapon_id");
    if ($weapon_result && $weapon_result->num_rows > 0) {
        $weapon_detail = $weapon_result->fetch_assoc();
    }
}

$skills_result = $conn->query("SELECT id, name, description FROM skills");
$all_skills = $skills_result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['continue_skills'])) {
    $selected_skills_ids = $_POST['skills'] ?? [];
    
    $_SESSION['current_build']['skills'] = $selected_skills_ids;
    
    header('Location: preview_selection.php'); 
    exit;
}

$previously_selected_skills = $_SESSION['current_build']['skills'] ?? [];

?>

<div class="kotak_bg">
    <img src="assets/images/homepage.png" alt="Background Image" style="width: 100%; height: auto;">
</div>
<div class="container">
    <h1 class="skills-title">Select Skills</h1><br>
    
    <form action="select_skills.php" method="POST" class="pixel-form" style="display: flex; gap: 20px;">
        
        <div style="flex: 1; border: 4px solid var(--color-text); padding: 20px; background-color: var(--color-secondary); box-shadow: var(--pixel-shadow);">
            <h3 class="select-title">Current Build Preview</h3><br>
            
            <div style="text-align: center; margin-bottom: 15px;">
                <img src="assets/images/character_<?= $build_data['avatar_id'] ?? 'default' ?>.png" 
                     alt="Avatar" 
                     style="max-width: 120px; height: auto; display: block; margin: 0 auto 10px;">
                <p style="font-weight: bold;">Class: <?= htmlspecialchars($avatar_detail['name'] ?? 'N/A') ?></p>
            </div>
            
            <h4>Weapon:</h4><br>
            <div style="display: flex; align-items: center; margin-bottom: 10px; justify-content: center;">
                <?php if (isset($build_data['weapon_id']) && $build_data['weapon_id'] > 0): ?>
                    <img src="assets/images/weapon<?= $build_data['weapon_id'] ?>.png" 
                         alt="Weapon" 
                         style="max-width: 50px; height: auto; ; margin-right: 10px;">
                <?php endif; ?>
                <p>- <?= htmlspecialchars($weapon_detail['name'] ?? 'N/A') ?> (ATK: <?= htmlspecialchars($weapon_detail['attack_stat'] ?? 'N/A') ?>)</p>
            </div>
            
            
            <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                <a href="choose_weapon.php" class="pixel-button" style="text-decoration: none;"> 
                    Back (Weapon) 
                </a>
                <button type="submit" name="continue_skills" class="pixel-button">
                    Next (Preview) 
                </button>
            </div>
        </div>
<div style="flex: 1; border: 4px solid var(--color-text); padding: 10px; background-color: var(--color-secondary); box-shadow: var(--pixel-shadow); display: flex; flex-direction: column;">
    
    <h3 class="select-title">Skill List</h3><br>
    <h5 class="select-title"> - Pilih Skill Lebih dari Satu -</h5><br>

    <div style="overflow-y: auto; max-height: 400px; flex-grow: 1;"> 
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border-bottom: 2px solid var(--color-text); padding: 5px; width: 10%;">Pilih</th>
                    <th style="border-bottom: 2px solid var(--color-text); padding: 5px; width: 30%;">Skill</th>
                    <th style="border-bottom: 2px solid var(--color-text); padding: 5px; text-align: left;">Deskripsi</th> </tr>
            </thead>
            <tbody>
                <?php foreach ($all_skills as $skill): ?>
                <tr class="skill-row">
                    <td style="padding: 5px; text-align: center; ">
                        <input type="checkbox" name="skills[]" value="<?= $skill['id'] ?>"
                               <?= in_array($skill['id'], $previously_selected_skills) ? 'checked' : '' ?>>
                    </td>
                    <td style="padding: 5px; font-size: 10px;"><?= htmlspecialchars($skill['name']) ?></td>
                    <td style="padding: 5px; font-size: 10px;"><?= htmlspecialchars($skill['description']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div> 
    <br>
</div>
    
<script>
    function updateSelectedSkills() {
        const checkboxes = document.querySelectorAll('input[name="skills[]"]:checked');
        const selectedSkillsDisplay = document.getElementById('selected_skills_display');
        
        if (checkboxes.length === 0) {
            selectedSkillsDisplay.innerHTML = '<p>No skills selected yet.</p>';
            return;
        }
        
        let skillsList = '<ul>';
        checkboxes.forEach(checkbox => {
            const row = checkbox.closest('.skill-row');
            
            if (row) {
                const skill = JSON.parse(row.getAttribute('data-skill')); 
                skillsList += '<li>- ' + skill.name + '</li>'; 
            }
        });
        skillsList += '</ul>';
        
        selectedSkillsDisplay.innerHTML = skillsList;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const checkboxes = document.querySelectorAll('input[name="skills[]"]');
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedSkills);
        });
        
        updateSelectedSkills(); 
    });
</script>

<?php get_footer(); ?>