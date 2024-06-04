<?php
include '../../assets/reusable/sesions.php';
include '../../assets/reusable/bd.php';

$userId = $_SESSION['user_id'];

$sql = "SELECT u.user_id, u.user_handle, u.first_name, u.profile_img,
               CASE WHEN f.follower_id IS NOT NULL THEN 1 ELSE 0 END as is_following
        FROM users u
        LEFT JOIN followers f ON u.user_id = f.following_id AND f.follower_id = $userId
        WHERE u.user_id != $userId";

$result = $db->query($sql);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = [
        'id' => $row['user_id'],
        'user_handle' => $row['user_handle'],
        'first_name' => $row['first_name'],
        'profile_img' => $row['profile_img'] ? '../assets/usersImg/' . $row['profile_img'] : '../assets/images/img/user.jpg',
        'is_following' => $row['is_following']
    ];
}

// Para depuración: imprimir los resultados antes de codificarlos en JSON
// Esto se debe eliminar en producción.
error_log(print_r($users, true));

echo json_encode($users);
?>
