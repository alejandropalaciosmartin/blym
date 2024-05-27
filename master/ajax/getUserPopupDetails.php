<?php
include '../../assets/reusable/bd.php';

if (isset($_POST['id'])) {
    $userId = intval($_POST['id']);

    $sql = "SELECT u.user_handle, u.first_name, u.profile_img, u.follower_count, u.created_at, u.active, 
                   (SELECT COUNT(*) FROM followers WHERE follower_id = ?) as following_count, 
                   (SELECT COUNT(*) FROM posts WHERE user_id = ?) as post_count
            FROM users u
            WHERE u.user_id = ?";
            
    $stmt = $db->prepare($sql);
    $stmt->bind_param("iii", $userId, $userId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = [
            'handle' => htmlspecialchars($row['user_handle']),
            'name' => htmlspecialchars($row['first_name']),
            'imgPath' => !empty($row['profile_img']) ? '../assets/usersImg/'.$row['profile_img'] : '../assets/images/img/user.jpg',
            'followerCount' => $row['follower_count'],
            'followingCount' => $row['following_count'],
            'postCount' => $row['post_count'],
            'createdAt' => $row['created_at'],
            'active' => $row['active'],
        ];
        echo json_encode($response);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
    $stmt->close();
}