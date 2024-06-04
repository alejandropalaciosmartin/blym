<?php
include '../../assets/reusable/sesions.php';
include '../../assets/reusable/bd.php';

$userId = $_SESSION['user_id'];
$followedUserId = $_GET['userId'];

if (!$followedUserId) {
    echo "Invalid user ID.";
    exit;
}

// Verificar que el usuario no se esté siguiendo a sí mismo
if ($userId == $followedUserId) {
    echo "You cannot follow yourself.";
    exit;
}

// Verificar si ya sigue al usuario
$sqlCheck = "SELECT * FROM followers WHERE follower_id = $userId AND following_id = $followedUserId";
$resultCheck = $db->query($sqlCheck);
if ($resultCheck->num_rows > 0) {
    echo "You are already following this user.";
    exit;
}

// Insertar el nuevo seguidor en la tabla followers
$sql = "INSERT INTO followers (follower_id, following_id) VALUES ($userId, $followedUserId)";
if ($db->query($sql) === TRUE) {
    echo "User followed successfully.";
} else {
    echo "Error: " . $db->error;
}
?>