<?php
include 'backend/db_config.php';
// Logika otentikasi

get_header("Edit Profile");
get_top_bar("Profile");

$user_data = [];
$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';
unset($_SESSION['error']);
unset($_SESSION['success']);

// Ambil data user
if (isset($_SESSION['user_id'])) {
    $user_id = (int)$_SESSION['user_id'];
    $sql = "SELECT nama, email, profile_photo FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $user_data = $result->fetch_assoc();
    }
}

// Handle Update Profile
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_profile'])) {
    $new_nama = $conn->real_escape_string($_POST['nama']);
    $new_email = $conn->real_escape_string($_POST['email']);
    $new_password = $_POST['password'];

    $update_fields = [];
    $update_fields[] = "nama = '$new_nama'";
    $update_fields[] = "email = '$new_email'";

    if (!empty($new_password)) {
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        $update_fields[] = "password_hash = '$new_password_hash'";
    }

    // Handle profile photo upload
    if (isset($_FILES['profile_photo_upload']) && $_FILES['profile_photo_upload']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['profile_photo_upload']['tmp_name'];
        $file_name = basename($_FILES['profile_photo_upload']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_ext, $allowed_ext)) {
            $new_file_name = 'profile_' . $user_id . '.' . $file_ext;
            $upload_path = 'assets/images/' . $new_file_name;

            if (move_uploaded_file($file_tmp, $upload_path)) {
                $update_fields[] = "profile_photo = '$upload_path'";
            } else {
                $_SESSION['error'] = "Gagal upload foto profil.";
                header('Location: profile.php');
                exit;
            }
        } else {
            $_SESSION['error'] = "Format file tidak didukung. Gunakan JPG, PNG, atau GIF.";
            header('Location: profile.php');
            exit;
        }
    }

    $update_sql = "UPDATE users SET " . implode(', ', $update_fields) . " WHERE id = $user_id";

    if ($conn->query($update_sql) === TRUE) {
        $_SESSION['user_name'] = $new_nama; // Update session name
        $_SESSION['success'] = "Profil berhasil diupdate!";
        // Gantii: Redirect untuk refresh data dan pesan
        header('Location: profile.php'); 
    } else {
        $_SESSION['error'] = "Gagal mengupdate profil: " . $conn->error;
        // Gantii: Redirect untuk refresh data dan pesan
        header('Location: profile.php'); 
    }
    exit;
}
?>

<div class="container">
    <div class="kotak_bg">
        <img src="assets/images/homepage.png" alt="Background Image" style="width: 100%; height: auto;">
    </div>
    <h1>Edit Profile</h1>

    <?php if ($error): ?>
        <p style="color: red; border: 2px solid red; padding: 5px;"><?= $error ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color: var(--color-accent); border: 2px solid var(--color-accent); padding: 5px;"><?= $success ?></p>
    <?php endif; ?>

    <form action="profile.php" method="POST" class="pixel-form" enctype="multipart/form-data" style="display: flex; gap: 20px;">
        
        <div style="flex: 1; text-align: center;">
            <div style="width: 150px; height: 150px; border-radius: 50%; background-color: var(--color-primary); margin: 0 auto 15px;">
                <img id="profile_img" src="<?= $user_data['profile_photo'] ?? 'assets/images/default_profile.png' ?>" alt="Profile Photo" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;"> </div>
            <input type="file" name="profile_photo_upload" id="profile_photo_upload" accept="image/*" style="display: none;">
            <label for="profile_photo_upload" class="pixel-button" style="padding: 5px 15px; cursor: pointer;">Change</label>
        </div>

        <div style="flex: 2;">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" value="<?= $user_data['nama'] ?? '' ?>" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= $user_data['email'] ?? '' ?>" required>
            
            <label for="password">Password (kosongkan jika tidak ingin diubah)</label>
            <input type="password" id="password" name="password" placeholder="********">
            
            <button type="submit" name="save_profile" class="pixel-button" style="float: right;">Save</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('profile_photo_upload').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile_img').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>

<?php get_footer(); ?>