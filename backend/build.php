<?php
// backend/build.php
include 'db_config.php';

// Pastikan user sudah login sebelum melakukan build
if (!isset($_SESSION['user_id'])) {
    // Gantii: Arahkan ke halaman login jika belum login
    header('Location: ../index.php'); 
    exit;
}

$user_id = $_SESSION['user_id'];

// Logika Menyimpan Build dari Preview Selection Page
if (isset($_POST['save_build'])) {
    $character_name = $conn->real_escape_string($_POST['character_name']);
    $avatar_id = (int)$_POST['selected_avatar_id'];
    $weapon_id = (int)$_POST['selected_weapon_id'];
    $selected_skills = $_POST['selected_skills'] ?? [];
    $insert_skills_ok = true; // Flag untuk status penyimpanan skill

    // 1. Simpan ke user_builds (Initial Insert)
    // is_active akan diurus setelah ini
    $sql_build = "INSERT INTO user_builds (user_id, character_name, avatar_id, weapon_id, is_active) 
                  VALUES ($user_id, '$character_name', $avatar_id, $weapon_id, FALSE)";

    if ($conn->query($sql_build) === TRUE) {
        $build_id = $conn->insert_id;

        // 2. Simpan skills ke build_skills
        foreach ($selected_skills as $skill_id) {
            $skill_id = (int)$skill_id;
            $sql_skill = "INSERT INTO build_skills (build_id, skill_id) VALUES ($build_id, $skill_id)";
            if ($conn->query($sql_skill) !== TRUE) {
                $insert_skills_ok = false;
                break; // Hentikan jika ada error
            }
        }
        
        // --- LOGIKA SET AKTIF BARU ---
        if ($insert_skills_ok) {
            // A. Set SEMUA build user ke is_active = FALSE
            $conn->query("UPDATE user_builds SET is_active = FALSE WHERE user_id = $user_id");

            // B. Set build yang baru saja dibuat ke is_active = TRUE
            $conn->query("UPDATE user_builds SET is_active = TRUE WHERE id = $build_id");

            $_SESSION['success'] = "Build **{$character_name}** berhasil disimpan dan diaktifkan!";
            // Gantii: Arahkan ke avatar_library.php
            header('Location: ../avatar_library.php'); 
            exit; 
        } else {
            // Rollback (hapus build yang sudah terbuat jika skill gagal)
            $conn->query("DELETE FROM user_builds WHERE id = $build_id");
            $_SESSION['error'] = "Gagal menyimpan skills. Build dibatalkan.";
            // Gantii: Arahkan kembali ke preview_selection.php
            header('Location: ../preview_selection.php'); 
            exit;
        }
    } else {
        $_SESSION['error'] = "Gagal menyimpan Build utama: " . $conn->error;
        // Gantii: Arahkan kembali ke preview_selection.php
        header('Location: ../preview_selection.php'); 
        exit;
    }
}


// Logika untuk Mengaktifkan Build dari Avatar Library (Saat tombol 'Confirm' diklik)
if (isset($_POST['set_active'])) {
    $build_to_activate_id = (int)$_POST['set_active_build_id'];

    // Cek kepemilikan (PENTING untuk keamanan)
    $check_ownership = $conn->query("SELECT user_id FROM user_builds WHERE id = $build_to_activate_id AND user_id = $user_id")->fetch_assoc();
    
    // Perbaikan: Cek kepemilikan sudah langsung dimasukkan ke query
    if ($check_ownership) { 
        // 1. Set SEMUA build user ke is_active = FALSE
        $conn->query("UPDATE user_builds SET is_active = FALSE WHERE user_id = $user_id");

        // 2. Set build yang dipilih ke is_active = TRUE
        $conn->query("UPDATE user_builds SET is_active = TRUE WHERE id = $build_to_activate_id");

        // Gantii: Arahkan kembali ke avatar_library.php
        header('Location: ../avatar_library.php'); 
        exit;
    } else {
        $_SESSION['error'] = "Aksi tidak valid atau Build tidak ditemukan.";
        // Gantii: Arahkan kembali ke avatar_library.php
        header('Location: ../avatar_library.php'); 
        exit;
    }
}
?>