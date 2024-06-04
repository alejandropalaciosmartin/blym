<?php
include '../../assets/reusable/sesions.php';
include '../../assets/reusable/bd.php';

$userId = $_SESSION['user_id'];
$unfollowUserId = $_GET['userId'];

if (!$unfollowUserId) {
    echo "Invalid user ID.";
    exit;
}

// Verificar si el usuario está siguiendo al usuario
$sqlCheck = "SELECT * FROM followers WHERE follower_id = $userId AND following_id = $unfollowUserId";
$resultCheck = $db->query($sqlCheck);
if ($resultCheck->num_rows === 0) {
    echo "You are not following this user.";
    exit;
}

// Eliminar el seguidor de la tabla followers
$sql = "DELETE FROM followers WHERE follower_id = $userId AND following_id = $unfollowUserId";
if ($db->query($sql) === TRUE) {
    echo "User unfollowed successfully.";
} else {
    echo "Error: " . $db->error;
}
?>