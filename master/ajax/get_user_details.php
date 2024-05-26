<?php
include '../../assets/reusable/bd.php';

if (isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = [
            'handle' => htmlspecialchars($row['user_handle']),
            'name' => htmlspecialchars($row['first_name']),
            'imgPath' => !empty($row['profile_img']) ? '../assets/usersImg/'.$row['profile_img'] : '../assets/images/img/user.jpg'
        ];
        echo json_encode($response);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
    $stmt->close();
}
?>
