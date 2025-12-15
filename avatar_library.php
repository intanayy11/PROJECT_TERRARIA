<?php
include 'backend/db_config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); 
    exit;
}

get_header("Avatar Library");
get_top_bar("Avatar Library");

$user_id = (int)$_SESSION['user_id'];
$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['success']);
unset($_SESSION['error']);

$all_builds_query = "
    SELECT 
        ub.id AS build_id, ub.character_name, ub.is_active,ub.is_active, ub.avatar_id,
        a.name AS avatar_name,
        w.name AS weapon_name, w.attack_stat, w.durability_stat,
        GROUP_CONCAT(s.name SEPARATOR ', ') AS skill_names
    FROM user_builds ub
    JOIN avatars a ON ub.avatar_id = a.id
    JOIN weapons w ON ub.weapon_id = w.id
    LEFT JOIN build_skills bs ON ub.id = bs.build_id
    LEFT JOIN skills s ON bs.skill_id = s.id
    WHERE ub.user_id = $user_id
    GROUP BY ub.id
    
";
$all_builds_query = "
    SELECT 
        ub.id AS build_id, ub.character_name, ub.is_active, ub.avatar_id, ub.weapon_id,
        a.name AS avatar_name,
        w.name AS weapon_name, w.attack_stat, w.durability_stat,
        GROUP_CONCAT(DISTINCT s.name SEPARATOR ', ') AS skill_names,
        GROUP_CONCAT(DISTINCT s.id SEPARATOR ',') AS skill_ids
    FROM user_builds ub
    JOIN avatars a ON ub.avatar_id = a.id
    JOIN weapons w ON ub.weapon_id = w.id
    LEFT JOIN build_skills bs ON ub.id = bs.build_id
    LEFT JOIN skills s ON bs.skill_id = s.id
    WHERE ub.user_id = $user_id
    GROUP BY ub.id
    ORDER BY ub.is_active DESC, ub.id DESC
";
$builds_result = $conn->query($all_builds_query);
$all_builds = $builds_result->fetch_all(MYSQLI_ASSOC);

$active_build = array_filter($all_builds, function($build) {
    return $build['is_active'] == 1;
});
$active_build = reset($active_build); 

if (!$active_build && !empty($all_builds)) {
    $active_build = $all_builds[0];
}
?>

<div class="container">
    <div class="kotak_bg">
        <img src="assets/images/homepage.png" alt="Background Image" style="width: 100%; height: auto;">
    </div>
    <h1 class="avatar-title">Avatar Library</h1><br>
    
    <?php if ($success): ?>
        <p style="color: var(--color-text); border: 2px solid var(--color-accent); padding: 5px;"><?= $success ?></p>
    <?php endif; ?>
    <?php if ($error): ?>
        <p style="color: red; border: 2px solid red; padding: 5px;"><?= $error ?></p>
    <?php endif; ?><br>

    <div style="display: flex; gap: 20px;">
        
        <div style="flex: 1; border: 4px solid var(--color-text); padding: 20px; background-color: var(--color-secondary);">
            <h3 class="build-title">Active Loadout: <?= $active_build['character_name'] ?? 'No Active Build' ?></h3>
            
            <?php if ($active_build): ?>
                <div style="text-align: center; margin-bottom: 15px;">
                    <img id="active_avatar_img" src="assets/images/character_<?= $active_build['avatar_id'] ?? '1' ?>.png" alt="Active Avatar" style="max-width: 150px; height: auto; display: block; margin: 0 auto;">
                </div>

                <h4>Base Class: <?= $active_build['avatar_name'] ?></h4><br>
                <h4>Weapon:</h4>
                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                    <?php if (isset($active_build['weapon_id'])): ?>
                        <img src="assets/images/weapon<?= $active_build['weapon_id'] ?>.png" alt="Weapon" style="max-width: 100px; height: auto; margin-right: 10px;">
                        <p>— <?= $active_build['weapon_name'] ?? 'N/A' ?> (ATK: <?= $active_build['attack_stat'] ?? 'N/A' ?>)</p>
                    <?php else: ?>
                        <p>No weapon selected.</p>
                    <?php endif; ?>
                </div>
                
                <h4>Skills:</h4>
                <?php 
                $skill_names_arr = explode(', ', $active_build['skill_names'] ?? '');
                $skill_ids_arr = explode(',', $active_build['skill_ids'] ?? '');
                ?>
                
                <?php if (!empty($skill_ids_arr) && $skill_ids_arr[0] != ''): ?>
                    <?php foreach ($skill_ids_arr as $index => $s_id): ?>
                        <div style="display: flex; align-items: center; margin-bottom: 5px;">
                            <img src="assets/images/skill<?= $s_id ?>.png" alt="Skill" style="max-width: 50px; height: auto; margin-right: 10px;">
                            <p>— <?= $skill_names_arr[$index] ?? 'Skill' ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>— None</p>
                <?php endif; ?>

            <?php else: ?>
                <p>Silakan buat avatar baru melalui <a href="build_editor.php">Build Editor</a>.</p>
            <?php endif; ?>
        </div>
        
        <div style="flex: 2; border: 4px solid var(--color-text); padding: 10px; background-color: var(--color-secondary);">
            <h3 class="build-title">Saved Build List</h3>
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9em;">
                <thead>
                    <tr>
                        <th style="border-bottom: 2px solid var(--color-text); padding: 5px;">Character Name</th>
                        <th style="border-bottom: 2px solid var(--color-text); padding: 5px;">Base Class</th>
                        <th style="border-bottom: 2px solid var(--color-text); padding: 5px;">Weapon</th>
                        <th style="border-bottom: 2px solid var(--color-text); padding: 5px;">Skills</th> <th style="border-bottom: 2px solid var(--color-text); padding: 5px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($all_builds)): ?>
                        <tr><td colspan="5" style="text-align: center;">Belum ada build yang disimpan.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($all_builds as $build): ?>
                    <tr style="<?= $build['is_active'] ? 'background-color: var(--color-primary);' : '' ?>">
                        <td style="padding: 5px;"><?= $build['character_name'] ?> <?= $build['is_active'] ? ' (A)' : '' ?></td>
                        <td style="padding: 5px;"><?= $build['avatar_name'] ?></td>
                        <td style="padding: 5px;"><?= $build['weapon_name'] ?></td>
                        <td style="padding: 5px; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= $build['skill_names'] ?? 'None' ?>">
                            <?= $build['skill_names'] ?? 'None' ?>
                        </td> <td style="padding: 5px;">
                            <?php if (!$build['is_active']): ?>
                                <form action="backend/build.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="set_active_build_id" value="<?= $build['build_id'] ?>">
                                    <button type="submit" name="set_active" class="pixel-button" style="padding: 5px 10px;">Confirm</button>
                                </form>
                            <?php else: ?>
                                Active
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

<?php get_footer(); ?>