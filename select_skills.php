<?php
include 'backend/db_config.php';
// Logika otentikasi

// Pastikan sesi build sudah ada
if (!isset($_SESSION['current_build']['weapon_id'])) {
    // Gantii: Arahkan kembali ke langkah 2 jika sesi hilang
    header('Location: choose_weapon.php'); 
    exit;
}

get_header("Select Skills");
get_top_bar("Build Editor");

// Ambil semua skills
$skills_result = $conn->query("SELECT id, name, description FROM skills");
$all_skills = $skills_result->fetch_all(MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['continue_skills'])) {
    $selected_skills_ids = $_POST['skills'] ?? [];
    
    $_SESSION['current_build']['skills'] = $selected_skills_ids;
    
    // Gantii: Arahkan ke halaman preview
    header('Location: preview_selection.php'); 
    exit;
}
?>

<div class="kotak_bg">
        <img src="assets/images/homepage.png" alt="Background Image" style="width: 100%; height: auto;">
    </div>
<div class="container">
    <h1>Select Skills</h1>
    
    <form action="select_skills.php" method="POST" class="pixel-form" style="display: flex; gap: 20px;">
        
        <div style="flex: 1; border: 4px solid var(--color-text); padding: 20px; background-color: var(--color-secondary);">
            <h3>Current Build Preview</h3>
            
            <div style="text-align: center; margin-bottom: 15px;">
                <img src="assets/images/character<?= $_SESSION['current_build']['avatar_id'] ?>.webp" alt="Avatar" style="max-width: 120px; height: auto; border: 2px solid var(--color-text); display: block; margin: 0 auto 10px;">
                <p style="font-weight: bold;">Class: <?= $_SESSION['current_build']['avatar_name'] ?? 'N/A' ?></p>
            </div>
            
            <h4>Weapon:</h4>
            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                <img src="assets/images/weapon_<?= $_SESSION['current_build']['weapon_id'] ?>.png" alt="Weapon" style="max-width: 80px; height: auto; border: 2px solid var(--color-text); margin-right: 10px;">
                <p>- <?= $_SESSION['current_build']['weapon_name'] ?? 'N/A' ?> (ATK: <?= $_SESSION['current_build']['attack_stat'] ?? 'N/A' ?>)</p>
            </div>
            
            <h4>Skills Selected:</h4>
            <div id="selected_skills_display">
                <p>No skills selected yet.</p>
            </div>
            
            <button type="submit" name="continue_skills" class="pixel-button" style="margin-top: 15px;">Continue</button>
        </div>
        
        <div style="flex: 1; border: 4px solid var(--color-text); padding: 10px; background-color: var(--color-secondary);">
            <h3>Skill List (Pilih > 1)</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border-bottom: 2px solid var(--color-text); padding: 5px;">Pilih</th>
                        <th style="border-bottom: 2px solid var(--color-text); padding: 5px;">Nama Skill</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_skills as $skill): ?>
                    <tr class="skill-row" data-skill='<?= json_encode($skill) ?>' onmouseover="showSkillDetail(this)">
                        <td style="padding: 5px; text-align: center;">
                            <input type="checkbox" name="skills[]" value="<?= $skill['id'] ?>">
                        </td>
                        <td style="padding: 5px;"><?= $skill['name'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </form>
</div>

<script>
    function showSkillDetail(row) {
        const skill = JSON.parse(row.getAttribute('data-skill'));
        
        document.getElementById('skill_name_detail').innerText = skill.name;
        document.getElementById('skill_desc_detail').innerText = skill.description;
    }

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
            const skill = JSON.parse(row.getAttribute('data-skill'));
            skillsList += '<li>' + skill.name + '</li>';
        });
        skillsList += '</ul>';
        
        selectedSkillsDisplay.innerHTML = skillsList;
    }

    // Add event listeners to checkboxes
    document.addEventListener('DOMContentLoaded', () => {
        const checkboxes = document.querySelectorAll('input[name="skills[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedSkills);
        });
        updateSelectedSkills(); // Initial update
    });
</script>

<?php get_footer(); ?>