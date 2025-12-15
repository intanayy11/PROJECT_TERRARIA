<?php
include 'backend/db_config.php';

if (!isset($_SESSION['current_build']['avatar_id'])) {
    header('Location: choose_basic.php'); 
    exit;
}

get_header("Choose Weapon");
get_top_bar("Build Editor");

$weapons_result = $conn->query("SELECT id, name, attack_stat, durability_stat, description FROM weapons");
$weapons = $weapons_result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['continue_weapon'])) {
    $selected_weapon_id = (int)$_POST['weapon_id'];
    
    $_SESSION['current_build']['weapon_id'] = $selected_weapon_id;
    
    header('Location: select_skills.php'); 
    exit;
}
?>

<div class="container">
    <div class="kotak_bg">
        <img src="assets/images/homepage.png" alt="Background Image" style="width: 100%; height: auto;">
    </div>
    <h1 class="weapon-title">Choose Your Weapon</h1><br>
    
    <form action="choose_weapon.php" method="POST" class="pixel-form" style="display: flex; gap: 20px;">
        
        <div style="flex: 1; border: 4px solid var(--color-text); padding: 20px; background-color: var(--color-secondary);">
            <h3 class="weap-title">Weapon Chosen</h3><br>
            
            <div id="weapon_info_display">
                <img id="weapon_img_chosen" src="assets/images/default_weapon.png" alt="Weapon" style="max-width: 250px; height: auto; display: block; margin: 0 auto 10px;"> <br>
                <p id="weapon_name_chosen" style="font-weight: bold; font-size: 1.2em; text-align: center;">Pilih Senjata</p><br>
                <p>Attack: <span id="attack_stat_bar" style="display:inline-block; width:100px; height:10px; background:red;"></span> <span id="attack_stat_val">0</span></p>
                <p>Durability: <span id="durability_stat_bar" style="display:inline-block; width:100px; height:10px; background:green;"></span> <span id="durability_stat_val">0</span></p><br>
                <p id="weapon_desc_chosen"></p>

            </div>
            
            <input type="hidden" name="weapon_id" id="selected_weapon_id" required>
            <a href="choose_basic.php" class="pixel-button" style="margin-top: 15px; margin-right: 110px; text-decoration: none;"> Back (Basic) </a>
            <button type="submit" name="continue_weapon" class="pixel-button" style="margin-top: 15px;">Next (Skills) </button>

        </div>
        
        <div style="flex: 1; border: 4px solid var(--color-text); padding: 10px; background-color: var(--color-secondary);">
            <h3 class="weap-title">Weapon List</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border-bottom: 2px solid var(--color-text); padding: 5px;">Name</th>
                        <th style="border-bottom: 2px solid var(--color-text); padding: 5px;">ATK</th>
                        <th style="border-bottom: 2px solid var(--color-text); padding: 5px;">DUR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($weapons as $weapon): ?>
                    <tr class="weapon-row" data-weapon='<?= json_encode($weapon) ?>' style="cursor: pointer;" onclick="selectWeapon(this)">
                        <td style="padding: 5px;"><?= $weapon['name'] ?></td>
                        <td style="padding: 5px;"><?= $weapon['attack_stat'] ?></td>
                        <td style="padding: 5px;"><?= $weapon['durability_stat'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </form>
</div>

<script>
    function selectWeapon(row) {
        const weapon = JSON.parse(row.getAttribute('data-weapon'));
        
        
        document.getElementById('weapon_name_chosen').innerText = weapon.name;
        document.getElementById('weapon_img_chosen').src = `assets/images/weapon${weapon.id}.png`; 
        document.getElementById('weapon_desc_chosen').innerText = weapon.description;
        
        document.getElementById('attack_stat_val').innerText = weapon.attack_stat;
        document.getElementById('attack_stat_bar').style.width = (weapon.attack_stat > 100 ? 100 : weapon.attack_stat) + 'px';
        document.getElementById('durability_stat_val').innerText = weapon.durability_stat;
        document.getElementById('durability_stat_bar').style.width = (weapon.durability_stat > 100 ? 100 : weapon.durability_stat) + 'px';
        
        document.getElementById('selected_weapon_id').value = weapon.id;

        document.querySelectorAll('.weapon-row').forEach(r => r.style.backgroundColor = 'transparent');
        row.style.backgroundColor = 'var(--color-primary)';
    }

    document.addEventListener('DOMContentLoaded', () => {
        const firstWeaponRow = document.querySelector('.weapon-row');
        if (firstWeaponRow) {
            selectWeapon(firstWeaponRow);
        }
    });
</script>

<?php get_footer(); ?>