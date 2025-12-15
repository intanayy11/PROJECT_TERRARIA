<?php
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php'); 
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['save_build'])) {
    $character_name = $conn->real_escape_string($_POST['character_name']);
    $avatar_id = (int)$_POST['selected_avatar_id'];
    $weapon_id = (int)$_POST['selected_weapon_id'];
    $selected_skills = $_POST['selected_skills'] ?? [];
    $insert_skills_ok = true; 

    $sql_build = "INSERT INTO user_builds (user_id, character_name, avatar_id, weapon_id, is_active) 
                  VALUES ($user_id, '$character_name', $avatar_id, $weapon_id, FALSE)";

    if ($conn->query($sql_build) === TRUE) {
        $build_id = $conn->insert_id;

        foreach ($selected_skills as $skill_id) {
            $skill_id = (int)$skill_id;
            $sql_skill = "INSERT INTO build_skills (build_id, skill_id) VALUES ($build_id, $skill_id)";
            if ($conn->query($sql_skill) !== TRUE) {
                $insert_skills_ok = false;
                break;
            }
        }
    
        if ($insert_skills_ok) {
            $conn->query("UPDATE user_builds SET is_active = FALSE WHERE user_id = $user_id");

            $conn->query("UPDATE user_builds SET is_active = TRUE WHERE id = $build_id");

            $_SESSION['success'] = "Build **{$character_name}** berhasil disimpan dan diaktifkan!";
            header('Location: ../avatar_library.php'); 
            exit; 
        } else {
            $conn->query("DELETE FROM user_builds WHERE id = $build_id");
            $_SESSION['error'] = "Gagal menyimpan skills. Build dibatalkan.";
            header('Location: ../preview_selection.php'); 
            exit;
        }
    } else {
        $_SESSION['error'] = "Gagal menyimpan Build utama: " . $conn->error;
        header('Location: ../preview_selection.php'); 
        exit;
    }
}

if (isset($_POST['set_active'])) {
    $build_to_activate_id = (int)$_POST['set_active_build_id'];
    $check_ownership = $conn->query("SELECT user_id FROM user_builds WHERE id = $build_to_activate_id AND user_id = $user_id")->fetch_assoc();
    
    if ($check_ownership) { 
        $conn->query("UPDATE user_builds SET is_active = FALSE WHERE user_id = $user_id");
        $conn->query("UPDATE user_builds SET is_active = TRUE WHERE id = $build_to_activate_id");
        header('Location: ../avatar_library.php'); 
        exit;
    } else {
        $_SESSION['error'] = "Aksi tidak valid atau Build tidak ditemukan.";
        header('Location: ../avatar_library.php'); 
        exit;
    }
}
?>