<?php
include '../../assets/reusable/bd.php';
$defaultImgPath = '../assets/images/img/user.jpg';

// Obtiene el término de búsqueda desde la URL
$query = isset($_GET['q']) ? $_GET['q'] : '';


$sql = empty($query) ?
       "SELECT * FROM users" :
       "SELECT * FROM users WHERE user_handle LIKE '%$query%' OR first_name LIKE '%$query%'";

$result = $db->query($sql);


// Comprueba si hay resultados y los muestra
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $handle = htmlspecialchars($row['user_handle']);
        $name = htmlspecialchars($row['first_name']);
        $imgPath = !empty($row['profile_img']) ? '../assets/usersImg/'.$row['profile_img'] : $defaultImgPath;
        
        echo "<div class='user-card'>
                <div class='user-details'>
                    <img src='$imgPath' alt='' class='user-image'>
                    <div class='user-info'>
                        <h4 class='user-handle'>$handle</h4>
                        <p class='user-name'>$name</p>
                    </div>
                </div>
                <button class='delete-btn' onclick='deleteUser({$row['user_id']})'>
                    <i class='fas fa-trash delete-icon'></i>
                </button>
              </div>";
    }
} else {
    echo "<div class='no-users'>No users found</div>";
}