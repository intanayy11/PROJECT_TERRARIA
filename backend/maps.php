<?php
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['activity']) && isset($_POST['map_id'])) {
    $user_id = (int)$_SESSION['user_id'];
    $map_id = (int)$_POST['map_id'];
    $activity = trim($_POST['activity']);

    if (!empty($activity)) {
        $stmt = $conn->prepare("INSERT INTO map_activities (map_id, user_id, activity_text) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $map_id, $user_id, $activity);
        $stmt->execute();
        $stmt->close();

        $_SESSION['success'] = 'Activity added successfully!';
    } else {
        $_SESSION['error'] = 'Activity cannot be empty.';
    }
}

header('Location: ../maps.php#map' . $map_id);
exit;
?>