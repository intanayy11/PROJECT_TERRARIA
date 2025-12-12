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

<div class="container">
    <h1>Select Skills</h1>
    
    <form action="select_skills.php" method="POST" class="pixel-form" style="display: flex; gap: 20px;">
        
        <div style="flex: 1; border: 4px solid var(--color-text); padding: 20px; background-color: var(--color-secondary);">
            <h3>Skill Detail</h3>
            <div id="skill_detail_display">
                <p id="skill_name_detail" style="font-weight: bold; font-size: 1.2em;">Arahkan ke Skill</p>
                <p id="skill_desc_detail">Deskripsi skill akan muncul di sini.</p>
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
</script>

<?php get_footer(); ?>