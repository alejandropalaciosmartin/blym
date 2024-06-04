<?php
include '../../assets/reusable/sesions.php';
include '../../assets/reusable/bd.php';

$userId = $_SESSION['user_id'];

$sql = "SELECT u.user_id, u.user_handle, u.profile_img, u.first_name
        FROM users u 
        LEFT JOIN followers f ON u.user_id = f.following_id AND f.follower_id = $userId
        WHERE f.follower_id IS NOT NULL";

$result = $db->query($sql);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = [
        'id' => $row['user_id'],
        'user_handle' => $row['user_handle'],
        'first_name' => $row['first_name'],
        'profile_img' => $row['profile_img'] ? '../assets/usersImg/' . $row['profile_img'] : '../assets/images/img/user.jpg',
        'is_following' => 1
    ];
}

if (empty($users)) {
    echo json_encode(['message' => 'No sigues a nadie.']);
} else {
    echo json_encode($users);
}
?>
