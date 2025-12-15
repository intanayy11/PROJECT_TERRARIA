<?php
include 'db_config.php';

if (isset($_POST['signup'])) {
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    if (empty($nama) || empty($email) || empty($password)) {
        $_SESSION['error'] = "Semua field harus diisi.";
        header('Location: ../signup.php'); 
        exit;
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (nama, email, password_hash) VALUES ('$nama', '$email', '$password_hash')";

    if ($conn->query($sql) === TRUE) {
        $user_id = $conn->insert_id;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $nama;
        $_SESSION['success'] = "Pendaftaran berhasil! Selamat datang.";
        header('Location: ../homepage.php'); 
    } else {
        $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
        header('Location: ../signup.php'); 
    }
    exit;
}

if (isset($_POST['signin'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id, nama, password_hash FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nama'];
            $_SESSION['success'] = "";
            header('Location: ../homepage.php'); 
            exit;
        } else {
            $_SESSION['error'] = "Email atau Password salah.";
            header('Location: ../signin.php'); 
            exit;
        }
    } else {
        $_SESSION['error'] = "Email atau Password salah.";
        header('Location: ../signin.php'); 
        exit;
    }
}